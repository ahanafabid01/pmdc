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
            <div class="ph-kicker reveal" data-i18n="ts.hero.kicker">আমাদের দল</div>
            <h1 class="reveal" data-i18n="ts.hero.h1">শিক্ষক ও কর্মচারী</h1>
            <p class="reveal" data-i18n="ts.hero.desc">ফুলপুর মহিলা ডিগ্রি কলেজের নিবেদিতপ্রাণ দলের সাথে পরিচিত হোন</p>
            <div class="ts-hero-stats reveal">
                <div class="ths-badge" id="heroTeacherCount">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span class="ths-val">—</span>
                    <span class="ths-lbl" data-i18n="ts.hero.teachers">শিক্ষকবৃন্দ</span>
                </div>
                <div class="ths-badge" id="heroAdminCount">
                    <i class="fas fa-briefcase"></i>
                    <span class="ths-val">—</span>
                    <span class="ths-lbl" data-i18n="ts.hero.admin">প্রশাসনিক কর্মী</span>
                </div>
                <div class="ths-badge" id="heroSupportCount">
                    <i class="fas fa-users"></i>
                    <span class="ths-val">—</span>
                    <span class="ths-lbl" data-i18n="ts.hero.support">সহায়ক কর্মী</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════ FILTER BAR ══════════════════ -->
    <div class="ts-filter-bar" id="tsFilterBar">
        <div class="container ts-filter-inner">
            <div class="ts-filter-btns">
                <button class="filter-btn active" data-filter="all" data-i18n="ts.filter.all">সব</button>
                <button class="filter-btn" data-filter="teacher"><i class="fas fa-chalkboard-teacher"></i> <span data-i18n="ts.filter.teachers">শিক্ষকবৃন্দ</span></button>
                <button class="filter-btn" data-filter="admin"><i class="fas fa-briefcase"></i> <span data-i18n="ts.filter.admin">প্রশাসন</span></button>
                <button class="filter-btn" data-filter="support"><i class="fas fa-users"></i> <span data-i18n="ts.filter.support">সহায়ক</span></button>
            </div>
            <div class="ts-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="tsSearch" data-i18n="ts.search" data-i18n-attr="placeholder" placeholder="নাম বা পদবী দিয়ে খুঁজুন..." autocomplete="off">
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
                        <span data-i18n="ts.section.teaching">শিক্ষকমণ্ডলী</span>
                    </div>
                    <span class="ssh-count" id="countTeacher">—</span>
                </div>

                <!-- Principal card -->
                <div id="principalWrap"></div>

                <!-- Teacher grid -->
                <div class="staff-grid" id="gridTeacher"></div>
                <div class="staff-empty" id="emptyTeacher" style="display:none;">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <p data-i18n="ts.empty.teacher">এখনও কোনো শিক্ষক যোগ করা হয়নি।</p>
                </div>
            </div>

            <!-- ─── ADMIN STAFF ─── -->
            <div class="staff-section" id="sectionAdmin" data-section="admin">
                <div class="staff-section-head reveal">
                    <div class="ssh-left">
                        <i class="fas fa-briefcase"></i>
                        <span data-i18n="ts.section.admin">প্রশাসনিক কর্মী</span>
                    </div>
                    <span class="ssh-count" id="countAdmin">—</span>
                </div>
                <div class="staff-grid" id="gridAdmin"></div>
                <div class="staff-empty" id="emptyAdmin" style="display:none;">
                    <i class="fas fa-briefcase"></i>
                    <p data-i18n="ts.empty.admin">এখনও কোনো প্রশাসনিক কর্মী যোগ করা হয়নি।</p>
                </div>
            </div>

            <!-- ─── SUPPORT STAFF ─── -->
            <div class="staff-section" id="sectionSupport" data-section="support">
                <div class="staff-section-head reveal">
                    <div class="ssh-left">
                        <i class="fas fa-users"></i>
                        <span data-i18n="ts.section.support">সহায়ক কর্মী</span>
                    </div>
                    <span class="ssh-count" id="countSupport">—</span>
                </div>
                <div class="staff-grid" id="gridSupport"></div>
                <div class="staff-empty" id="emptySupport" style="display:none;">
                    <i class="fas fa-users"></i>
                    <p data-i18n="ts.empty.support">এখনও কোনো সহায়ক কর্মী যোগ করা হয়নি।</p>
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
                        { id:'s-1', name:'Rowshan Ara Begum', designation:'Principal', category:'teacher', isPrincipal:true, subject:'Administration', qualification:'N/A', email:'N/A', phone:'01712-227783', photo:null },
                        { id:'s-2', name:'Md. Hafizur Rahman', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'Bangla', qualification:'N/A', email:'N/A', phone:'01725-657227', photo:null },
                        { id:'s-3', name:'Md. Khorshedul Rahman', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'Physics', qualification:'N/A', email:'N/A', phone:'01716-490777', photo:null },
                        { id:'s-4', name:'Md. Ali Akbar', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'History', qualification:'N/A', email:'N/A', phone:'01721-730034', photo:null },
                        { id:'s-5', name:'Md. Hosen Ali', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'Mathematics', qualification:'N/A', email:'N/A', phone:'01716-909681', photo:null },
                        { id:'s-6', name:'Md. Aminul Haq', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'Accounting', qualification:'N/A', email:'N/A', phone:'01915-487540', photo:null },
                        { id:'s-7', name:'Lily Bilkis Rana', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'Botany', qualification:'N/A', email:'N/A', phone:'01918-744038', photo:null },
                        { id:'s-8', name:'Shaheen Ara Begum', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'Economics', qualification:'N/A', email:'N/A', phone:'01552-441446', photo:null },
                        { id:'s-9', name:'Md. Makbul Hosen', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'Chemistry', qualification:'N/A', email:'N/A', phone:'01716-750100', photo:null },
                        { id:'s-10', name:'Md. Shafayet Jamil', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'Social Work', qualification:'N/A', email:'N/A', phone:'01712-505717', photo:null },
                        { id:'s-11', name:'Md. Enamul Haq', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'Islamic Studies', qualification:'N/A', email:'N/A', phone:'01984-880389', photo:null },
                        { id:'s-12', name:'Shah Humayun Kabir', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'ICT', qualification:'N/A', email:'N/A', phone:'01505-210622', photo:null },
                        { id:'s-13', name:'Mostak Ahmed', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'Bangla', qualification:'N/A', email:'N/A', phone:'01918-156038', photo:null },
                        { id:'s-14', name:'Mohammad Alamgir', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'Philosophy', qualification:'N/A', email:'N/A', phone:'01914-603985', photo:null },
                        { id:'s-15', name:'Md. Saiful Islam', designation:'Assistant Professor', category:'teacher', isPrincipal:false, subject:'English', qualification:'N/A', email:'N/A', phone:'01912-182229', photo:null },
                        { id:'s-16', name:'Nadira Sultana', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Political Science', qualification:'N/A', email:'N/A', phone:'01936-985311', photo:null },
                        { id:'s-17', name:'Kamrun Nahar', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'History', qualification:'N/A', email:'N/A', phone:'01919-635600', photo:null },
                        { id:'s-18', name:'Shipra Sarkar', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Economics', qualification:'N/A', email:'N/A', phone:'01932-000682', photo:null },
                        { id:'s-19', name:'Mostafija Rusti', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Political Science', qualification:'N/A', email:'N/A', phone:'01916-816189', photo:null },
                        { id:'s-20', name:'Mohammad Golam Kibriya', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Islamic Studies', qualification:'N/A', email:'N/A', phone:'01920-098539', photo:null },
                        { id:'s-21', name:'Akhtari Jahan', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Philosophy', qualification:'N/A', email:'N/A', phone:'01932-868958', photo:null },
                        { id:'s-22', name:'Mahmuda Sultana', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Social Work', qualification:'N/A', email:'N/A', phone:'01911-699130', photo:null },
                        { id:'s-23', name:'Mohammad Habibur Rahman', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Botany', qualification:'N/A', email:'N/A', phone:'01952-353819', photo:null },
                        { id:'s-24', name:'Al Amin Ahmed', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Botany', qualification:'N/A', email:'N/A', phone:'01916-898525', photo:null },
                        { id:'s-25', name:'Md. Aminul Islam', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Chemistry', qualification:'N/A', email:'N/A', phone:'01923-560909', photo:null },
                        { id:'s-26', name:'Majedul Islam Akand', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Zoology', qualification:'N/A', email:'N/A', phone:'01990-318920', photo:null },
                        { id:'s-27', name:'Abu Saeed', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Zoology', qualification:'N/A', email:'N/A', phone:'01959-369992', photo:null },
                        { id:'s-28', name:'Md. Mahabbat Hosen', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Chemistry', qualification:'N/A', email:'N/A', phone:'01951-028509', photo:null },
                        { id:'s-29', name:'Md. Mostafizur Rahman', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Management', qualification:'N/A', email:'N/A', phone:'01989-222110', photo:null },
                        { id:'s-30', name:'Md. Anowar Hosen', designation:'Lecturer', category:'teacher', isPrincipal:false, subject:'Marketing', qualification:'N/A', email:'N/A', phone:'01984-262101', photo:null },
                        { id:'s-31', name:'Mirja Ahad Hosen', designation:'Demonstrator', category:'teacher', isPrincipal:false, subject:'Biology', qualification:'N/A', email:'N/A', phone:'01918-262898', photo:null },
                        { id:'s-32', name:'Md. Abul Hosen', designation:'Demonstrator', category:'teacher', isPrincipal:false, subject:'Physics', qualification:'N/A', email:'N/A', phone:'01916-889388', photo:null },
                        { id:'s-33', name:'Afsana Khanam', designation:'Co-Librarian', category:'teacher', isPrincipal:false, subject:'—', qualification:'N/A', email:'N/A', phone:'01626-010160', photo:null },
                        { id:'s-34', name:'Md. Abdul Aziz', designation:'Computer Operator Demonstrator', category:'teacher', isPrincipal:false, subject:'—', qualification:'N/A', email:'N/A', phone:'01919-336600', photo:null },
                        { id:'s-35', name:'Jobeda Khanam', designation:'Accounts Assistant', category:'admin', isPrincipal:false, subject:'Accounts', qualification:'N/A', email:'N/A', phone:'01918-820956', photo:null },
                        { id:'s-36', name:'Md. Suraj Ali', designation:'Accounts Assistant', category:'admin', isPrincipal:false, subject:'Accounts', qualification:'N/A', email:'N/A', phone:'01918-980986', photo:null },
                        { id:'s-37', name:'Md. Shafiqul Islam', designation:'Computer Operator', category:'admin', isPrincipal:false, subject:'Computer Operations', qualification:'N/A', email:'N/A', phone:'01988-986561', photo:null },
                        { id:'s-38', name:'Md. Shariyar Hosen', designation:'Lab Assistant', category:'admin', isPrincipal:false, subject:'Laboratory', qualification:'N/A', email:'N/A', phone:'01686-802261', photo:null },
                        { id:'s-39', name:'Mahfuja Aktar', designation:'Lab Assistant', category:'admin', isPrincipal:false, subject:'Laboratory', qualification:'N/A', email:'N/A', phone:'01983-606018', photo:null },
                        { id:'s-40', name:'Rakib-ul-Hasan', designation:'Lab Assistant', category:'admin', isPrincipal:false, subject:'Laboratory', qualification:'N/A', email:'N/A', phone:'01926-921292', photo:null },
                        { id:'s-41', name:'Shirifa Akhtar', designation:'Lab Assistant', category:'admin', isPrincipal:false, subject:'Laboratory', qualification:'N/A', email:'N/A', phone:'01926-921292', photo:null },
                        { id:'s-42', name:'Md. Emdadul Haq', designation:'Lab Assistant', category:'admin', isPrincipal:false, subject:'Laboratory', qualification:'N/A', email:'N/A', phone:'N/A', photo:null },
                        { id:'s-43', name:'Md. Abdul Hai', designation:'Peon', category:'support', isPrincipal:false, subject:'—', qualification:'N/A', email:'N/A', phone:'01981-508632', photo:null },
                        { id:'s-44', name:'Aferoj Aktar', designation:'Ayah', category:'support', isPrincipal:false, subject:'—', qualification:'N/A', email:'N/A', phone:'01933-886190', photo:null },
                        { id:'s-45', name:'Mocha. Rokeya Khatun', designation:'Office Assistant', category:'admin', isPrincipal:false, subject:'Office Work', qualification:'N/A', email:'N/A', phone:'N/A', photo:null },
                        { id:'s-46', name:'Md. Abu Hanif', designation:'Peon', category:'support', isPrincipal:false, subject:'—', qualification:'N/A', email:'N/A', phone:'01912-820880', photo:null },
                        { id:'s-47', name:'Md. Abdul Jabbar', designation:'Night Guard', category:'support', isPrincipal:false, subject:'—', qualification:'N/A', email:'N/A', phone:'N/A', photo:null },
                        { id:'s-48', name:'Rokeya Khatun', designation:'Cleaner', category:'support', isPrincipal:false, subject:'—', qualification:'N/A', email:'N/A', phone:'01988-589853', photo:null },
                        { id:'s-49', name:'Josna Begum', designation:'Peon', category:'support', isPrincipal:false, subject:'—', qualification:'N/A', email:'N/A', phone:'01968-909892', photo:null },
                        { id:'s-50', name:'Rejwana Yasmin', designation:'Peon', category:'support', isPrincipal:false, subject:'—', qualification:'N/A', email:'N/A', phone:'01938-628090', photo:null },
                        { id:'s-51', name:'Shalma Aktar', designation:'Peon', category:'support', isPrincipal:false, subject:'—', qualification:'N/A', email:'N/A', phone:'01866-295568', photo:null },
                        { id:'s-52', name:'Md. Khilulur Rahman', designation:'Peon', category:'support', isPrincipal:false, subject:'—', qualification:'N/A', email:'N/A', phone:'01939-251619', photo:null },
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

    /* Sticky filter bar — becomes sticky once hero scrolls past */
    const filterBar = document.getElementById('tsFilterBar');
    const heroEl    = document.querySelector('.ts-hero');
    const stickyObs = new IntersectionObserver(([entry]) => {
        filterBar.classList.toggle('sticky', !entry.isIntersecting);
    }, { threshold: 0 });
    stickyObs.observe(heroEl);

    /* Section heading reveal — uses same .visible class as main.css */
    const revealObs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                revealObs.unobserve(e.target);
            }
        });
    }, { threshold: .1 });
    document.querySelectorAll('.staff-section-head').forEach(el => revealObs.observe(el));
    </script>

<?php include '../includes/footer.php'; ?>
