<?php
$page       = 'teachers';
$page_title = 'Teachers & Staff | Phulpur Mohila Degree College';
$page_css   = 'teachers.css';
$base_path  = '../';
include '../includes/header.php';
?>

    <!-- ══════════════════ PAGE HERO ══════════════════ -->
    <section class="page-hero ts-hero">
        <div class="container ph-content">
            <div class="ph-kicker reveal">Our Team</div>
            <h1 class="reveal">Teachers &amp; Staff</h1>
            <p class="reveal">Meet the dedicated team behind Phulpur Mohila Degree College</p>
            <div class="ts-hero-stats reveal">
                <div class="ths-badge" id="heroTeacherCount">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span class="ths-val">—</span>
                    <span class="ths-lbl">Teachers</span>
                </div>
                <div class="ths-badge" id="heroAdminCount">
                    <i class="fas fa-briefcase"></i>
                    <span class="ths-val">—</span>
                    <span class="ths-lbl">Admin Staff</span>
                </div>
                <div class="ths-badge" id="heroSupportCount">
                    <i class="fas fa-users"></i>
                    <span class="ths-val">—</span>
                    <span class="ths-lbl">Support Staff</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════ FILTER BAR ══════════════════ -->
    <div class="ts-filter-bar" id="tsFilterBar">
        <div class="container ts-filter-inner">
            <div class="ts-filter-btns">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="teacher"><i class="fas fa-chalkboard-teacher"></i> Teachers</button>
                <button class="filter-btn" data-filter="admin"><i class="fas fa-briefcase"></i> Admin</button>
                <button class="filter-btn" data-filter="support"><i class="fas fa-users"></i> Support</button>
            </div>
            <div class="ts-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="tsSearch" placeholder="Search by name or designation..." autocomplete="off">
            </div>
        </div>
    </div>

    <!-- ══════════════════ MAIN CONTENT ══════════════════ -->
    <div class="section-padding ts-content" id="tsContent">
        <div class="container">

            <!-- ─── TEACHING STAFF ─── -->
            <div class="staff-section" id="sectionTeacher" data-section="teacher">
                <div class="staff-section-head reveal">
                    <div class="ssh-left">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Teaching Staff</span>
                    </div>
                    <span class="ssh-count" id="countTeacher">—</span>
                </div>

                <!-- Principal card -->
                <div id="principalWrap"></div>

                <!-- Teacher grid -->
                <div class="staff-grid" id="gridTeacher"></div>
                <div class="staff-empty" id="emptyTeacher" style="display:none;">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <p>No teaching staff added yet.</p>
                </div>
            </div>

            <!-- ─── ADMIN STAFF ─── -->
            <div class="staff-section" id="sectionAdmin" data-section="admin">
                <div class="staff-section-head reveal">
                    <div class="ssh-left">
                        <i class="fas fa-briefcase"></i>
                        <span>Administrative Staff</span>
                    </div>
                    <span class="ssh-count" id="countAdmin">—</span>
                </div>
                <div class="staff-grid" id="gridAdmin"></div>
                <div class="staff-empty" id="emptyAdmin" style="display:none;">
                    <i class="fas fa-briefcase"></i>
                    <p>No administrative staff added yet.</p>
                </div>
            </div>

            <!-- ─── SUPPORT STAFF ─── -->
            <div class="staff-section" id="sectionSupport" data-section="support">
                <div class="staff-section-head reveal">
                    <div class="ssh-left">
                        <i class="fas fa-users"></i>
                        <span>Support Staff</span>
                    </div>
                    <span class="ssh-count" id="countSupport">—</span>
                </div>
                <div class="staff-grid" id="gridSupport"></div>
                <div class="staff-empty" id="emptySupport" style="display:none;">
                    <i class="fas fa-users"></i>
                    <p>No support staff added yet.</p>
                </div>
            </div>

        </div>
    </div>

    <script>
    /* ─── Shared store key with portal ─── */
    const STORE_KEY = 'pmdc_staff';

    const AVATAR_COLORS = [
        '#1a3a5c','#276749','#7b341e','#702459','#1a365d',
        '#0f4c75','#b5451b','#1b4332','#4a1942','#2c3e7a'
    ];

    function loadStaff() {
        try {
            const raw = localStorage.getItem(STORE_KEY);
            if (raw) return JSON.parse(raw);
        } catch (_) {}
        return defaultStaff();
    }

    function defaultStaff() {
        return [
            /* ── Principal ── */
            { id:'s-1', name:'Dr. Halima Khatun', designation:'Principal', category:'teacher', isPrincipal:true,
              subject:'Administration', qualification:'PhD in Education (Dhaka University)', email:'principal@pmdc.edu.bd', phone:'+880-1700-000010', photo:null },
            /* ── Teachers ── */
            { id:'s-2', name:'Ms. Afroza Begum', designation:'Senior Lecturer', category:'teacher', isPrincipal:false,
              subject:'Physics', qualification:'M.Sc. Physics (Jahangirnagar University)', email:'afroza@pmdc.edu.bd', phone:'+880-1700-000011', photo:null },
            { id:'s-3', name:'Mrs. Rashida Akter', designation:'Lecturer', category:'teacher', isPrincipal:false,
              subject:'Chemistry', qualification:'M.Sc. Chemistry (Dhaka University)', email:'rashida@pmdc.edu.bd', phone:'+880-1700-000012', photo:null },
            { id:'s-4', name:'Ms. Nasrin Sultana', designation:'Lecturer', category:'teacher', isPrincipal:false,
              subject:'Biology', qualification:'M.Sc. Botany (Rajshahi University)', email:'nasrin@pmdc.edu.bd', phone:'+880-1700-000013', photo:null },
            { id:'s-5', name:'Mrs. Fatema Begum', designation:'Senior Lecturer', category:'teacher', isPrincipal:false,
              subject:'Mathematics', qualification:'M.Sc. Mathematics (Chittagong University)', email:'fatema@pmdc.edu.bd', phone:'+880-1700-000014', photo:null },
            { id:'s-6', name:'Ms. Dilruba Islam', designation:'Lecturer', category:'teacher', isPrincipal:false,
              subject:'Accounting', qualification:'M.Com. Accounting (National University)', email:'dilruba@pmdc.edu.bd', phone:'+880-1700-000015', photo:null },
            { id:'s-7', name:'Mrs. Shaila Parvin', designation:'Lecturer', category:'teacher', isPrincipal:false,
              subject:'Economics', qualification:'MA Economics (Dhaka University)', email:'shaila@pmdc.edu.bd', phone:'+880-1700-000016', photo:null },
            { id:'s-8', name:'Ms. Roksana Begum', designation:'Assistant Lecturer', category:'teacher', isPrincipal:false,
              subject:'Civics', qualification:'MA Political Science (Jahangirnagar University)', email:'roksana@pmdc.edu.bd', phone:'+880-1700-000017', photo:null },
            { id:'s-9', name:'Mrs. Morjina Khatun', designation:'Lecturer', category:'teacher', isPrincipal:false,
              subject:'Bangla', qualification:'MA Bangla Literature (Dhaka University)', email:'morjina@pmdc.edu.bd', phone:'+880-1700-000018', photo:null },
            { id:'s-10', name:'Ms. Tania Akter', designation:'Lecturer', category:'teacher', isPrincipal:false,
              subject:'English', qualification:'MA English (National University)', email:'tania@pmdc.edu.bd', phone:'+880-1700-000019', photo:null },
            { id:'s-11', name:'Mrs. Sonia Islam', designation:'Assistant Lecturer', category:'teacher', isPrincipal:false,
              subject:'ICT', qualification:'B.Sc. Computer Science (BUET)', email:'sonia@pmdc.edu.bd', phone:'+880-1700-000020', photo:null },
            { id:'s-12', name:'Ms. Popy Begum', designation:'Lecturer', category:'teacher', isPrincipal:false,
              subject:'History', qualification:'MA History (Rajshahi University)', email:'popy@pmdc.edu.bd', phone:'+880-1700-000021', photo:null },
            /* ── Admin ── */
            { id:'s-13', name:'Mr. Rafiqul Islam', designation:'Office Superintendent', category:'admin', isPrincipal:false,
              subject:'Administrative Office', qualification:'BBA (National University)', email:'rafiq@pmdc.edu.bd', phone:'+880-1700-000030', photo:null },
            { id:'s-14', name:'Ms. Mitu Akter', designation:'Accounts Officer', category:'admin', isPrincipal:false,
              subject:'Finance & Accounts', qualification:'M.Com. (National University)', email:'mitu@pmdc.edu.bd', phone:'+880-1700-000031', photo:null },
            { id:'s-15', name:'Mr. Karim Molla', designation:'Office Assistant', category:'admin', isPrincipal:false,
              subject:'General Administration', qualification:'HSC (Board)', email:'karim@pmdc.edu.bd', phone:'+880-1700-000032', photo:null },
            { id:'s-16', name:'Ms. Asha Khatun', designation:'Admission Officer', category:'admin', isPrincipal:false,
              subject:'Admissions Office', qualification:'BA (National University)', email:'asha@pmdc.edu.bd', phone:'+880-1700-000033', photo:null },
            /* ── Support ── */
            { id:'s-17', name:'Mr. Jahangir Alam', designation:'Library Assistant', category:'support', isPrincipal:false,
              subject:'—', qualification:'—', email:'—', phone:'+880-1700-000040', photo:null },
            { id:'s-18', name:'Ms. Rina Begum', designation:'Lab Assistant', category:'support', isPrincipal:false,
              subject:'—', qualification:'—', email:'—', phone:'+880-1700-000041', photo:null },
            { id:'s-19', name:'Mr. Salam Sheikh', designation:'Security Guard', category:'support', isPrincipal:false,
              subject:'—', qualification:'—', email:'—', phone:'+880-1700-000042', photo:null },
            { id:'s-20', name:'Ms. Mim Parvin', designation:'Cleaning Staff', category:'support', isPrincipal:false,
              subject:'—', qualification:'—', email:'—', phone:'—', photo:null },
        ];
    }

    function getInitials(name) {
        return name.split(' ').slice(0,2).map(w => w[0]).join('').toUpperCase();
    }
    function avatarColor(name) {
        let h = 0;
        for (let c of name) h = ((h << 5) - h) + c.charCodeAt(0);
        return AVATAR_COLORS[Math.abs(h) % AVATAR_COLORS.length];
    }
    function esc(s) { return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

    function avatarHtml(member, size = 90) {
        if (member.photo) {
            return `<img src="${member.photo}" alt="${esc(member.name)}" class="staff-photo" style="width:${size}px;height:${size}px;">`;
        }
        const initials = getInitials(member.name);
        const bg = avatarColor(member.name);
        return `<div class="staff-initials" style="width:${size}px;height:${size}px;background:${bg};font-size:${Math.round(size*0.32)}px;">${initials}</div>`;
    }

    function contactLink(val, type) {
        if (!val || val === '—') return `<span class="si-val si-empty">—</span>`;
        if (type === 'email') return `<a href="mailto:${esc(val)}" class="si-val si-link">${esc(val)}</a>`;
        if (type === 'tel')   return `<a href="tel:${esc(val)}"    class="si-val si-link">${esc(val)}</a>`;
        return `<span class="si-val">${esc(val)}</span>`;
    }

    function badgeClass(cat) {
        if (cat === 'teacher') return 'badge-teacher';
        if (cat === 'admin')   return 'badge-admin';
        return 'badge-support';
    }

    /* ─── Principal card ─── */
    function renderPrincipal(member) {
        return `
        <div class="principal-card reveal" data-category="teacher" data-name="${esc(member.name)}" data-desig="${esc(member.designation)}">
            <div class="pc-photo">${avatarHtml(member, 120)}</div>
            <div class="pc-body">
                <div class="pc-top">
                    <div>
                        <h2 class="pc-name">${esc(member.name)}</h2>
                        <span class="staff-badge badge-teacher">${esc(member.designation)}</span>
                    </div>
                    <span class="pc-label">Head of Institution</span>
                </div>
                <div class="pc-info">
                    <div class="si-row"><i class="fas fa-book"></i>${contactLink(member.subject, 'text') ? `<span class="si-val">${esc(member.subject)}</span>` : ''}</div>
                    <div class="si-row"><i class="fas fa-graduation-cap"></i><span class="si-val">${esc(member.qualification)}</span></div>
                    <div class="si-row"><i class="fas fa-envelope"></i>${contactLink(member.email, 'email')}</div>
                    <div class="si-row"><i class="fas fa-phone"></i>${contactLink(member.phone, 'tel')}</div>
                </div>
            </div>
        </div>`;
    }

    /* ─── Regular staff card ─── */
    function staffCard(member) {
        const label = member.category === 'admin' ? 'Department' : 'Subject';
        const icon  = member.category === 'admin' ? 'fas fa-building' : 'fas fa-book';
        return `
        <div class="staff-card reveal" data-category="${member.category}" data-name="${esc(member.name)}" data-desig="${esc(member.designation)}">
            <div class="sc-photo-wrap">${avatarHtml(member, 90)}</div>
            <div class="sc-name">${esc(member.name)}</div>
            <span class="staff-badge ${badgeClass(member.category)}">${esc(member.designation)}</span>
            <div class="sc-divider"></div>
            <div class="sc-info">
                <div class="si-row"><i class="${icon}"></i><span class="si-val">${member.subject && member.subject !== '—' ? esc(member.subject) : '—'}</span></div>
                <div class="si-row"><i class="fas fa-graduation-cap"></i><span class="si-val">${member.qualification && member.qualification !== '—' ? esc(member.qualification) : '—'}</span></div>
                <div class="si-row"><i class="fas fa-envelope"></i>${contactLink(member.email, 'email')}</div>
                <div class="si-row"><i class="fas fa-phone"></i>${contactLink(member.phone, 'tel')}</div>
            </div>
        </div>`;
    }

    /* ─── Main render ─── */
    function render(staff, query, filter) {
        const q  = (query || '').trim().toLowerCase();
        const fn = s => {
            const matchQ = !q || s.name.toLowerCase().includes(q) || s.designation.toLowerCase().includes(q);
            const matchF = filter === 'all' || s.category === filter;
            return matchQ && matchF;
        };

        const teachers = staff.filter(s => s.category === 'teacher' && !s.isPrincipal && fn(s));
        const principal = staff.find(s => s.isPrincipal && fn(s));
        const admins   = staff.filter(s => s.category === 'admin'   && fn(s));
        const supports = staff.filter(s => s.category === 'support' && fn(s));

        /* Stats (always from full list, not filtered) */
        const allTeachers = staff.filter(s => s.category === 'teacher');
        const allAdmins   = staff.filter(s => s.category === 'admin');
        const allSupports = staff.filter(s => s.category === 'support');
        document.querySelector('#heroTeacherCount .ths-val').textContent = allTeachers.length;
        document.querySelector('#heroAdminCount .ths-val').textContent   = allAdmins.length;
        document.querySelector('#heroSupportCount .ths-val').textContent = allSupports.length;

        /* Counts (filtered) */
        const tCount = (principal ? 1 : 0) + teachers.length;
        document.getElementById('countTeacher').textContent = tCount + (tCount === 1 ? ' Member' : ' Members');
        document.getElementById('countAdmin').textContent   = admins.length   + (admins.length   === 1 ? ' Member' : ' Members');
        document.getElementById('countSupport').textContent = supports.length + (supports.length === 1 ? ' Member' : ' Members');

        /* Section visibility */
        const showT = filter === 'all' || filter === 'teacher';
        const showA = filter === 'all' || filter === 'admin';
        const showS = filter === 'all' || filter === 'support';
        document.getElementById('sectionTeacher').style.display = showT ? '' : 'none';
        document.getElementById('sectionAdmin').style.display   = showA ? '' : 'none';
        document.getElementById('sectionSupport').style.display = showS ? '' : 'none';

        /* Principal */
        const pWrap = document.getElementById('principalWrap');
        pWrap.innerHTML = principal ? renderPrincipal(principal) : '';

        /* Grids */
        renderGrid('gridTeacher', 'emptyTeacher', teachers);
        renderGrid('gridAdmin',   'emptyAdmin',   admins);
        renderGrid('gridSupport', 'emptySupport', supports);

        /* Stagger animation */
        document.querySelectorAll('.staff-card, .principal-card').forEach((el, i) => {
            el.style.opacity   = '0';
            el.style.transform = 'translateY(20px)';
            setTimeout(() => {
                el.style.transition = 'opacity .35s ease, transform .35s ease';
                el.style.opacity    = '1';
                el.style.transform  = 'translateY(0)';
            }, i * 50);
        });
    }

    function renderGrid(gridId, emptyId, members) {
        const grid  = document.getElementById(gridId);
        const empty = document.getElementById(emptyId);
        if (members.length === 0) {
            grid.innerHTML  = '';
            grid.style.display  = 'none';
            empty.style.display = 'flex';
        } else {
            grid.innerHTML  = members.map(staffCard).join('');
            grid.style.display  = '';
            empty.style.display = 'none';
        }
    }

    /* ─── Init ─── */
    let currentFilter = 'all';
    let searchQuery   = '';

    const staff = loadStaff();
    render(staff, searchQuery, currentFilter);

    /* Filter buttons */
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            render(staff, searchQuery, currentFilter);
        });
    });

    /* Search */
    document.getElementById('tsSearch').addEventListener('input', function () {
        searchQuery = this.value;
        render(staff, searchQuery, currentFilter);
    });

    /* Sticky filter bar */
    const filterBar = document.getElementById('tsFilterBar');
    const heroEnd   = document.querySelector('.ts-hero');
    const io = new IntersectionObserver(([entry]) => {
        filterBar.classList.toggle('sticky', !entry.isIntersecting);
    }, { threshold: 0 });
    io.observe(heroEnd);

    /* Section heading reveal */
    const revealObs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('revealed'); revealObs.unobserve(e.target); } });
    }, { threshold: .15 });
    document.querySelectorAll('.staff-section-head.reveal').forEach(el => revealObs.observe(el));
    </script>

<?php include '../includes/footer.php'; ?>
