/**
 * results.js - Public Results Portal
 */
'use strict';

const $ = id => document.getElementById(id);

let allExams = [];

async function loadExams() {
    try {
        const res = await fetch('api/public_results.php?action=exams');
        const data = await res.json();
        if (data.ok) {
            allExams = data.exams || [];
            if ($('examSelect')) {
                $('examSelect').innerHTML = '<option value="">Select Class Year First</option>';
            }
            if ($('classSelect')) {
                $('classSelect').innerHTML = '<option value="">Select Class</option>' + 
                    (data.classes || []).map(c => `<option value="${c}">${c}</option>`).join('');
            }
            if ($('sessionSelect')) {
                $('sessionSelect').innerHTML = '<option value="">Select Session</option>' + 
                    (data.sessions || []).map(s => `<option value="${s}">${s}</option>`).join('');
            }
            if ($('groupSelect')) {
                $('groupSelect').innerHTML = '<option value="">Select Group</option>' + 
                    (data.groups || []).map(g => `<option value="${g}">${g.charAt(0).toUpperCase() + g.slice(1)}</option>`).join('');
            }
            if ($('yearSelect')) {
                $('yearSelect').innerHTML = '<option value="">Select Class Year</option>' + 
                    (data.years || []).map(y => `<option value="${y}">${y}</option>`).join('');

                $('yearSelect').addEventListener('change', (e) => {
                    const year = e.target.value.toLowerCase();
                    let filteredExams = [];
                    
                    if (year.includes('1st')) {
                        filteredExams = allExams.filter(ex => 
                            ex.name.toLowerCase().includes('half') || 
                            ex.name.toLowerCase().includes('change')
                        );
                    } else if (year.includes('2nd')) {
                        filteredExams = allExams.filter(ex => 
                            ex.name.toLowerCase().includes('test') || 
                            ex.name.toLowerCase().includes('final')
                        );
                    } else {
                        filteredExams = allExams;
                    }

                    if (!year) {
                        $('examSelect').innerHTML = '<option value="">Select Class Year First</option>';
                    } else if (filteredExams.length === 0) {
                        $('examSelect').innerHTML = '<option value="">No exams published yet</option>';
                    } else {
                        $('examSelect').innerHTML = '<option value="">Select Examination</option>' + 
                            filteredExams.map(ex => `<option value="${ex.id}">${ex.name} (${ex.year})</option>`).join('');
                    }
                });
            }
        }
    } catch (e) {
        console.error(e);
    }
}

$('resultSearchForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const examId = $('examSelect').value;
    const roll = $('rollInput').value.trim();

    if (!examId || !roll) {
        showError("Please select an exam and enter your Roll No.");
        return;
    }

    const btn = $('searchBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
    $('searchError').style.display = 'none';

    try {
        const res = await fetch(`api/public_results.php?action=search&exam_id=${examId}&roll=${encodeURIComponent(roll)}`);
        const data = await res.json();

        if (data.ok) {
            renderMarksheet(data, $('examSelect').options[$('examSelect').selectedIndex].text);
            document.querySelector('.lookup-card').style.display = 'none';
            $('marksheetCard').style.display = 'block';
        } else {
            showError(data.msg);
        }
    } catch (err) {
        console.error(err);
        showError("Network Error. Please try again later.");
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-search"></i> <span class="btn-text">Search</span>';
    }
});

$('backBtn').addEventListener('click', () => {
    $('marksheetCard').style.display = 'none';
    document.querySelector('.lookup-card').style.display = 'block';
});

function showError(msg) {
    if ($('searchErrorMsg')) $('searchErrorMsg').textContent = msg;
    if ($('searchError')) $('searchError').style.display = 'flex';
}

function renderMarksheet(data, examName) {
    const s = data.student;
    $('msExamName').textContent = examName;
    $('msName').textContent = s.name;
    $('msRoll').textContent = s.roll;
    $('msRegNo').textContent = s.regno;
    $('msGroup').textContent = (s.group || '').toUpperCase();
    $('msSession').textContent = s.session;

    let html = '';
    data.marks.forEach(m => {
        let color = m.letter === 'F' ? '#dc2626' : '#1e293b';
        html += `
            <tr>
                <td>${m.subject}</td>
                <td>${m.full_marks}</td>
                <td style="color:${color}; font-weight:700;">${m.mark}</td>
                <td style="color:${color}; font-weight:800;">${m.letter}</td>
                <td style="color:${color}; font-weight:800;">${m.gp}</td>
            </tr>
        `;
    });
    $('msTableBody').innerHTML = html;

    $('msStatus').textContent = data.status;
    $('msStatus').style.color = data.status === 'PASSED' ? '#16a34a' : '#dc2626';
    
    $('msGpa').textContent = data.gpa;
    $('msGpa').style.color = data.status === 'PASSED' ? '#1d4ed8' : '#dc2626';
}

document.addEventListener('DOMContentLoaded', loadExams);
