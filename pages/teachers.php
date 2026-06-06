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

    async function loadStaff() {
        try {
            const res = await fetch('portal/admin/api/staff.php?action=list');
            const data = await res.json();
            if (data.ok) return data.staff;
        } catch (e) {
            console.error('Error fetching staff data', e);
        }
        return [];
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
            return `<img src="../${member.photo}" alt="${esc(member.name)}" class="staff-photo" style="width:${size}px;height:${size}px;">`;
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
    let staff = [];

    async function init() {
        staff = await loadStaff();
        render(staff, searchQuery, currentFilter);
    }
    init();

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
