/* ═══════════════════════════════════════════════════════════
   assign_teachers.js
   Logic for managing teacher assignments independently.
═══════════════════════════════════════════════════════════ */

const assignStaffId = document.getElementById('assignStaffId');
const assignClassId = document.getElementById('assignClassId');
const assignSubjectId = document.getElementById('assignSubjectId');
const btnAddAssignment = document.getElementById('btnAddAssignment');
const assignTableBody = document.getElementById('assignTableBody');
const assignLoginInfo = document.getElementById('assignLoginInfo');
const searchAssignments = document.getElementById('searchAssignments');
const tmToast = document.getElementById('tmToast');

let allAssignments = [];
let allStaff = [];

// Base UI events
document.getElementById('menuToggle').addEventListener('click', () => {
    document.getElementById('sidebar').classList.add('active');
    document.getElementById('sidebarOverlay').classList.add('active');
});

document.getElementById('closeSidebar').addEventListener('click', closeSidebar);
document.getElementById('sidebarOverlay').addEventListener('click', closeSidebar);

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('active');
    document.getElementById('sidebarOverlay').classList.remove('active');
}

function showToast(msg, type = 'success') {
    tmToast.innerHTML = type === 'success' 
        ? `<i class="fas fa-check-circle"></i> ${msg}`
        : `<i class="fas fa-exclamation-circle"></i> ${msg}`;
    tmToast.className = `tm-toast show ${type}`;
    setTimeout(() => { tmToast.classList.remove('show'); }, 3000);
}

// Escaping
function escHtml(str) {
    if (!str) return '';
    const div = document.createElement('div');
    div.innerText = str;
    return div.innerHTML;
}

// Initial Data Load
async function init() {
    await loadStaffList();
    await loadMetadata();
    await loadAllAssignments();
}

async function loadStaffList() {
    try {
        const res = await fetch('api/staff.php?action=list');
        const data = await res.json();
        if (data.ok) {
            allStaff = data.staff;
            assignStaffId.innerHTML = '<option value="">-- Select Teacher --</option>' + 
                data.staff.map(s => `<option value="${s.id}">${s.name} (${s.designation})</option>`).join('');
        }
    } catch(e) {
        console.error("Failed to load staff", e);
        assignStaffId.innerHTML = '<option value="">Error loading teachers</option>';
    }
}

async function loadMetadata() {
    try {
        const res = await fetch('api/assign_teacher.php?action=meta');
        const data = await res.json();
        if (data.ok) {
            assignClassId.innerHTML = '<option value="">-- Select Class --</option>' + 
                data.classes.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
            assignSubjectId.innerHTML = '<option value="">-- Select Subject --</option>' + 
                data.subjects.map(s => `<option value="${s.id}">${s.name}</option>`).join('');
        }
    } catch(e) {
        console.error("Failed to load metadata", e);
    }
}

async function loadAllAssignments() {
    try {
        const res = await fetch('api/assign_teacher.php?action=list_all');
        const data = await res.json();
        if (data.ok) {
            allAssignments = data.assignments;
            renderAssignments();
        } else {
            // Wait, we need an endpoint for listing ALL assignments, or we modify the API.
            // If action=list without staff_id returns all, let's try that.
            // Let's implement fallback if list_all fails.
        }
    } catch(e) {
        console.error("Failed to load assignments", e);
    }
}

function renderAssignments() {
    const query = searchAssignments.value.toLowerCase();
    const filtered = allAssignments.filter(a => 
        a.staff_name.toLowerCase().includes(query) || 
        a.class_name.toLowerCase().includes(query) || 
        a.subject_name.toLowerCase().includes(query)
    );

    if (filtered.length === 0) {
        assignTableBody.innerHTML = '<tr><td colspan="4" class="text-center">No assignments found.</td></tr>';
        return;
    }

    assignTableBody.innerHTML = filtered.map(a => `
        <tr>
            <td>
                <div style="font-weight: 600;">${escHtml(a.staff_name)}</div>
                <div style="font-size: 0.8rem; color: #64748b;">ID: ${a.staff_id}</div>
            </td>
            <td>${escHtml(a.class_name)}</td>
            <td>${escHtml(a.subject_name)}</td>
            <td style="text-align: center;">
                <button type="button" class="btn-del" onclick="deleteAssignment(${a.id})" title="Delete Assignment">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

searchAssignments.addEventListener('input', renderAssignments);

// Add Assignment
btnAddAssignment.addEventListener('click', async () => {
    const staffId = assignStaffId.value;
    const classId = assignClassId.value;
    const subjectId = assignSubjectId.value;

    if (!staffId || !classId || !subjectId) {
        showToast('Please select Teacher, Class, and Subject.', 'error');
        return;
    }

    const staffObj = allStaff.find(s => s.id == staffId);
    const staffName = staffObj ? staffObj.name : 'Unknown';

    const originalText = btnAddAssignment.innerHTML;
    btnAddAssignment.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    btnAddAssignment.disabled = true;
    assignLoginInfo.style.display = 'none';

    try {
        const res = await fetch('api/assign_teacher.php?action=add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                staff_id: staffId,
                staff_name: staffName,
                class_id: classId,
                subject_id: subjectId
            })
        });
        const data = await res.json();
        if (data.ok) {
            showToast(data.msg);
            // Reload all assignments
            await loadAllAssignments();
            
            // Show login info if account created
            if (data.loginCreated) {
                assignLoginInfo.style.display = 'block';
                assignLoginInfo.innerHTML = `<strong><i class="fas fa-user-check"></i> Portal Account Created!</strong><br>Teacher Login ID: <code>${staffId}</code><br>Password: <code>password123</code>`;
            }
        } else {
            showToast(data.msg, 'error');
        }
    } catch(e) {
        showToast('Network error', 'error');
    }

    btnAddAssignment.innerHTML = originalText;
    btnAddAssignment.disabled = false;
});

window.deleteAssignment = async function(id) {
    if (!confirm("Are you sure you want to remove this assignment?")) return;
    
    try {
        const res = await fetch(`api/assign_teacher.php?action=delete&id=${id}`);
        const data = await res.json();
        if (data.ok) {
            showToast('Assignment removed successfully.');
            await loadAllAssignments();
        } else {
            showToast('Failed to delete assignment', 'error');
        }
    } catch(e) {
        showToast('Network error', 'error');
    }
};

// Fire
init();
