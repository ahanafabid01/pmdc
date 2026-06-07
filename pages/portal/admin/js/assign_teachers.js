document.addEventListener('DOMContentLoaded', () => {
    
    // Elements
    const btnOpenModal = document.getElementById('btnOpenModal');
    const closeModal = document.getElementById('closeModal');
    const btnCancelModal = document.getElementById('btnCancelModal');
    const assignmentModal = document.getElementById('assignmentModal');
    
    const assignStaffId = document.getElementById('assignStaffId');
    const assignClassId = document.getElementById('assignClassId');
    const assignSubjectId = document.getElementById('assignSubjectId');
    const btnAddAssignment = document.getElementById('btnAddAssignment');
    const assignLoginInfo = document.getElementById('assignLoginInfo');
    
    const assignTableBody = document.getElementById('assignTableBody');
    const searchAssignments = document.getElementById('searchAssignments');
    const tmToast = document.getElementById('tmToast');

    // Stats
    const statTotalAssignments = document.getElementById('statTotalAssignments');
    const statTotalTeachers = document.getElementById('statTotalTeachers');
    const statTotalSubjects = document.getElementById('statTotalSubjects');
    const statTotalPrograms = document.getElementById('statTotalPrograms');

    let allAssignments = [];
    let programSubjectsMap = {};

    // Init
    loadMetadata();
    loadTeachers();
    loadAssignments();

    // Modal Events
    btnOpenModal.addEventListener('click', () => {
        assignmentModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
    
    const closeOverlay = () => {
        assignmentModal.classList.remove('active');
        document.body.style.overflow = '';
        // Reset form
        assignStaffId.value = '';
        assignClassId.value = '';
        assignSubjectId.value = '';
        assignLoginInfo.style.display = 'none';
        assignLoginInfo.innerHTML = '';
    };
    
    closeModal.addEventListener('click', closeOverlay);
    btnCancelModal.addEventListener('click', closeOverlay);
    assignmentModal.addEventListener('click', (e) => {
        if(e.target === assignmentModal) closeOverlay();
    });

    // Toast
    function showToast(msg, isError = false) {
        tmToast.innerHTML = isError ? `<i class="fas fa-times-circle"></i> ${msg}` : `<i class="fas fa-check-circle"></i> ${msg}`;
        tmToast.className = 'tm-toast show' + (isError ? ' error' : ' success');
        setTimeout(() => tmToast.classList.remove('show'), 3000);
    }

    // Escape HTML
    function esc(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    async function loadMetadata() {
        try {
            const res = await fetch(window.BASE_URL + `/pages/portal/admin/api/assign_teacher.php?action=meta`);
            const data = await res.json();
            if (data.ok) {
                assignClassId.innerHTML = '<option value="">-- Select Class/Program --</option>' + 
                    data.classes.map(c => `<option value="${esc(c.id)}">${esc(c.name)}</option>`).join('');
                programSubjectsMap = data.program_subjects;
            }
        } catch(e) {
            console.error("Failed to load metadata", e);
        }
    }

    assignClassId.addEventListener('change', () => {
        const pId = assignClassId.value;
        if (!pId || !programSubjectsMap[pId]) {
            assignSubjectId.innerHTML = '<option value="">-- Select Subject --</option>';
            return;
        }
        const subs = programSubjectsMap[pId];
        assignSubjectId.innerHTML = '<option value="">-- Select Subject --</option>' + 
            subs.map(s => `<option value="${esc(s)}">${esc(s)}</option>`).join('');
    });

    async function loadTeachers() {
        try {
            const res = await fetch(window.BASE_URL + `/pages/portal/admin/api/staff.php?action=list`);
            const data = await res.json();
            if (data.ok) {
                const teachers = data.staff.filter(s => s.category.toLowerCase() === 'teacher');
                assignStaffId.innerHTML = '<option value="">-- Select Teacher --</option>' + 
                    teachers.map(t => {
                        const username = "T" + String(t.id).padStart(4, '0');
                        return `<option value="${username}" data-name="${esc(t.name)}">${esc(t.name)} (${username})</option>`;
                    }).join('');
            }
        } catch(e) {
            console.error("Failed to load teachers", e);
        }
    }

    async function loadAssignments() {
        assignTableBody.innerHTML = '<tr class="tm-empty-row"><td colspan="4"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>';
        try {
            const res = await fetch(window.BASE_URL + `/pages/portal/admin/api/assign_teacher.php?action=list_all`);
            const data = await res.json();
            if (data.ok) {
                allAssignments = data.assignments;
                updateStats();
                renderAssignments(allAssignments);
            }
        } catch(e) {
            assignTableBody.innerHTML = '<tr class="tm-empty-row"><td colspan="4">Failed to load data.</td></tr>';
        }
    }

    function updateStats() {
        statTotalAssignments.textContent = allAssignments.length;
        const uniqueTeachers = new Set(allAssignments.map(a => a.staff_id)).size;
        const uniquePrograms = new Set(allAssignments.map(a => a.class_name)).size;
        const uniqueSubjects = new Set(allAssignments.map(a => a.subject_name)).size;
        statTotalTeachers.textContent = uniqueTeachers;
        statTotalPrograms.textContent = uniquePrograms;
        statTotalSubjects.textContent = uniqueSubjects;
    }

    function renderAssignments(list) {
        if (list.length === 0) {
            assignTableBody.innerHTML = '<tr class="tm-empty-row"><td colspan="4"><i class="fas fa-folder-open"></i> No assignments found.</td></tr>';
            return;
        }

        assignTableBody.innerHTML = list.map(a => `
            <tr>
                <td>
                    <div class="tm-staff-cell">
                        <div class="tm-staff-name">${esc(a.staff_name)}</div>
                        <div class="tm-staff-id">ID: ${esc(a.staff_id)}</div>
                    </div>
                </td>
                <td><span class="cat-badge cat-program">${esc(a.class_name)}</span></td>
                <td><span class="cat-badge cat-subject">${esc(a.subject_name)}</span></td>
                <td>
                    <button class="btn-del" onclick="deleteAssignment(${a.id})" title="Remove Assignment">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    }

    // Search
    searchAssignments.addEventListener('input', (e) => {
        const q = e.target.value.toLowerCase();
        const filtered = allAssignments.filter(a => 
            a.staff_name.toLowerCase().includes(q) ||
            a.class_name.toLowerCase().includes(q) ||
            a.subject_name.toLowerCase().includes(q) ||
            a.staff_id.toLowerCase().includes(q)
        );
        renderAssignments(filtered);
    });

    // Add Assignment
    btnAddAssignment.addEventListener('click', async () => {
        const staffOpt = assignStaffId.options[assignStaffId.selectedIndex];
        const staffId = assignStaffId.value;
        const staffName = staffOpt ? staffOpt.getAttribute('data-name') : '';
        const classId = assignClassId.value;
        const subjectId = assignSubjectId.value;

        if (!staffId || !classId || !subjectId) {
            showToast("Please fill all fields", true);
            return;
        }

        btnAddAssignment.disabled = true;
        btnAddAssignment.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

        try {
            const res = await fetch(window.BASE_URL + `/pages/portal/admin/api/assign_teacher.php?action=add`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ staff_id: staffId, staff_name: staffName, class_id: classId, subject_id: subjectId })
            });
            const data = await res.json();
            
            if (data.ok) {
                showToast("Assignment created successfully");
                if (data.loginCreated) {
                    assignLoginInfo.style.display = 'block';
                    assignLoginInfo.innerHTML = `New Teacher Account Created!<br><b>Username:</b> <code>${staffId}</code><br><b>Password:</b> <code>password123</code>`;
                } else {
                    closeOverlay();
                }
                loadAssignments();
            } else {
                showToast(data.msg || "Failed to add", true);
            }
        } catch(e) {
            showToast("Network error", true);
        } finally {
            btnAddAssignment.disabled = false;
            btnAddAssignment.innerHTML = '<i class="fas fa-save"></i> Save Assignment';
        }
    });

    // Delete Assignment
    window.deleteAssignment = async (id) => {
        if (!confirm("Are you sure you want to remove this assignment?")) return;
        try {
            const res = await fetch(window.BASE_URL + `/pages/portal/admin/api/assign_teacher.php?action=delete&id=${id}`);
            const data = await res.json();
            if (data.ok) {
                showToast("Assignment removed");
                loadAssignments();
            } else {
                showToast("Failed to delete", true);
            }
        } catch(e) {
            showToast("Network error", true);
        }
    };
});
