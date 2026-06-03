/**
 * i18n.js — PMDC Bangla ↔ English Language Toggle
 * Uses data-i18n attributes on DOM elements.
 * Language stored in localStorage key: 'pmdc_lang'
 * Default language: 'bn' (Bangla)
 */

(function () {
    'use strict';

    /* ── Translation Dictionary ───────────────────────────── */
    const T = {

        /* ━━━━━━━━━━━ NAVIGATION & SHARED CHROME ━━━━━━━━━━━ */
        'nav.home': { en: 'Home', bn: 'হোম' },
        'nav.about': { en: 'About', bn: 'প্রতিষ্ঠান পরিচিতি' },
        'nav.academic': { en: 'Academic Info', bn: 'একাডেমিক তথ্য' },
        'nav.announcements': { en: 'Announcements', bn: 'বিজ্ঞপ্তি' },
        'nav.gallery': { en: 'Gallery', bn: 'গ্যালারি' },
        'nav.teachers': { en: 'Teachers & Staff', bn: 'শিক্ষক ও কর্মচারী' },
        'nav.results': { en: 'Results', bn: 'ফলাফল' },
        'nav.contact': { en: 'Contact', bn: 'যোগাযোগ' },
        'nav.apply': { en: 'Apply Now', bn: 'ভর্তি' },
        'nav.hsc': { en: 'HSC Program', bn: 'এইচএসসি প্রোগ্রাম' },
        'nav.degree': { en: 'Degree Program', bn: 'ডিগ্রি প্রোগ্রাম' },
        'nav.holiday': { en: 'Holiday List', bn: 'ছুটির তালিকা' },
        'nav.calendar': { en: 'Academic Calendar', bn: 'একাডেমিক ক্যালেন্ডার' },
        'nav.class-routine': { en: 'Class Routine', bn: 'ক্লাস রুটিন' },
        'nav.exam-routine': { en: 'Exam Routine', bn: 'পরীক্ষার রুটিন' },
        'nav.syllabus': { en: 'Syllabus', bn: 'পাঠ্যক্রম' },
        'nav.uniform': { en: 'Uniform', bn: 'পোশাক বিধি' },
        'nav.rules': { en: 'Rules & Regulation', bn: 'নিয়ম ও বিধিমালা' },
        'nav.instruction': { en: 'Student Instruction', bn: 'শিক্ষার্থী নির্দেশিকা' },
        'nav.admit': { en: 'Admit Card', bn: 'প্রবেশপত্র' },
        'nav.form-fillup': { en: 'HSC Form Fillup', bn: 'এইচএসসি ফর্ম পূরণ' },
        'nav.menu': { en: 'Menu', bn: 'মেনু' },
        'nav.language': { en: 'Language', bn: 'ভাষা' },

        /* ━━━━━━━━━━━ TOPBAR ━━━━━━━━━━━ */
        'topbar.library': { en: 'Library', bn: 'পাঠাগার' },
        'topbar.alumni': { en: 'Alumni', bn: 'প্রাক্তন শিক্ষার্থী' },
        'topbar.portal': { en: 'Portal', bn: 'পোর্টাল' },

        /* ━━━━━━━━━━━ NOTICE TICKER ━━━━━━━━━━━ */
        'ticker.label': { en: 'Notice', bn: 'নোটিশ' },
        'ticker.all':   { en: 'View All', bn: 'সব দেখুন' },

        /* ━━━━━━━━━━━ FOOTER ━━━━━━━━━━━ */
        'footer.desc': {
            en: 'Phulpur Mohila Degree College — empowering women through quality education since 1994. Offering HSC and degree programmes for women in Phulpur, Mymensingh.',
            bn: 'ফুলপুর মহিলা ডিগ্রি কলেজ — ১৯৯৪ সাল থেকে মানসম্পন্ন শিক্ষার মাধ্যমে নারীর ক্ষমতায়নে নিবেদিত। ফুলপুর, ময়মনসিংহে মহিলা শিক্ষার্থীদের জন্য এইচএসসি ও ডিগ্রি প্রোগ্রাম।'
        },
        'footer.quicklinks': { en: 'Quick Links', bn: 'দ্রুত সংযোগ' },
        'footer.academics': { en: 'Academics', bn: 'একাডেমিক' },
        'footer.contact': { en: 'Contact Us', bn: 'যোগাযোগ করুন' },
        'footer.home': { en: 'Home', bn: 'হোম' },
        'footer.about': { en: 'About Us', bn: 'প্রতিষ্ঠান পরিচিতি' },
        'footer.academicslink': { en: 'Academics', bn: 'একাডেমিক' },
        'footer.announcementslink': { en: 'Announcements', bn: 'বিজ্ঞপ্তি' },
        'footer.results': { en: 'Results', bn: 'ফলাফল' },
        'footer.contactlink': { en: 'Contact', bn: 'যোগাযোগ' },
        'footer.science': { en: 'Science Group', bn: 'বিজ্ঞান বিভাগ' },
        'footer.commerce': { en: 'Commerce Group', bn: 'ব্যবসায় শিক্ষা' },
        'footer.humanities': { en: 'Humanities Group', bn: 'মানবিক বিভাগ' },
        'footer.compulsory': { en: 'Compulsory Subjects', bn: 'বাধ্যতামূলক বিষয়' },
        'footer.examresults': { en: 'Exam Results', bn: 'পরীক্ষার ফলাফল' },
        'footer.hours': { en: 'Sun–Thu: 8:00 AM – 4:00 PM', bn: 'রবি–বৃহ: সকাল ৮:০০ – বিকাল ৪:০০' },
        'footer.privacy': { en: 'Privacy Policy', bn: 'গোপনীয়তা নীতি' },
        'footer.terms': { en: 'Terms of Use', bn: 'ব্যবহারের শর্ত' },
        'footer.staffportal': { en: 'Staff Portal', bn: 'স্টাফ পোর্টাল' },
        'footer.copyright': {
            en: 'Phulpur Mohila Degree College. All Rights Reserved.',
            bn: 'ফুলপুর মহিলা ডিগ্রি কলেজ। সর্বস্বত্ব সংরক্ষিত।'
        },

        /* ━━━━━━━━━━━ HOMEPAGE ━━━━━━━━━━━ */
        'home.hero.kicker': { en: 'Established in 1994', bn: '১৯৯৪ সালে প্রতিষ্ঠিত' },
        'home.hero.h1': {
            en: 'Empowering Women Through<br><em>Quality Education</em>',
            bn: 'মানসম্পন্ন শিক্ষার মাধ্যমে<br><em>নারীর ক্ষমতায়ন</em>'
        },
        'home.hero.desc': {
            en: 'Phulpur Mohila Degree College — a trusted institution for women\'s education in Phulpur. We offer HSC and degree programmes in a secure, disciplined environment for women students.',
            bn: 'ফুলপুর মহিলা ডিগ্রি কলেজ — ফুলপুরের নারী শিক্ষার এক নির্ভরযোগ্য প্রতিষ্ঠান। আমরা নিরাপদ ও সুশৃঙ্খল পরিবেশে মহিলা শিক্ষার্থীদের জন্য এইচএসসি ও ডিগ্রি প্রোগ্রাম পরিচালনা করি।'
        },
        'home.hero.btn1': { en: 'Explore Programmes', bn: 'প্রোগ্রামসমূহ দেখুন' },
        'home.hero.btn2': { en: 'Visit Us', bn: 'আমাদের পরিদর্শন করুন' },
        'home.hero.scroll': { en: 'Scroll to discover', bn: 'নিচে স্ক্রল করুন' },
        'home.stats.students': { en: 'Enrolled Students', bn: 'ভর্তি শিক্ষার্থী' },
        'home.stats.faculty': { en: 'Faculty Members', bn: 'শিক্ষকমণ্ডলী' },
        'home.stats.pass': { en: 'Board Pass Rate', bn: 'বোর্ড পাসের হার' },
        'home.stats.years': { en: 'Years of Excellence', bn: 'বছরের উৎকর্ষতা' },
        'home.about.kicker': { en: 'About Our College', bn: 'আমাদের কলেজ সম্পর্কে' },
        'home.about.h2': {
            en: 'A Legacy of Women\'s<br>Education in Phulpur',
            bn: 'ফুলপুরে নারী শিক্ষার<br>একটি ঐতিহ্য'
        },
        'home.about.p1': {
            en: 'Phulpur Mohila Degree College was established in 1994 with the collective effort of people across all political lines, with the goal of enabling women in Phulpur to pursue higher education equally alongside men.',
            bn: 'ফুলপুর মহিলা ডিগ্রি কলেজ ১৯৯৪ সালে সকল রাজনৈতিক দলের মানুষের সম্মিলিত প্রচেষ্টায় প্রতিষ্ঠিত হয়, যার লক্ষ্য ছিল ফুলপুরের নারীদের পুরুষের সমকক্ষে উচ্চশিক্ষার সুযোগ দেওয়া।'
        },
        'home.about.p2': {
            en: 'Degree programmes (BA, BSS, BSc) began from the 2003–2004 academic session, and HSC, including Business Management & Technology (BMT), began from the 2004–2005 session. The college has experienced and trained faculty, disciplined administration, strong security, a large computer lab, library, and CCTV surveillance.',
            bn: 'ডিগ্রি প্রোগ্রাম (বিএ, বিএসএস, বিএসসি) ২০০৩-২০০৪ শিক্ষাবর্ষ থেকে শুরু হয় এবং এইচএসসি, ব্যবসায় ব্যবস্থাপনা ও প্রযুক্তি (বিএমটি) সহ ২০০৪-২০০৫ শিক্ষাবর্ষ থেকে চালু হয়। কলেজে অভিজ্ঞ শিক্ষকমণ্ডলী, সুশৃঙ্খল প্রশাসন, শক্তিশালী নিরাপত্তা, বড় কম্পিউটার ল্যাব, পাঠাগার এবং সিসিটিভি নজরদারি রয়েছে।'
        },
        'home.about.feat1': { en: 'Women-only campus in Phulpur, Mymensingh', bn: 'ফুলপুর, ময়মনসিংহে শুধুমাত্র মহিলাদের ক্যাম্পাস' },
        'home.about.feat2': { en: 'HSC and degree programmes offered', bn: 'এইচএসসি এবং ডিগ্রি প্রোগ্রাম প্রদান' },
        'home.about.feat3': { en: 'Experienced and trained faculty', bn: 'অভিজ্ঞ ও প্রশিক্ষিত শিক্ষকমণ্ডলী' },
        'home.about.feat4': { en: 'Large computer lab, library, and CCTV surveillance', bn: 'বড় কম্পিউটার ল্যাব, পাঠাগার ও সিসিটিভি' },
        'home.about.feat5': { en: 'Disciplined and secure academic environment', bn: 'সুশৃঙ্খল ও নিরাপদ শিক্ষা পরিবেশ' },
        'home.about.btn': { en: 'Read Our History', bn: 'আমাদের ইতিহাস পড়ুন' },
        'home.why.kicker': { en: 'Why PMDC', bn: 'কেন পিএমডিসি' },
        'home.why.h2': { en: 'Built for Women\'s Success', bn: 'নারীর সাফল্যের জন্য নির্মিত' },
        'home.why.sub': {
            en: 'Everything we do is centred around academic excellence, safety, and the empowerment of every student.',
            bn: 'আমরা যা করি তার সবকিছু একাডেমিক উৎকর্ষতা, নিরাপত্তা এবং প্রতিটি শিক্ষার্থীর ক্ষমতায়নকে কেন্দ্র করে।'
        },
        'home.why.c1.h': { en: 'Board-Affiliated Programmes', bn: 'বোর্ড অনুমোদিত প্রোগ্রাম' },
        'home.why.c1.p': {
            en: 'All programmes are recognised under the Bangladesh Education Board, ensuring your qualifications are nationally valid and respected.',
            bn: 'সমস্ত প্রোগ্রাম বাংলাদেশ শিক্ষা বোর্ডের অধীনে স্বীকৃত, যা আপনার যোগ্যতাকে জাতীয়ভাবে বৈধ ও সম্মানিত করে।'
        },
        'home.why.c2.h': { en: 'Qualified Faculty', bn: 'যোগ্য শিক্ষকমণ্ডলী' },
        'home.why.c2.p': {
            en: 'Our teaching staff brings years of experience and dedication, providing individualised attention to every student.',
            bn: 'আমাদের শিক্ষকমণ্ডলী বছরের পর বছরের অভিজ্ঞতা ও নিষ্ঠা নিয়ে প্রতিটি শিক্ষার্থীকে ব্যক্তিগত মনোযোগ দেন।'
        },
        'home.why.c3.h': { en: 'Safe Campus', bn: 'নিরাপদ ক্যাম্পাস' },
        'home.why.c3.p': {
            en: 'A women-only campus environment that prioritises safety, comfort, and a distraction-free learning experience.',
            bn: 'একটি শুধুমাত্র মহিলাদের ক্যাম্পাস পরিবেশ যা নিরাপত্তা, স্বস্তি এবং বিঘ্নমুক্ত শিক্ষার অভিজ্ঞতাকে অগ্রাধিকার দেয়।'
        },
        'home.why.c4.h': { en: 'Modern Facilities', bn: 'আধুনিক সুবিধাসমূহ' },
        'home.why.c4.p': {
            en: 'Well-equipped science labs, ICT infrastructure, and a fully stocked library to support modern learning needs.',
            bn: 'সুসজ্জিত বিজ্ঞান ল্যাব, তথ্য প্রযুক্তি অবকাঠামো এবং আধুনিক শিক্ষার চাহিদা পূরণে সমৃদ্ধ পাঠাগার।'
        },
        'home.why.c5.h': { en: 'Scholarship Programme', bn: 'বৃত্তি কার্যক্রম' },
        'home.why.c5.p': {
            en: 'Merit-based and need-based scholarships are available to help talented students pursue their education without financial barriers.',
            bn: 'মেধা ও প্রয়োজন ভিত্তিক বৃত্তি প্রদান করা হয় যাতে মেধাবী শিক্ষার্থীরা আর্থিক বাধা ছাড়াই শিক্ষা চালিয়ে যেতে পারে।'
        },
        'home.why.c6.h': { en: 'Strong Community', bn: 'শক্তিশালী সম্প্রদায়' },
        'home.why.c6.p': {
            en: 'An active alumni network and a culture of mutual support that extends well beyond graduation.',
            bn: 'একটি সক্রিয় প্রাক্তন শিক্ষার্থী নেটওয়ার্ক এবং পারস্পরিক সহায়তার সংস্কৃতি যা স্নাতকের পরেও অব্যাহত থাকে।'
        },
        'home.hsc.kicker': { en: 'HSC & Degree Programmes', bn: 'এইচএসসি ও ডিগ্রি প্রোগ্রাম' },
        'home.hsc.h2': { en: 'Academic Groups (বিভাগসমূহ)', bn: 'বিভাগসমূহ' },
        'home.hsc.sub': {
            en: 'Choose your academic group for Class XI–XII, or explore the degree programmes offered by the college.',
            bn: 'একাদশ-দ্বাদশ শ্রেণির জন্য আপনার একাডেমিক বিভাগ বেছে নিন, অথবা কলেজের ডিগ্রি প্রোগ্রামগুলো অন্বেষণ করুন।'
        },
        'home.sci.h3': { en: 'Science Group', bn: 'বিজ্ঞান বিভাগ' },
        'home.sci.p': {
            en: 'Physics, Chemistry, Biology & Higher Mathematics — building the next generation of scientists, doctors, and engineers.',
            bn: 'পদার্থ, রসায়ন, জীববিজ্ঞান ও উচ্চতর গণিত — পরবর্তী প্রজন্মের বিজ্ঞানী, ডাক্তার ও প্রকৌশলী গড়ে তোলে।'
        },
        'home.com.h3': { en: 'Commerce Group', bn: 'ব্যবসায় শিক্ষা বিভাগ' },
        'home.com.p': {
            en: 'Accounting, Finance & Banking, Business Organisation & Management — shaping the business leaders of tomorrow.',
            bn: 'হিসাববিজ্ঞান, অর্থ ও ব্যাংকিং, ব্যবসায় সংগঠন ও ব্যবস্থাপনা — আগামীর ব্যবসায়িক নেতৃত্ব গড়ে তোলে।'
        },
        'home.hum.h3': { en: 'Humanities Group', bn: 'মানবিক বিভাগ' },
        'home.hum.p': {
            en: 'Civics, Sociology, Economics, History & Geography — nurturing thoughtful citizens and compassionate social thinkers.',
            bn: 'পৌরনীতি, সমাজবিজ্ঞান, অর্থনীতি, ইতিহাস ও ভূগোল — চিন্তাশীল নাগরিক ও সহানুভূতিশীল সামাজিক চিন্তাবিদ গড়ে তোলে।'
        },
        'home.comp.h3': { en: 'Compulsory Subjects', bn: 'বাধ্যতামূলক বিষয়' },
        'home.comp.p': {
            en: 'All students study Bangla, English, and ICT regardless of their group selection.',
            bn: 'সব শিক্ষার্থী তাদের বিভাগ নির্বিশেষে বাংলা, ইংরেজি ও তথ্যপ্রযুক্তি পড়েন।'
        },
        'home.viewsubjects': { en: 'View Subjects', bn: 'বিষয়সমূহ দেখুন' },
        'home.degree.kicker': { en: 'Degree Programmes', bn: 'ডিগ্রি প্রোগ্রামসমূহ' },
        'home.degree.h2': { en: 'Bachelor\'s Degree (ডিগ্রি কোর্স)', bn: 'স্নাতক ডিগ্রি (ডিগ্রি কোর্স)' },
        'home.degree.sub': {
            en: 'Under the National University of Bangladesh — 3-year degree programmes offered since 2003–2004.',
            bn: 'বাংলাদেশ জাতীয় বিশ্ববিদ্যালয়ের অধীনে — ২০০৩-২০০৪ সাল থেকে ৩ বছরের ডিগ্রি প্রোগ্রাম।'
        },
        'home.ba.h3': { en: 'Bachelor of Arts', bn: 'কলা বিভাগ (বিএ)' },
        'home.ba.p': {
            en: 'History, Philosophy, Political Science & Islamic Studies — a 3-year liberal arts programme.',
            bn: 'ইতিহাস, দর্শন, রাষ্ট্রবিজ্ঞান ও ইসলামিক স্টাডিজ — ৩ বছরের উদার কলা প্রোগ্রাম।'
        },
        'home.bss.h3': { en: 'Bachelor of Social Science', bn: 'সমাজবিজ্ঞান বিভাগ (বিএসএস)' },
        'home.bss.p': {
            en: 'Economics, Social Welfare, Political Science & Islamic Studies — building socially conscious leaders.',
            bn: 'অর্থনীতি, সমাজকল্যাণ, রাষ্ট্রবিজ্ঞান ও ইসলামিক স্টাডিজ — সামাজিকভাবে সচেতন নেতৃত্ব গড়ে তোলে।'
        },
        'home.bsc.h3': { en: 'Bachelor of Science', bn: 'বিজ্ঞান বিভাগ (বিএসসি)' },
        'home.bsc.p': {
            en: 'Botany, Zoology & Chemistry — a rigorous science programme.',
            bn: 'উদ্ভিদবিজ্ঞান, প্রাণিবিজ্ঞান ও রসায়ন — একটি কঠোর বিজ্ঞান প্রোগ্রাম।'
        },
        'home.bmt.h3': { en: 'Business Management & Technology', bn: 'ব্যবসায় ব্যবস্থাপনা ও প্রযুক্তি (বিএমটি)' },
        'home.bmt.p': {
            en: 'Accounting, Marketing, Economics & Digital Technology — a modern programme blending business with technology.',
            bn: 'হিসাববিজ্ঞান, বিপণন, অর্থনীতি ও ডিজিটাল প্রযুক্তি — ব্যবসা ও প্রযুক্তির সমন্বয়ে আধুনিক প্রোগ্রাম।'
        },
        'home.viewprog': { en: 'View Programme', bn: 'প্রোগ্রাম দেখুন' },
        'home.degree.nu': { en: 'Conducted by National University of Bangladesh', bn: 'বাংলাদেশ জাতীয় বিশ্ববিদ্যালয় কর্তৃক পরিচালিত' },
        'home.degree.btn': { en: 'View Full Details', bn: 'সম্পূর্ণ বিবরণ দেখুন' },
        'home.news.kicker': { en: 'Latest Updates', bn: 'সর্বশেষ আপডেট' },
        'home.news.h2': { en: 'News & Events', bn: 'নোটিশ ও ইভেন্ট' },
        'home.news.sub': {
            en: 'Stay informed about college news, examination schedules, and upcoming events.',
            bn: 'কলেজের নোটিশ, পরীক্ষার সময়সূচি এবং আসন্ন ইভেন্ট সম্পর্কে আপডেট থাকুন।'
        },
        'home.news.viewresults': { en: 'View Results', bn: 'ফলাফল দেখুন' },
        'home.news.readmore': { en: 'Read More', bn: 'আরও পড়ুন' },
        'home.events.h3': { en: 'Upcoming Events', bn: 'আসন্ন অনুষ্ঠানসমূহ' },

        /* ━━━━━━━━━━━ ANNOUNCEMENTS PAGE ━━━━━━━━━━━ */
        'ann.kicker': { en: 'PMDC Updates', bn: 'পিএমডিসি আপডেট' },
        'ann.h1': { en: 'Announcements & Notices', bn: 'বিজ্ঞপ্তি ও নোটিশ' },
        'ann.desc': {
            en: 'Stay updated with the latest news, exam schedules, and important notices from Phulpur Mohila Degree College.',
            bn: 'ফুলপুর মহিলা ডিগ্রি কলেজের সর্বশেষ নোটিশ, পরীক্ষার সময়সূচি এবং গুরুত্বপূর্ণ নোটিশ সম্পর্কে আপডেট থাকুন।'
        },
        'ann.filter.all': { en: 'All', bn: 'সব' },
        'ann.filter.academic': { en: 'Academic', bn: 'একাডেমিক' },
        'ann.filter.admission': { en: 'Admission', bn: 'ভর্তি' },
        'ann.filter.events': { en: 'Events', bn: 'অনুষ্ঠান' },
        'ann.filter.notices': { en: 'Notices', bn: 'নোটিশ' },
        'ann.sidebar.quickaccess': { en: 'Quick Access', bn: 'দ্রুত অ্যাক্সেস' },
        'ann.sidebar.examresults': { en: 'Exam Results', bn: 'পরীক্ষার ফলাফল' },
        'ann.sidebar.hscresults': { en: 'View HSC board results', bn: 'এইচএসসি বোর্ড ফলাফল দেখুন' },
        'ann.sidebar.academics': { en: 'Academics', bn: 'একাডেমিক' },
        'ann.sidebar.groups': { en: 'Groups & subjects', bn: 'বিভাগ ও বিষয়' },
        'ann.sidebar.contact': { en: 'Contact Office', bn: 'অফিসে যোগাযোগ' },
        'ann.sidebar.touch': { en: 'Get in touch', bn: 'যোগাযোগ করুন' },
        'ann.sidebar.portal': { en: 'Staff Portal', bn: 'স্টাফ পোর্টাল' },
        'ann.sidebar.login': { en: 'Teacher / Admin login', bn: 'শিক্ষক / প্রশাসন লগইন' },
        'ann.sidebar.events': { en: 'Upcoming Events', bn: 'আসন্ন অনুষ্ঠান' },
        'ann.sidebar.parents': { en: 'Parents\' Meeting', bn: 'অভিভাবক সমাবেশ' },
        'ann.sidebar.cultural': { en: 'Annual Cultural Programme', bn: 'বার্ষিক সাংস্কৃতিক অনুষ্ঠান' },
        'ann.sidebar.hscboard': { en: 'HSC Board Exam', bn: 'এইচএসসি বোর্ড পরীক্ষা' },
        'ann.sidebar.admission': { en: 'Class XI Admission Last Date', bn: 'একাদশ শ্রেণি ভর্তির শেষ তারিখ' },
        'ann.noResults': { en: 'No announcements in this category.', bn: 'এই বিভাগে কোনো বিজ্ঞপ্তি নেই।' },

        /* ━━━━━━━━━━━ TEACHERS PAGE ━━━━━━━━━━━ */
        'ts.kicker': { en: 'Our Team', bn: 'আমাদের দল' },
        'ts.h1': { en: 'Teachers & Staff', bn: 'শিক্ষক ও কর্মচারী' },
        'ts.desc': {
            en: 'Meet the dedicated team behind Phulpur Mohila Degree College',
            bn: 'ফুলপুর মহিলা ডিগ্রি কলেজের নিবেদিতপ্রাণ দলের সাথে পরিচিত হন'
        },
        'ts.filter.all': { en: 'All', bn: 'সকলে' },
        'ts.filter.teachers': { en: 'Teachers', bn: 'শিক্ষকবৃন্দ' },
        'ts.filter.admin': { en: 'Admin', bn: 'প্রশাসন' },
        'ts.filter.support': { en: 'Support', bn: 'সহকারী' },
        'ts.search.ph': { en: 'Search by name or designation...', bn: 'নাম বা পদবি দিয়ে খুঁজুন...' },
        'ts.sec.teachers': { en: 'Teaching Staff', bn: 'শিক্ষকবৃন্দ' },
        'ts.sec.admin': { en: 'Administrative Staff', bn: 'প্রশাসনিক কর্মচারী' },
        'ts.sec.support': { en: 'Support Staff', bn: 'সহায়তা কর্মচারী' },

        /* ━━━━━━━━━━━ HOLIDAY LIST ━━━━━━━━━━━ */
        'hl.kicker': { en: 'Academic Info', bn: 'একাডেমিক তথ্য' },
        'hl.h1': { en: 'Holiday List', bn: 'ছুটির তালিকা' },
        'hl.desc': {
            en: 'Official public holidays and college holidays for the current academic session',
            bn: 'চলতি শিক্ষাবর্ষের সরকারি ছুটি ও কলেজ ছুটির তালিকা'
        },
        'hl.session': { en: 'Academic Session:', bn: 'শিক্ষাবর্ষ:' },
        'hl.updated': { en: 'Last Updated:', bn: 'সর্বশেষ আপডেট:' },
        'hl.print': { en: 'Print', bn: 'প্রিন্ট' },
        'hl.badge.govt': { en: 'Government', bn: 'সরকারি' },
        'hl.badge.college': { en: 'College', bn: 'কলেজ' },
        'hl.badge.religious': { en: 'Religious', bn: 'ধর্মীয়' },
        'hl.th.num': { en: '#', bn: '#' },
        'hl.th.name': { en: 'Holiday Name', bn: 'ছুটির নাম' },
        'hl.th.date': { en: 'Date', bn: 'তারিখ' },
        'hl.th.day': { en: 'Day', bn: 'বার' },
        'hl.th.type': { en: 'Type', bn: 'ধরন' },

        /* ━━━━━━━━━━━ ACADEMIC CALENDAR ━━━━━━━━━━━ */
        'cal.kicker': { en: 'Academic Info', bn: 'একাডেমিক তথ্য' },
        'cal.h1': { en: 'Academic Calendar', bn: 'একাডেমিক ক্যালেন্ডার' },
        'cal.desc': {
            en: 'Annual academic schedule and key dates for the current session',
            bn: 'চলতি শিক্ষাবর্ষের বার্ষিক একাডেমিক সময়সূচি ও গুরুত্বপূর্ণ তারিখ'
        },
        'cal.print': { en: 'Print', bn: 'প্রিন্ট' },
        'cal.updated': { en: 'Last Updated:', bn: 'সর্বশেষ আপডেট:' },

        /* ━━━━━━━━━━━ CLASS ROUTINE ━━━━━━━━━━━ */
        'cr.kicker': { en: 'Academic Info', bn: 'একাডেমিক তথ্য' },
        'cr.h1': { en: 'Class Routine', bn: 'ক্লাস রুটিন' },
        'cr.desc': {
            en: 'Weekly class schedule for HSC and degree programme students',
            bn: 'এইচএসসি ও ডিগ্রি প্রোগ্রামের শিক্ষার্থীদের সাপ্তাহিক ক্লাস সময়সূচি'
        },
        'cr.print': { en: 'Print', bn: 'প্রিন্ট' },
        'cr.updated': { en: 'Last Updated:', bn: 'সর্বশেষ আপডেট:' },

        /* ━━━━━━━━━━━ EXAM ROUTINE ━━━━━━━━━━━ */
        'er.kicker': { en: 'Academic Info', bn: 'একাডেমিক তথ্য' },
        'er.h1': { en: 'Exam Routine', bn: 'পরীক্ষার রুটিন' },
        'er.desc': {
            en: 'Examination schedule for internal and board examinations',
            bn: 'অভ্যন্তরীণ ও বোর্ড পরীক্ষার সময়সূচি'
        },
        'er.print': { en: 'Print', bn: 'প্রিন্ট' },
        'er.updated': { en: 'Last Updated:', bn: 'সর্বশেষ আপডেট:' },

        /* ━━━━━━━━━━━ SYLLABUS ━━━━━━━━━━━ */
        'syl.kicker': { en: 'Academic Info', bn: 'একাডেমিক তথ্য' },
        'syl.h1': { en: 'Syllabus', bn: 'পাঠ্যক্রম' },
        'syl.desc': {
            en: 'Board-prescribed syllabus for all groups and subjects',
            bn: 'সকল বিভাগ ও বিষয়ের বোর্ড নির্ধারিত পাঠ্যক্রম'
        },
        'syl.print': { en: 'Print', bn: 'প্রিন্ট' },
        'syl.updated': { en: 'Last Updated:', bn: 'সর্বশেষ আপডেট:' },

        /* ━━━━━━━━━━━ UNIFORM ━━━━━━━━━━━ */
        'uni.kicker': { en: 'Academic Info', bn: 'একাডেমিক তথ্য' },
        'uni.h1': { en: 'Uniform', bn: 'পোশাক বিধি' },
        'uni.desc': {
            en: 'Official PMDC uniform guidelines for all students',
            bn: 'সকল শিক্ষার্থীদের জন্য পিএমডিসির সরকারি পোশাক বিধিমালা'
        },
        'uni.dressheading': {
            en: 'Official Dress Code — Mandatory for all students',
            bn: 'সরকারি পোশাক বিধি — সকল শিক্ষার্থীর জন্য বাধ্যতামূলক'
        },
        'uni.print': { en: 'Print', bn: 'প্রিন্ট' },
        'uni.updated': { en: 'Last Updated:', bn: 'সর্বশেষ আপডেট:' },
        'uni.forstudents': { en: 'For Students', bn: 'শিক্ষার্থীদের জন্য' },
        'uni.item1': { en: 'White shalwar', bn: 'সাদা সালোয়ার' },
        'uni.item2': { en: 'White kamiz', bn: 'সাদা কামিজ' },
        'uni.item3': { en: 'Navy blue orna', bn: 'নেভি নীল ওড়না' },
        'uni.item4': { en: 'Navy blue belt', bn: 'নেভি নীল বেল্ট' },
        'uni.item5': { en: 'White socks', bn: 'সাদা মোজা' },
        'uni.item6': { en: 'White canvas shoes', bn: 'সাদা ক্যানভাস জুতো' },
        'uni.item7': { en: 'White apron', bn: 'সাদা অ্যাপ্রোন' },
        'uni.item8': { en: 'White scarf', bn: 'সাদা স্কার্ফ' },
        'uni.notes.h': { en: 'Important Notes', bn: 'গুরুত্বপূর্ণ নোট' },
        'uni.note1': {
            en: 'Students are required to wear the prescribed uniform to college regularly.',
            bn: 'শিক্ষার্থীদের নিয়মিতভাবে নির্ধারিত পোশাক পরিধান করতে হবে।'
        },
        'uni.note2': {
            en: 'Every student must obtain an identity card and wear it around the neck.',
            bn: 'প্রতিটি শিক্ষার্থীকে পরিচয়পত্র সংগ্রহ করে গলায় পরতে হবে।'
        },
        'uni.note3': {
            en: 'No improper or disorderly behavior outside the college is permitted while in college dress.',
            bn: 'কলেজের পোশাকে কলেজের বাইরে কোনো অশোভন বা অশৃঙ্খল আচরণ করা যাবে না।'
        },
        'uni.note4': {
            en: 'Uniform should be kept clean and well-arranged at all times.',
            bn: 'পোশাক সবসময় পরিষ্কার ও সুবিন্যস্ত রাখতে হবে।'
        },
        'uni.note5': {
            en: 'The college may take disciplinary action for repeated uniform violations.',
            bn: 'বারবার পোশাক বিধি লঙ্ঘনের জন্য কলেজ শৃঙ্খলামূলক ব্যবস্থা নিতে পারে।'
        },
        'uni.reminder': { en: 'Uniform Reminder', bn: 'পোশাক অনুস্মারক' },
        'uni.dresscode': { en: 'Dress Code', bn: 'পোশাক বিধি' },
        'uni.dresscodeVal': {
            en: 'White shalwar, white kamiz, navy blue orna, navy blue belt',
            bn: 'সাদা সালোয়ার, সাদা কামিজ, নেভি নীল ওড়না, নেভি নীল বেল্ট'
        },
        'uni.footwear': { en: 'Footwear', bn: 'পাদুকা' },
        'uni.footwearVal': { en: 'White socks and white canvas shoes', bn: 'সাদা মোজা ও সাদা ক্যানভাস জুতো' },
        'uni.additional': { en: 'Additional Items', bn: 'অতিরিক্ত সামগ্রী' },
        'uni.additionalVal': { en: 'White apron and white scarf', bn: 'সাদা অ্যাপ্রোন ও সাদা স্কার্ফ' },
        'uni.requirement': { en: 'Requirement', bn: 'বাধ্যবাধকতা' },
        'uni.requirementVal': { en: 'Uniform is mandatory for all students', bn: 'সকল শিক্ষার্থীর জন্য পোশাক বাধ্যতামূলক' },
        'uni.query': {
            en: 'For any queries regarding the uniform, please contact the college office during working hours.',
            bn: 'পোশাক সংক্রান্ত যেকোনো জিজ্ঞাসার জন্য অফিস সময়ে কলেজ অফিসে যোগাযোগ করুন।'
        },

        /* ━━━━━━━━━━━ RULES & REGULATION ━━━━━━━━━━━ */
        'rr.kicker': { en: 'Academic Info', bn: 'একাডেমিক তথ্য' },
        'rr.h1': { en: 'Rules & Regulation', bn: 'নিয়ম ও বিধিমালা' },
        'rr.desc': {
            en: 'Code of conduct and institutional regulations for all students',
            bn: 'সকল শিক্ষার্থীর জন্য আচরণ বিধি ও প্রাতিষ্ঠানিক নিয়মাবলি'
        },
        'rr.print': { en: 'Print', bn: 'প্রিন্ট' },
        'rr.updated': { en: 'Last Updated:', bn: 'সর্বশেষ আপডেট:' },

        /* ━━━━━━━━━━━ STUDENT INSTRUCTION ━━━━━━━━━━━ */
        'si.kicker': { en: 'Academic Info', bn: 'একাডেমিক তথ্য' },
        'si.h1': { en: 'Student Instruction', bn: 'শিক্ষার্থী নির্দেশিকা' },
        'si.desc': {
            en: 'Important instructions and guidelines for all PMDC students',
            bn: 'পিএমডিসির সকল শিক্ষার্থীদের জন্য গুরুত্বপূর্ণ নির্দেশনা ও নির্দেশিকা'
        },
        'si.print': { en: 'Print', bn: 'প্রিন্ট' },
        'si.updated': { en: 'Last Updated:', bn: 'সর্বশেষ আপডেট:' },

        /* ━━━━━━━━━━━ ADMIT CARD ━━━━━━━━━━━ */
        'ac.kicker': { en: 'Academic Info', bn: 'একাডেমিক তথ্য' },
        'ac.h1': { en: 'Admit Card', bn: 'প্রবেশপত্র' },
        'ac.desc': {
            en: 'Information on collecting and using your examination admit card',
            bn: 'পরীক্ষার প্রবেশপত্র সংগ্রহ ও ব্যবহার সংক্রান্ত তথ্য'
        },
        'ac.print': { en: 'Print', bn: 'প্রিন্ট' },
        'ac.updated': { en: 'Last Updated:', bn: 'সর্বশেষ আপডেট:' },

        /* ━━━━━━━━━━━ HSC FORM FILLUP ━━━━━━━━━━━ */
        'ff.kicker': { en: 'Academic Info', bn: 'একাডেমিক তথ্য' },
        'ff.h1': { en: 'HSC Form Fillup', bn: 'এইচএসসি ফর্ম পূরণ' },
        'ff.desc': {
            en: 'Guidelines for completing your HSC board examination registration form',
            bn: 'এইচএসসি বোর্ড পরীক্ষার নিবন্ধন ফর্ম পূরণের নির্দেশিকা'
        },
        'ff.print': { en: 'Print', bn: 'প্রিন্ট' },
        'ff.updated': { en: 'Last Updated:', bn: 'সর্বশেষ আপডেট:' },

        /* ━━━━━━━━━━━ MODAL ━━━━━━━━━━━ */
        'modal.desc': {
            en: 'This feature is currently under development. Please contact the college office for assistance.',
            bn: 'এই ফিচারটি বর্তমানে উন্নয়নাধীন। সহায়তার জন্য কলেজ অফিসে যোগাযোগ করুন।'
        },
        'modal.close': { en: 'Close', bn: 'বন্ধ করুন' },

        /* ━━━━━━━━━━━ GALLERY PAGE ━━━━━━━━━━━ */
        'gallery.kicker':         { en: 'Our Gallery',        bn: 'আমাদের গ্যালারি' },
        'gallery.h1':             { en: 'Gallery',            bn: 'গ্যালারি' },
        'gallery.desc':           { en: 'Photos from events, campus life, and ceremonies',
                                   bn: 'ইভেন্ট, ক্যাম্পাস জীবন ও অনুষ্ঠানের ছবিসমূহ' },
        'gallery.stat.photos':    { en: 'Total Photos',       bn: 'মোট ছবি' },
        'gallery.stat.years':     { en: 'Years',              bn: 'বছর' },
        'gallery.stat.latest':    { en: 'Latest Year',        bn: 'সর্বশেষ' },
        'gallery.filter.all':     { en: 'All',                bn: 'সব' },
        'gallery.photos':         { en: 'Photos',             bn: 'ছবি' },
        'gallery.loadmore':       { en: 'Load More Photos',   bn: 'আরও ছবি দেখুন' },
        'gallery.empty.title':    { en: 'No photos available yet.', bn: 'এখনো কোনো ছবি নেই।' },
        'gallery.empty.sub':      { en: 'Check back soon for updates.', bn: 'শীঘ্রই আপডেট করা হবে।' }
    };

    /* ── Core engine ──────────────────────────────────────── */
    const STORAGE_KEY = 'pmdc_lang';
    const DEFAULT_LANG = 'bn';

    let currentLang = DEFAULT_LANG;

    function getLang() {
        try {
            return localStorage.getItem(STORAGE_KEY) || DEFAULT_LANG;
        } catch (_) { return DEFAULT_LANG; }
    }

    function setLang(lang) {
        try { localStorage.setItem(STORAGE_KEY, lang); } catch (_) { }
    }

    function applyLang(lang) {
        currentLang = lang;
        setLang(lang);

        // Set html lang attribute
        document.documentElement.lang = lang === 'bn' ? 'bn' : 'en';

        // Update browser tab title from <meta name="title-bn"> / <meta name="title-en">
        const titleMeta = document.querySelector('meta[name="title-' + lang + '"]');
        if (titleMeta && titleMeta.content) {
            document.title = titleMeta.content;
        }

        // Apply translations
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            const isHtml = el.hasAttribute('data-i18n-html');
            const entry = T[key];
            if (!entry) return;
            const val = entry[lang] || entry[DEFAULT_LANG];
            if (isHtml) {
                el.innerHTML = val;
            } else {
                el.textContent = val;
            }
        });

        // Update placeholder attributes
        document.querySelectorAll('[data-i18n-ph]').forEach(el => {
            const key = el.getAttribute('data-i18n-ph');
            const entry = T[key];
            if (!entry) return;
            el.placeholder = entry[lang] || entry[DEFAULT_LANG];
        });

        // Update toggle button states
        const btnBn = document.getElementById('langBn');
        const btnEn = document.getElementById('langEn');
        if (btnBn && btnEn) {
            btnBn.classList.toggle('lang-active', lang === 'bn');
            btnEn.classList.toggle('lang-active', lang === 'en');
        }
        // Also update mobile float toggle if present
        const mbBn = document.getElementById('mobileLangBn');
        const mbEn = document.getElementById('mobileLangEn');
        if (mbBn && mbEn) {
            mbBn.classList.toggle('lang-active', lang === 'bn');
            mbEn.classList.toggle('lang-active', lang === 'en');
        }
    }

    function toggleLang(lang) {
        applyLang(lang);
    }

    /* ── Inject toggle buttons ────────────────────────────── */
    function injectToggle() {
        // Desktop: inject into top-links
        const topLinks = document.querySelector('.top-links');
        if (topLinks && !document.getElementById('topLangToggle')) {
            const wrap = document.createElement('div');
            wrap.id = 'topLangToggle';
            wrap.className = 'top-lang-toggle';
            wrap.innerHTML = `
                <button class="lang-btn lang-active" id="langBn" aria-label="বাংলা">বাংলা</button>
                <button class="lang-btn" id="langEn" aria-label="English">EN</button>`;
            topLinks.appendChild(wrap);

            document.getElementById('langBn').addEventListener('click', () => toggleLang('bn'));
            document.getElementById('langEn').addEventListener('click', () => toggleLang('en'));
        }

        // Mobile: buttons are hardcoded in header.php — just wire up events
        const mbBnBtn = document.getElementById('mobileLangBn');
        const mbEnBtn = document.getElementById('mobileLangEn');
        if (mbBnBtn && mbEnBtn) {
            mbBnBtn.addEventListener('click', () => toggleLang('bn'));
            mbEnBtn.addEventListener('click', () => toggleLang('en'));
        }
    }

    /* ── Init ─────────────────────────────────────────────── */
    function init() {
        const lang = getLang();
        injectToggle();
        applyLang(lang);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose for manual calls if needed
    window.PMDC_i18n = { toggle: toggleLang, current: () => currentLang };

})();
