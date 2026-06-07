/**
 * results.js — Admin Results Management
 */
'use strict';

const $ = id => document.getElementById(id);
let isReleased = false;

function showToast(msg, err = false) {
    const t = $('toast');
    $('toastMsg').textContent = msg;
    t.className = `toast show${err ? ' error' : ''}`;
    setTimeout(() => t.classList.remove('show'), 3200);
}

// 1. Fetch initial exams and programs
async function initResults() {
    try {
        const res = await fetch(window.BASE_URL + `/pages/portal/admin/api/results.php?action=overview`);
        const data = await res.json();
        
        if (data.ok) {
            $('examSelect').innerHTML = '<option value="">Select Exam</option>' + 
                data.exams.map(e => `<option value="${e.id}">${e.name} (${e.year})</option>`).join('');
                
            $('programSelect').innerHTML = '<option value="">Select Program</option>' + 
                data.programs.map(p => `<option value="${p.id}">${p.name}</option>`).join('');
        }
    } catch (e) {
        console.error(e);
        showToast("Failed to load overview data.", true);
    }
}

// 2. Load Progress
$('loadProgressBtn').addEventListener('click', async () => {
    const examId = $('examSelect').value;
    const progId = $('programSelect').value;

    if (!examId || !progId) {
        showToast("Please select both Exam and Program.", true);
        return;
    }

    $('loadProgressBtn').disabled = true;
    $('loadProgressBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Checking...';

    try {
        const res = await fetch(window.BASE_URL + `/pages/portal/admin/api/results.php?action=progress&exam_id=${examId}&program_id=${progId}`);
        const data = await res.json();
        
        if (data.ok) {
            $('progressDashboard').style.display = 'block';
            $('statTotal').textContent = data.total;
            $('statPublished').textContent = data.published;
            $('statPending').textContent = data.total - data.published;
            
            const pct = data.total > 0 ? (data.published / data.total) * 100 : 0;
            $('progressBarFill').style.width = `${pct}%`;
            $('progressBarFill').style.background = pct === 100 ? '#10b981' : '#3b82f6';
            
            isReleased = data.is_released;
            updateReleaseButton(data.total, data.published);

            let html = '';
            if (data.progress.length === 0) {
                html = `<tr><td colspan="3" style="text-align:center;color:#64748b;">No subjects assigned for this program yet.</td></tr>`;
            } else {
                data.progress.forEach(p => {
                    let badgeCls = p.status === 'Published' ? 'badge-success' : (p.status === 'Draft' ? 'badge-warning' : 'badge-danger');
                    html += `
                        <tr>
                            <td style="font-weight:600;">${p.subject}</td>
                            <td>${p.teacher}</td>
                            <td><span class="badge ${badgeCls}">${p.status}</span></td>
                        </tr>
                    `;
                });
            }
            $('progressTableBody').innerHTML = html;
        } else {
            showToast(data.msg || "Failed to load progress.", true);
        }
    } catch (e) {
        console.error(e);
        showToast("Network Error", true);
    } finally {
        $('loadProgressBtn').disabled = false;
        $('loadProgressBtn').innerHTML = '<i class="fas fa-search"></i> Check Progress';
    }
});

function updateReleaseButton(total, published) {
    const btn = $('releaseBtn');
    if (isReleased) {
        btn.innerHTML = '<i class="fas fa-undo"></i> Revoke Results';
        btn.className = 'btn-danger';
        btn.disabled = false;
    } else {
        btn.innerHTML = '<i class="fas fa-globe"></i> Release Results';
        btn.className = 'btn-success';
        btn.disabled = (total === 0 || published < total);
    }
}

// 3. Release Results
$('releaseBtn').addEventListener('click', () => {
    const actionName = isReleased ? 'revoke' : 'release';
    $('releaseConfirmText').textContent = `Are you sure you want to ${actionName} these results for public view?`;
    $('releaseModal').classList.add('active');
});

$('closeReleaseModal').addEventListener('click', () => $('releaseModal').classList.remove('active'));
$('cancelRelease').addEventListener('click', () => $('releaseModal').classList.remove('active'));

$('confirmReleaseBtn').addEventListener('click', async () => {
    $('releaseModal').classList.remove('active');
    
    const examId = $('examSelect').value;
    const progId = $('programSelect').value;

    const btn = $('releaseBtn');
    const oldText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    btn.disabled = true;

    try {
        const res = await fetch(window.BASE_URL + `/pages/portal/admin/api/results.php?action=release`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                exam_id: examId,
                program_id: progId,
                release: !isReleased
            })
        });
        const data = await res.json();
        
        if (data.ok) {
            showToast(data.msg);
            isReleased = !isReleased;
            updateReleaseButton(Number($('statTotal').textContent), Number($('statPublished').textContent));
        } else {
            showToast(data.msg, true);
            btn.innerHTML = oldText;
            btn.disabled = false;
        }
    } catch (e) {
        console.error(e);
        showToast("Network Error", true);
        btn.innerHTML = oldText;
        btn.disabled = false;
    }
});

document.addEventListener('DOMContentLoaded', initResults);
