
/* ════════════════════════════════════════════════════════════
   Gallery Admin JS
════════════════════════════════════════════════════════════ */
(function () {
    'use strict';

    const API = window.BASE_URL + `/pages/portal/admin/api/gallery-upload.php`;
    const $ = id => document.getElementById(id);

    let allPhotos = [];
    let filtered = [];
    let selected = new Set();
    let viewMode = 'grid';
    let currentYear = 'all';
    let searchTerm = '';

    /* ── Toast helper ─────────────────────────────────── */
    function toast(msg, type = 'success') {
        const el = $('gmToast');
        el.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${msg}`;
        el.className = `tm-toast ${type} show`;
        setTimeout(() => el.classList.remove('show'), 3000);
    }

    /* ── Year options helper ──────────────────────────── */
    function yearOptions(selId, val) {
        const sel = $(selId); sel.innerHTML = '';
        const cur = new Date().getFullYear();
        for (let y = cur; y >= 2018; y--) {
            const o = document.createElement('option');
            o.value = y; o.textContent = y;
            if (y == val) o.selected = true;
            sel.appendChild(o);
        }
    }

    /* ── Load photos ──────────────────────────────────── */
    function loadPhotos() {
        fetch(API + '?action=list')
            .then(r => r.json())
            .then(data => { 
                allPhotos = data.photos || []; 
                renderAll(); 
            })
            .catch(() => { 
                allPhotos = []; 
                renderAll(); 
                toast('Failed to load gallery from server', 'error');
            });
    }



    function renderStats() {
        const years = [...new Set(allPhotos.map(p => p.year))];
        // Year filter
        const sel = $('filterYear');
        sel.innerHTML = '<option value="all">All Years</option>';
        years.sort((a, b) => b - a).forEach(y => {
            const o = document.createElement('option');
            o.value = y; o.textContent = y;
            if (String(y) === currentYear) o.selected = true;
            sel.appendChild(o);
        });
    }

    /* ── Filter ───────────────────────────────────────── */
    function applyFilter() {
        filtered = allPhotos.filter(p => {
            const matchYear = currentYear === 'all' || p.year == currentYear;
            const matchSearch = !searchTerm || (p.title || '').toLowerCase().includes(searchTerm);
            return matchYear && matchSearch;
        });
        renderPhotos();
    }

    function renderAll() { renderStats(); applyFilter(); }

    /* ── Helpers ──────────────────────────────────────── */
    function photoUrl(p) { return p.is_external ? p.filename : window.BASE_URL + '/uploads/gallery/' + p.filename; }
    function esc(s) { const d = document.createElement('div'); d.textContent = s || ''; return d.innerHTML; }
    function fmtDate(d) {
        if (!d) return '—';
        return new Date(d).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    /* ── Render ───────────────────────────────────────── */
    function renderPhotos() {
        const empty = $('adminEmpty'), grid = $('adminGrid'), list = $('adminList'), body = $('listBody');

        if (!filtered.length) {
            empty.style.display = ''; grid.style.display = 'none'; list.style.display = 'none';
            return;
        }
        empty.style.display = 'none';
        $('selectAllWrap').style.display = '';

        if (viewMode === 'grid') {
            grid.style.display = ''; list.style.display = 'none';
            grid.innerHTML = filtered.map(p => `
                    <div class="gm-thumb${selected.has(p.id) ? ' selected' : ''}" data-id="${p.id}">
                        <img src="${photoUrl(p)}" alt="${esc(p.title)}" loading="lazy">
                        <div class="gm-thumb-overlay">
                            <button class="gm-thumb-btn" onclick="editPhoto(${p.id})" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                            <button class="gm-thumb-btn btn-del" onclick="deletePhoto(${p.id})" title="Delete"><i class="fas fa-trash"></i></button>
                        </div>
                        <div class="gm-year-badge">${p.year}</div>
                        <label class="gm-checkbox-wrap"><input type="checkbox" data-id="${p.id}" ${selected.has(p.id) ? 'checked' : ''} onchange="toggleSelect(${p.id},this.checked)"></label>
                    </div>`).join('');
        } else {
            grid.style.display = 'none'; list.style.display = '';
            body.innerHTML = filtered.map(p => `
                    <tr>
                        <td><input type="checkbox" ${selected.has(p.id) ? 'checked' : ''} onchange="toggleSelect(${p.id},this.checked)"></td>
                        <td><img src="${photoUrl(p)}" alt="" class="gm-list-thumb" loading="lazy"></td>
                        <td class="tm-staff-name">${esc(p.title) || '<em style="color:#94a3b8">Untitled</em>'}</td>
                        <td style="font-weight:700">${p.year}</td>
                        <td style="color:#64748b;font-size:.82rem">${fmtDate(p.date_uploaded)}</td>
                        <td>
                            <div class="tm-row-actions">
                                <button class="btn-edit" onclick="editPhoto(${p.id})" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn-del" onclick="deletePhoto(${p.id})" title="Delete"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>`).join('');
        }
    }

    /* ── Selection ────────────────────────────────────── */
    window.toggleSelect = function (id, checked) {
        checked ? selected.add(id) : selected.delete(id);
        const t = document.querySelector(`.gm-thumb[data-id="${id}"]`);
        if (t) t.classList.toggle('selected', checked);
        updateBulkBar();
    };
    function updateBulkBar() {
        const n = selected.size;
        $('bulkActions').style.display = n > 0 ? '' : 'none';
        $('bulkCount').textContent = n;
        $('bulkDeleteCount').textContent = n;
    }
    $('selectAll').addEventListener('change', function () {
        filtered.forEach(p => this.checked ? selected.add(p.id) : selected.delete(p.id));
        renderPhotos(); updateBulkBar();
    });

    /* ── Modal helpers ────────────────────────────────── */
    function openModal(id) { $(id).classList.add('active'); }
    function closeModal(id) { $(id).classList.remove('active'); }

    /* ── Upload Modal ─────────────────────────────────── */
    let uploadFiles = [];
    $('btnUpload').addEventListener('click', () => {
        uploadFiles = [];
        $('uploadPreview').innerHTML = '';
        $('uploadMeta').style.display = 'none';
        $('uploadProgress').style.display = 'none';
        $('submitUpload').disabled = true;
        yearOptions('upYear', new Date().getFullYear());
        $('upDate').value = new Date().toISOString().split('T')[0];
        $('upTitle').value = '';
        openModal('uploadModal');
    });
    ['closeUpload', 'cancelUpload'].forEach(id => $(id).addEventListener('click', () => closeModal('uploadModal')));

    const dz = $('dropZone');
    dz.addEventListener('click', () => $('fileInput').click());
    dz.addEventListener('dragover', e => { e.preventDefault(); dz.classList.add('drag-over'); });
    dz.addEventListener('dragleave', () => dz.classList.remove('drag-over'));
    dz.addEventListener('drop', e => { e.preventDefault(); dz.classList.remove('drag-over'); handleFiles(e.dataTransfer.files); });
    $('fileInput').addEventListener('change', e => handleFiles(e.target.files));

    function handleFiles(files) {
        uploadFiles = [...files];
        const preview = $('uploadPreview'); preview.innerHTML = '';
        uploadFiles.forEach(f => {
            const div = document.createElement('div'); div.className = 'gm-preview-item';
            const img = document.createElement('img'); img.src = URL.createObjectURL(f);
            const lbl = document.createElement('span'); lbl.textContent = f.name;
            div.appendChild(img); div.appendChild(lbl); preview.appendChild(div);
        });
        $('uploadMeta').style.display = uploadFiles.length ? '' : 'none';
        $('submitUpload').disabled = !uploadFiles.length;
    }

    $('submitUpload').addEventListener('click', () => {
        if (!uploadFiles.length) return;
        const fd = new FormData();
        fd.append('action', 'upload'); fd.append('year', $('upYear').value);
        fd.append('date', $('upDate').value); fd.append('title', $('upTitle').value);
        uploadFiles.forEach(f => fd.append('photos[]', f));
        $('uploadProgress').style.display = ''; $('submitUpload').disabled = true; $('upBar').style.width = '0%';
        const xhr = new XMLHttpRequest(); xhr.open('POST', API);
        xhr.upload.onprogress = e => { if (e.lengthComputable) $('upBar').style.width = Math.round(e.loaded / e.total * 100) + '%'; };
        xhr.onload = () => { $('upBar').style.width = '100%'; $('upStatus').textContent = '✓ Done!'; setTimeout(() => { closeModal('uploadModal'); loadPhotos(); toast('Photos uploaded successfully.'); }, 900); };
        xhr.onerror = () => { $('upStatus').textContent = 'Upload failed. Please try again.'; };
        xhr.send(fd);
    });

    /* ── Edit Modal ───────────────────────────────────── */
    window.editPhoto = function (id) {
        const p = allPhotos.find(x => x.id === id); if (!p) return;
        $('editId').value = ''; $('editTitle').value = p.title || ''; $('editDate').value = p.date_uploaded;
        $('editId').value = id; yearOptions('editYear', p.year); openModal('editModal');
    };
    ['closeEdit', 'cancelEdit'].forEach(id => $(id).addEventListener('click', () => closeModal('editModal')));
    $('submitEdit').addEventListener('click', () => {
        const fd = new FormData();
        fd.append('action', 'edit'); fd.append('id', $('editId').value);
        fd.append('title', $('editTitle').value); fd.append('year', $('editYear').value); fd.append('date', $('editDate').value);
        fetch(API, { method: 'POST', body: fd }).then(r => r.json()).then(d => { if (d.ok) { closeModal('editModal'); loadPhotos(); toast('Photo updated.'); } });
    });

    /* ── Delete Modal ─────────────────────────────────── */
    window.deletePhoto = function (id) { $('deleteId').value = id; openModal('deleteModal'); };
    ['closeDelete', 'cancelDelete'].forEach(id => $(id).addEventListener('click', () => closeModal('deleteModal')));
    $('confirmDelete').addEventListener('click', () => {
        const id = $('deleteId').value; const fd = new FormData();
        fd.append('action', 'delete'); fd.append('id', id);
        fetch(API, { method: 'POST', body: fd }).then(r => r.json()).then(d => { if (d.ok) { closeModal('deleteModal'); selected.delete(parseInt(id)); loadPhotos(); toast('Photo deleted.'); updateBulkBar(); } });
    });

    /* ── Bulk Delete ──────────────────────────────────── */
    $('btnBulkDelete').addEventListener('click', () => { $('bulkDeleteCount').textContent = selected.size; openModal('bulkDeleteModal'); });
    ['closeBulkDelete', 'cancelBulkDelete'].forEach(id => $(id).addEventListener('click', () => closeModal('bulkDeleteModal')));
    $('confirmBulkDelete').addEventListener('click', () => {
        const fd = new FormData();
        fd.append('action', 'bulk_delete'); fd.append('ids', JSON.stringify([...selected]));
        fetch(API, { method: 'POST', body: fd }).then(r => r.json()).then(d => { if (d.ok) { selected.clear(); closeModal('bulkDeleteModal'); loadPhotos(); updateBulkBar(); toast(`${d.deleted || 'Selected'} photos deleted.`); } });
    });

    /* ── View toggle ──────────────────────────────────── */
    $('viewGrid').addEventListener('click', () => { viewMode = 'grid'; $('viewGrid').classList.add('active'); $('viewList').classList.remove('active'); renderPhotos(); });
    $('viewList').addEventListener('click', () => { viewMode = 'list'; $('viewList').classList.add('active'); $('viewGrid').classList.remove('active'); renderPhotos(); });

    /* ── Filters ──────────────────────────────────────── */
    $('filterYear').addEventListener('change', function () { currentYear = this.value; applyFilter(); });
    $('searchInput').addEventListener('input', function () { searchTerm = this.value.trim().toLowerCase(); applyFilter(); });

    /* ── Sidebar ──────────────────────────────────────── */
    (function () {
        const sidebar = $('sidebar'), overlay = $('sidebarOverlay');
        const menuBtn = $('menuToggle'), closeBtn = $('closeSidebar');
        function open() { sidebar.classList.add('open'); overlay.classList.add('active'); document.body.style.overflow = 'hidden'; }
        function close() { sidebar.classList.remove('open'); overlay.classList.remove('active'); document.body.style.overflow = ''; }
        menuBtn?.addEventListener('click', open);
        closeBtn?.addEventListener('click', close);
        overlay?.addEventListener('click', close);
    })();

    /* ── Escape closes modals ─────────────────────────── */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') ['uploadModal', 'editModal', 'deleteModal', 'bulkDeleteModal'].forEach(closeModal);
    });

    /* ── Init ─────────────────────────────────────────── */
    yearOptions('upYear', new Date().getFullYear());
    yearOptions('editYear', new Date().getFullYear());
    loadPhotos();

})();
