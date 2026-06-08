document.addEventListener('DOMContentLoaded', () => {
    
    // Elements
    const viewModal = document.getElementById('viewModal');
    const closeViewModal = document.getElementById('closeViewModal');
    const btnCloseModalBtn = document.getElementById('btnCloseModalBtn');
    const btnDeleteMsg = document.getElementById('btnDeleteMsg');
    
    const messagesTableBody = document.getElementById('messagesTableBody');
    const tmToast = document.getElementById('tmToast');
    
    const statTotal = document.getElementById('statTotal');
    const statUnread = document.getElementById('statUnread');

    let allMessages = [];
    let currentViewId = null;

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

    function formatDate(dateString) {
        const d = new Date(dateString);
        return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
    }

    function getSubjectBadge(val) {
        switch(val) {
            case 'admission': return '<span class="subj-badge sb-admission"><i class="fas fa-user-graduate"></i> Admission</span>';
            case 'results': return '<span class="subj-badge sb-results"><i class="fas fa-poll"></i> Results & Exam</span>';
            case 'scholarship': return '<span class="subj-badge sb-scholarship"><i class="fas fa-award"></i> Scholarship</span>';
            case 'academic': return '<span class="subj-badge sb-academic"><i class="fas fa-book"></i> Academics</span>';
            default:
                return '<span class="subj-badge sb-other"><i class="fas fa-envelope-open-text"></i> ' + esc(val.charAt(0).toUpperCase() + val.slice(1)) + '</span>';
        }
    }

    function getSubjectLabel(val) {
        const map = {
            'admission': 'Admission Enquiry',
            'results': 'Results & Examination',
            'scholarship': 'Scholarship',
            'academic': 'Academic Information',
            'other': 'Other / General Enquiry'
        };
        return map[val] || val;
    }

    window.loadMessages = async function() {
        messagesTableBody.innerHTML = '<tr class="tm-empty-row"><td colspan="6"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>';
        try {
            const res = await fetch(window.BASE_URL + `/pages/portal/admin/api/contact-messages.php?action=list`);
            const data = await res.json();
            if (data.ok) {
                allMessages = data.messages;
                updateStats();
                renderMessages();
            }
        } catch(e) {
            messagesTableBody.innerHTML = '<tr class="tm-empty-row"><td colspan="5">Failed to load messages.</td></tr>';
        }
    };

    function updateStats() {
        statTotal.textContent = allMessages.length;
        const unread = allMessages.filter(m => m.is_read == 0).length;
        statUnread.textContent = unread;
    }

    function renderMessages() {
        if (allMessages.length === 0) {
            messagesTableBody.innerHTML = '<tr class="tm-empty-row"><td colspan="6"><i class="fas fa-envelope-open"></i> No messages found.</td></tr>';
            return;
        }

        messagesTableBody.innerHTML = allMessages.map(m => {
            const isUnread = m.is_read == 0;
            const statusBadge = isUnread 
                ? '<span class="status-badge status-unread">New</span>' 
                : '<span class="status-badge status-read">Read</span>';
            
            return `
            <tr class="msg-row ${isUnread ? 'unread' : ''}" onclick="viewMessage(${m.id})">
                <td><div class="msg-sender" style="font-weight: 600;">${esc(m.name)}</div></td>
                <td><div class="msg-email" style="color: var(--text-light); font-size: 0.9rem;">${esc(m.email)}</div></td>
                <td>${getSubjectBadge(m.subject)}</td>
                <td class="msg-date">${formatDate(m.created_at)}</td>
                <td>${statusBadge}</td>
                <td onclick="event.stopPropagation();">
                    <button class="btn-del" onclick="deleteMessage(${m.id})" title="Delete Message">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `}).join('');
    }

    window.viewMessage = async function(id) {
        const m = allMessages.find(x => x.id == id);
        if (!m) return;
        
        currentViewId = id;
        
        const badgeHTML = getSubjectBadge(m.subject);
        document.getElementById('msgViewSubject').innerHTML = badgeHTML;
        
        document.getElementById('msgViewName').textContent = m.name;
        
        const elEmail = document.getElementById('msgViewEmail');
        elEmail.textContent = m.email;
        elEmail.href = 'mailto:' + m.email;
        
        const elPhone = document.getElementById('msgViewPhone');
        if (m.phone) {
            elPhone.textContent = m.phone;
            elPhone.href = 'tel:' + m.phone;
            elPhone.parentElement.style.display = 'flex';
        } else {
            elPhone.parentElement.style.display = 'none';
        }
        
        document.getElementById('msgViewDate').textContent = formatDate(m.created_at);
        document.getElementById('msgViewBody').textContent = m.message;
        
        viewModal.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Mark as read if unread
        if (m.is_read == 0) {
            try {
                const res = await fetch(window.BASE_URL + `/pages/portal/admin/api/contact-messages.php?action=mark_read`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                });
                const data = await res.json();
                if (data.ok) {
                    m.is_read = 1;
                    updateStats();
                    renderMessages();
                }
            } catch(e) {}
        }
    };

    window.deleteMessage = async function(id) {
        if (!confirm("Are you sure you want to delete this message?")) return;
        try {
            const res = await fetch(window.BASE_URL + `/pages/portal/admin/api/contact-messages.php?action=delete&id=${id}`);
            const data = await res.json();
            if (data.ok) {
                showToast("Message deleted");
                loadMessages();
                if (currentViewId == id) {
                    closeOverlay();
                }
            } else {
                showToast("Failed to delete", true);
            }
        } catch(e) {
            showToast("Network error", true);
        }
    };

    const closeOverlay = () => {
        viewModal.classList.remove('active');
        document.body.style.overflow = '';
        currentViewId = null;
    };
    
    closeViewModal.addEventListener('click', closeOverlay);
    btnCloseModalBtn.addEventListener('click', closeOverlay);
    viewModal.addEventListener('click', (e) => {
        if(e.target === viewModal) closeOverlay();
    });
    
    btnDeleteMsg.addEventListener('click', () => {
        if (currentViewId) deleteMessage(currentViewId);
    });

    // Init
    loadMessages();
});
