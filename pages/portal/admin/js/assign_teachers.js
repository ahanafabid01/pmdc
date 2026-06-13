document.addEventListener('DOMContentLoaded', () => {
    
    // Elements
    const btnOpenModal   = document.getElementById('btnOpenModal');
    const closeModal     = document.getElementById('closeModal');
    const btnCancelModal = document.getElementById('btnCancelModal');
    const assignmentModal = document.getElementById('assignmentModal');
    
    const assignStaffId   = document.getElementById('assignStaffId');
    const assignClassType = document.getElementById('assignClassType');
    const assignClassId   = document.getElementById('assignClassId');
    const assignSubjectId = document.getElementById('assignSubjectId');
    const btnAddAssignment = document.getElementById('btnAddAssignment');
    const assignLoginInfo  = document.getElementById('assignLoginInfo');
    
    const assignTableBody     = document.getElementById('assignTableBody');
    const searchAssignments   = document.getElementById('searchAssignments');
    const tmToast             = document.getElementById('tmToast');

    // Stats
    const statTotalAssignments = document.getElementById('statTotalAssignments');
    const statTotalTeachers    = document.getElementById('statTotalTeachers');
    const statTotalSubjects    = document.getElementById('statTotalSubjects');
    const statTotalPrograms    = document.getElementById('statTotalPrograms');

    let allAssignments     = [];
    let allClasses         = [];
    let programSubjectsMap = {}; // program_id -> [{value, label, subject, paper, code}]

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
        assignStaffId.value   = '';
        assignClassType.value = '';
        assignClassId.innerHTML   = '<option value="">-- Select Class/Program --</option>';
        assignSubjectId.innerHTML = '<option value="">-- Select Subject & Paper --</option>';
        assignClassId.value   = '';
        assignSubjectId.value = '';
        assignLoginInfo.style.display = 'none';
        assignLoginInfo.innerHTML     = '';
    };
    
    closeModal.addEventListener('click', closeOverlay);
    btnCancelModal.addEventListener('click', closeOverlay);
    assignmentModal.addEventListener('click', (e) => {
        if (e.target === assignmentModal) closeOverlay();
    });

    // Toast
    function showToast(msg, isError = false) {
        tmToast.innerHTML  = isError ? `<i class="fas fa-times-circle"></i> ${msg}` : `<i class="fas fa-check-circle"></i> ${msg}`;
        tmToast.className  = 'tm-toast show' + (isError ? ' error' : ' success');
        setTimeout(() => tmToast.classList.remove('show'), 3500);
    }

    function esc(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // ── Load metadata (classes + subjects with paper expansion) ──
    async function loadMetadata() {
        try {
            const res  = await fetch(window.BASE_URL + `/pages/portal/admin/api/assign_teacher.php?action=meta`);
            const data = await res.json();
            if (data.ok) {
                allClasses         = data.classes;
                programSubjectsMap = data.program_subjects; // Now has paper-expanded entries
            }
        } catch(e) {
            console.error("Failed to load metadata", e);
        }
    }

    // ── Class type change → populate class dropdown ──
    assignClassType.addEventListener('change', () => {
        const type = assignClassType.value.toLowerCase();
        assignSubjectId.innerHTML = '<option value="">-- Select Subject & Paper --</option>';
        if (!type) {
            assignClassId.innerHTML = '<option value="">-- Select Class/Program --</option>';
            return;
        }
        const filtered = allClasses.filter(c => c.type && c.type.toLowerCase() === type);
        assignClassId.innerHTML = '<option value="">-- Select Class/Program --</option>' + 
            filtered.map(c => `<option value="${esc(c.id)}">${esc(c.name)}</option>`).join('');
    });

    // ── Class change → populate subject+paper dropdown ──
    assignClassId.addEventListener('change', () => {
        const pId = assignClassId.value;
        if (!pId || !programSubjectsMap[pId]) {
            assignSubjectId.innerHTML = '<option value="">-- Select Subject & Paper --</option>';
            return;
        }
        const subs = programSubjectsMap[pId];

        // Group by subject name for optgroups
        const groups = {};
        subs.forEach(s => {
            const subKey = s.subject.replace(/\s*\(.*?\)\s*/g, '').trim();
            if (!groups[subKey]) groups[subKey] = [];
            groups[subKey].push(s);
        });

        let html = '<option value="">-- Select Subject & Paper --</option>';
        Object.entries(groups).forEach(([subName, papers]) => {
            if (papers.length === 1 && papers[0].paper === 'only') {
                // Single paper — still use optgroup so the name is bold like multi-paper subjects
                const s = papers[0];
                const codeLabel = s.code ? ` [${s.code}]` : '';
                html += `<optgroup label="${esc(subName)}">`;
                html += `<option value="${esc(s.value)}" data-subject="${esc(s.subject)}" data-paper="${esc(s.paper)}">${esc(subName)}${codeLabel}</option>`;
                html += `</optgroup>`;
            } else {
                // Multi-paper — optgroup with 1st / 2nd paper options
                html += `<optgroup label="${esc(subName)}">`;
                papers.forEach(s => {
                    const paperLabel = s.paper === '1st' ? `1st Paper [${s.code}]` : `2nd Paper [${s.code}]`;
                    html += `<option value="${esc(s.value)}" data-subject="${esc(s.subject)}" data-paper="${esc(s.paper)}">${esc(paperLabel)}</option>`;
                });
                html += `</optgroup>`;
            }
        });

        assignSubjectId.innerHTML = html;
    });

    // ── Load teacher list ──
    async function loadTeachers() {
        try {
            const res  = await fetch(window.BASE_URL + `/pages/portal/admin/api/staff.php?action=list`);
            const data = await res.json();
            if (data.ok) {
                const teachers = data.staff.filter(s => s.category.toLowerCase() === 'teacher');
                assignStaffId.innerHTML = '<option value="">-- Select Teacher --</option>' + 
                    teachers.map(t => {
                        const email = t.email && t.email !== 'N/A' ? t.email : '';
                        return `<option value="${esc(t.id)}" data-name="${esc(t.name)}" data-email="${esc(email)}">${esc(t.name)} (${esc(email || 'No Email')})</option>`;
                    }).join('');
            }
        } catch(e) {
            console.error("Failed to load teachers", e);
        }
    }

    // ── Load assignments list ──
    async function loadAssignments() {
        assignTableBody.innerHTML = '<tr class="tm-empty-row"><td colspan="6"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>';
        try {
            const res  = await fetch(window.BASE_URL + `/pages/portal/admin/api/assign_teacher.php?action=list_all`);
            const data = await res.json();
            if (data.ok) {
                allAssignments = data.assignments;
                updateStats();
                renderAssignments(allAssignments);
            }
        } catch(e) {
            assignTableBody.innerHTML = '<tr class="tm-empty-row"><td colspan="6">Failed to load data.</td></tr>';
        }
    }

    function updateStats() {
        statTotalAssignments.textContent = allAssignments.length;
        const uniqueTeachers  = new Set(allAssignments.map(a => a.staff_id)).size;
        const uniquePrograms  = new Set(allAssignments.map(a => a.class_name)).size;
        const uniqueSubjects  = new Set(allAssignments.map(a => a.subject_name)).size;
        statTotalTeachers.textContent = uniqueTeachers;
        statTotalPrograms.textContent = uniquePrograms;
        statTotalSubjects.textContent = uniqueSubjects;
    }

    function paperBadge(paper) {
        if (!paper || paper === 'only') return '';
        const isFirst  = paper === '1st';
        const bg       = isFirst ? '#dbeafe' : '#ede9fe';
        const color    = isFirst ? '#1e40af' : '#5b21b6';
        const label    = isFirst ? '1st Paper' : '2nd Paper';
        return `<span style="font-size:0.7rem;font-weight:700;background:${bg};color:${color};border-radius:5px;padding:2px 7px;margin-left:6px;">${label}</span>`;
    }

    function renderAssignments(list) {
        if (list.length === 0) {
            assignTableBody.innerHTML = '<tr class="tm-empty-row"><td colspan="6"><i class="fas fa-folder-open"></i> No assignments found.</td></tr>';
            return;
        }

        assignTableBody.innerHTML = list.map(a => {
            const subjectName = a.subject_name.replace(/\s*\(.*?\)\s*/g, '').trim();
            
            let paperCell = '<span style="font-size:0.8rem;color:#94a3b8;">—</span>';
            if (a.paper === '1st') {
                paperCell = `<span style="font-size:0.75rem;font-weight:700;background:#dbeafe;color:#1e40af;border-radius:5px;padding:3px 9px;white-space:nowrap;">1st Paper</span>`;
            } else if (a.paper === '2nd') {
                paperCell = `<span style="font-size:0.75rem;font-weight:700;background:#ede9fe;color:#5b21b6;border-radius:5px;padding:3px 9px;white-space:nowrap;">2nd Paper</span>`;
            }
            
            return `
            <tr>
                <td>
                    <div class="tm-staff-name" style="font-weight:600;">${esc(a.staff_name)}</div>
                </td>
                <td>
                    <div style="color:#64748b;font-size:0.85rem;">${esc(a.staff_id)}</div>
                </td>
                <td><span class="cat-badge cat-program">${esc(a.class_name)}</span></td>
                <td><span class="cat-badge cat-subject">${esc(subjectName)}</span></td>
                <td>${paperCell}</td>
                <td>
                    <button class="btn-del" onclick="deleteAssignment(${a.id})" title="Remove Assignment">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `}).join('');
    }

    // ── Search ──
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

    // ── Add Assignment ──
    btnAddAssignment.addEventListener('click', async () => {
        const staffOpt   = assignStaffId.options[assignStaffId.selectedIndex];
        const staffId    = assignStaffId.value;
        const staffName  = staffOpt ? staffOpt.getAttribute('data-name') : '';
        const staffEmail = staffOpt ? staffOpt.getAttribute('data-email') : '';
        const classType  = assignClassType.value;
        const classId    = assignClassId.value;
        const subjectVal = assignSubjectId.value; // Format: "Physics (xxx)||1st"
        const subjectOpt = assignSubjectId.options[assignSubjectId.selectedIndex];
        const subjectName = subjectOpt ? subjectOpt.getAttribute('data-subject') : '';
        const paper       = subjectOpt ? subjectOpt.getAttribute('data-paper') : '';

        if (!staffId || !classType || !classId || !subjectVal) {
            showToast("Please fill all fields", true);
            return;
        }
        if (!staffEmail) {
            showToast("Teacher must have an email address set in their profile", true);
            return;
        }

        btnAddAssignment.disabled  = true;
        btnAddAssignment.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

        try {
            const res = await fetch(window.BASE_URL + `/pages/portal/admin/api/assign_teacher.php?action=add`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    staff_id:   staffId,
                    staff_name: staffName,
                    class_id:   classId,
                    subject_id: subjectName,   // Clean subject name stored in DB
                    paper:      paper          // '1st', '2nd', or 'only'
                })
            });
            const data = await res.json();
            
            if (data.ok) {
                showToast("Assignment created successfully ✓");
                if (data.loginCreated) {
                    assignLoginInfo.style.display = 'block';
                    assignLoginInfo.innerHTML = `<strong>New Teacher Account Created!</strong><br><b>Email:</b> <code>${staffEmail}</code><br><b>Password:</b> <code>password123</code>`;
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
            btnAddAssignment.disabled  = false;
            btnAddAssignment.innerHTML = '<i class="fas fa-save"></i> Save Assignment';
        }
    });

    // ── Delete Assignment ──
    window.deleteAssignment = async (id) => {
        if (!confirm("Are you sure you want to remove this assignment?")) return;
        try {
            const res  = await fetch(window.BASE_URL + `/pages/portal/admin/api/assign_teacher.php?action=delete&id=${id}`);
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
