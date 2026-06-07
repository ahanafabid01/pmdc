/**
 * results.js - Public Results Portal
 */
'use strict';

const $ = id => document.getElementById(id);

async function loadExams() {
    try {
        const res = await fetch('api/public_results.php?action=exams');
        const data = await res.json();
        if (data.ok) {
            $('examSelect').innerHTML = '<option value="">Select Examination</option>' + 
                data.exams.map(e => `<option value="${e.id}">${e.name} (${e.year})</option>`).join('');
        }
    } catch (e) {
        console.error(e);
    }
}

$('searchBtn').addEventListener('click', async () => {
    const examId = $('examSelect').value;
    const roll = $('rollInput').value.trim();

    if (!examId || !roll) {
        showError("Please select an exam and enter your Roll No.");
        return;
    }

    const btn = $('searchBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
    $('errorMsg').style.display = 'none';

    try {
        const res = await fetch(`api/public_results.php?action=search&exam_id=${examId}&roll=${encodeURIComponent(roll)}`);
        const data = await res.json();

        if (data.ok) {
            renderMarksheet(data, $('examSelect').options[$('examSelect').selectedIndex].text);
            $('searchCard').style.display = 'none';
            $('marksheetCard').style.display = 'block';
        } else {
            showError(data.msg);
        }
    } catch (e) {
        console.error(e);
        showError("Network Error. Please try again later.");
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-search"></i> Find Result';
    }
});

$('backBtn').addEventListener('click', () => {
    $('marksheetCard').style.display = 'none';
    $('searchCard').style.display = 'block';
});

function showError(msg) {
    $('errorMsg').textContent = msg;
    $('errorMsg').style.display = 'block';
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
