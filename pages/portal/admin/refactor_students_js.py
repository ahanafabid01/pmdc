import os
import re

js_path = r"c:\xampp\htdocs\pmdc\pages\portal\admin\js\students.js"

with open(js_path, "r", encoding="utf-8") as f:
    content = f.read()

# 1. Remove mock generation and local storage
content = re.sub(r'const STUDENTS_STORAGE_KEY.*?(?=\nlet allStudents)', '', content, flags=re.DOTALL)
content = re.sub(r'function generateStudents\(\) \{.*?(?=\n/\* ═══════════════════════════════════════════════════)', '', content, flags=re.DOTALL)
content = re.sub(r'function loadStudentsFromStorage\(\) \{.*?(?=\nlet allStudents)', '', content, flags=re.DOTALL)
content = re.sub(r'function persistStudentsToStorage\(\) \{.*?(?=\nlet allStudents)', '', content, flags=re.DOTALL)

# 2. Add API URL and rewrite state variables
state_vars = """const API_URL = 'api-students.php';

let allStudents     = [];
let filtered        = [];
let currentPage     = 1;
const PAGE_SIZE     = 15;
let viewMode        = 'table';
let deleteTargetId  = null;

async function fetchStudents() {
    $('tableInfo').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading students from database...';
    try {
        const res = await fetch(API_URL);
        const json = await res.json();
        if (json.success) {
            allStudents = json.data;
            applyFilters();
        } else {
            console.error(json.error);
            $('tableInfo').textContent = 'Failed to load students.';
        }
    } catch (e) {
        console.error(e);
        $('tableInfo').textContent = 'Error connecting to database.';
    }
}

// Initial fetch
fetchStudents();
"""

content = re.sub(r'let allStudents\s*=\s*loadStudentsFromStorage\(\);.*?(?=\n/\* ═══════════════════════════════════════════════════\n   DOM HELPERS)', state_vars, content, flags=re.DOTALL)

# 3. Rewrite Save logic
# Find the studentForm event listener and rewrite it completely
save_regex = r"\$\('studentForm'\)\.addEventListener\('submit', function\(e\) \{.*?(?=\n/\* ═══════════════════════════════════════════════════\n   DELETE STUDENT)"

new_save_logic = """$('studentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    if (!validateForm()) {
        const firstErr = document.querySelector('.err:not(:empty)');
        if (firstErr) {
            const section = firstErr.closest('.form-section');
            if (section) {
                const sectionId = section.id.replace('section-','');
                document.querySelectorAll('.ftab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
                document.querySelector(`.ftab[data-section="${sectionId}"]`)?.classList.add('active');
                section.classList.add('active');
            }
        }
        return;
    }

    const editId = $('editStudentId').value;
    const fn     = $('fname').value.trim().split(' ');

    const studentData = {
        name:         $('fname').value.trim(),
        initials:     ($('fname').value.trim().split(' ').map(w => w[0]).join('').slice(0,2)).toUpperCase(),
        roll:         $('roll').value.trim(),
        regno:        $('regno').value.trim(),
        year:         $('hscYear').value,
        group:        $('group').value,
        optionalSubject: $('optionalSubject').value || OPTIONAL_SUBJECTS[$('group').value]?.[0]?.value || '',
        section:      $('section').value || 'A',
        session:      $('session').value.trim() || '2024–2025',
        institution:  $('institution').value.trim(),

        dob:          $('dob').value,
        gender:       $('gender').value,
        religion:     $('religion').value,
        bloodGroup:   $('bloodGroup').value,
        nid:          $('nid').value.trim(),
        birthCert:    $('birthCert').value.trim(),

        phone:        $('phone').value.trim(),
        email:        $('email').value.trim(),
        presentAddr:  $('presentAddr').value.trim(),
        permanentAddr:$('permanentAddr').value.trim(),

        fatherName:   $('fatherName').value.trim(),
        fatherNid:    $('fatherNid').value.trim(),
        fatherPhone:  $('fatherPhone').value.trim(),
        fatherOcc:    $('fatherOcc').value.trim(),
        motherName:   $('motherName').value.trim(),
        motherNid:    $('motherNid').value.trim(),
        motherPhone:  $('motherPhone').value.trim(),
        motherOcc:    $('motherOcc').value.trim(),
        guardianName: $('guardianName').value.trim(),
        guardianPhone:$('guardianPhone').value.trim(),
        guardianRel:  $('guardianRel').value.trim(),
        photoUrl:     null,
    };

    const method = editId ? 'PUT' : 'POST';
    if (editId) {
        studentData.id = editId;
    } else {
        studentData.id = `stu-${Date.now()}`;
        studentData.color = AVATAR_COLORS[allStudents.length % AVATAR_COLORS.length];
        studentData.addedDate = new Date().toISOString().split('T')[0];
    }

    const submitBtn = this.querySelector('.btn-save');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    submitBtn.disabled = true;

    try {
        const res = await fetch(API_URL, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(studentData)
        });
        const json = await res.json();
        
        if (json.success) {
            showToast(`Student "${studentData.name}" saved to database!`);
            $('addEditModal').classList.remove('open');
            fetchStudents(); // Reload from DB
        } else {
            alert('Database Error: ' + json.error);
        }
    } catch (err) {
        alert('Network error connecting to database.');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});
"""

content = re.sub(save_regex, new_save_logic, content, flags=re.DOTALL)

# 4. Rewrite Delete logic
delete_regex = r"\$\('confirmDelete'\)\.addEventListener\('click', \(\) => \{.*?(?=\n\}\);)"

new_delete_logic = """$('confirmDelete').addEventListener('click', async () => {
    if (!deleteTargetId) return;
    
    const delBtn = $('confirmDelete');
    const originalText = delBtn.innerHTML;
    delBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
    delBtn.disabled = true;

    try {
        const res = await fetch(API_URL, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: deleteTargetId })
        });
        const json = await res.json();
        
        if (json.success) {
            showToast('Student deleted from database.');
            $('deleteModal').classList.remove('open');
            deleteTargetId = null;
            fetchStudents(); // Reload from DB
        } else {
            alert('Database Error: ' + json.error);
        }
    } catch (err) {
        alert('Network error while deleting.');
    } finally {
        delBtn.innerHTML = originalText;
        delBtn.disabled = false;
    }
"""

content = re.sub(delete_regex, new_delete_logic, content, flags=re.DOTALL)

with open(js_path, "w", encoding="utf-8") as f:
    f.write(content)

print(f"Refactored {js_path}")
