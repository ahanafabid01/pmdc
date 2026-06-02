<?php
$page       = 'home';
$page_title = 'Phulpur Mohila Degree College | Excellence in Education';
include 'includes/header.php';
?>

    <!-- ══════════════════ HERO ══════════════════ -->
    <header class="hero" id="home">
        <div class="hero-slider" aria-hidden="true">
            <div class="hero-slide active" style="background-image:url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=1920&q=80');"></div>
            <div class="hero-slide" style="background-image:url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=1920&q=80');"></div>
            <div class="hero-slide" style="background-image:url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920&q=80');"></div>
            <div class="hero-slide" style="background-image:url('https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=1920&q=80');"></div>
            <div class="hero-slide" style="background-image:url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1920&q=80');"></div>
        </div>
        <button class="hero-slider-btn hero-slider-prev" type="button" aria-label="Previous hero image">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="hero-slider-btn hero-slider-next" type="button" aria-label="Next hero image">
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="container">
            <div class="hero-content">
                <div class="hero-kicker" data-i18n="home.hero.kicker">১৯৯৪ সালে প্রতিষ্ঠিত</div>
                <h1 data-i18n="home.hero.h1" data-i18n-html="true">
                    মানসম্পন্ন শিক্ষার মাধ্যমে<br>
                    <em>নারীর ক্ষমতায়ন</em>
                </h1>
                <p class="hero-desc" data-i18n="home.hero.desc">
                    ফুলপুর মহিলা ডিগ্রি কলেজ — ফুলপুরের নারী শিক্ষার এক নির্ভরযোগ্য প্রতিষ্ঠান। আমরা নিরাপদ ও সুশৃঙ্খল পরিবেশে মহিলা শিক্ষার্থীদের জন্য এইচএসসি ও ডিগ্রি প্রোগ্রাম পরিচালনা করি।
                </p>
                <div class="hero-buttons">
                    <a href="#academics" class="btn btn-primary">
                        <i class="fas fa-graduation-cap"></i> <span data-i18n="home.hero.btn1">প্রোগ্রামসমূহ দেখুন</span>
                    </a>
                    <a href="pages/contact.php" class="btn btn-outline">
                        <i class="fas fa-map-marker-alt"></i> <span data-i18n="home.hero.btn2">আমাদের পরিদর্শন করুন</span>
                    </a>
                </div>
                <div class="hero-scroll">
                    <i class="fas fa-chevron-down"></i> <span data-i18n="home.hero.scroll">নিচে স্ক্রল করুন</span>
                </div>
            </div>
        </div>
    </header>

    <!-- ══════════════════ ABOUT ══════════════════ -->
    <section id="about" class="section-padding">
        <div class="container">
            <div class="about-grid reveal">
                <div class="about-img-wrap">
                    <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800&q=80" alt="PMDC College Library">
                    <div class="about-img-badge">
                        <div class="aib-val">1994</div>
                        <div class="aib-lbl">Est.</div>
                    </div>
                </div>
                <div class="about-text">
                    <div class="section-kicker" data-i18n="home.about.kicker">আমাদের কলেজ সম্পর্কে</div>
                    <h2 data-i18n="home.about.h2" data-i18n-html="true">ফুলপুরে নারী শিক্ষার<br>একটি ঐতিহ্য</h2>
                    <p class="lead" data-i18n="home.about.p1">
                        ফুলপুর মহিলা ডিগ্রি কলেজ ১৯৯৪ সালে সকল রাজনৈতিক দলের মানুষের সম্মিলিত প্রচেষ্টায় প্রতিষ্ঠিত হয়, যার লক্ষ্য ছিল ফুলপুরের নারীদের পুরুষের সমকক্ষে উচ্চশিক্ষার সুযোগ দেওয়া।
                    </p>
                    <p class="lead" data-i18n="home.about.p2">
                        ডিগ্রি প্রোগ্রাম (বিএ, বিএসএস, বিএসসি) ২০০৩-২০০৪ শিক্ষাবর্ষ থেকে শুরু হয় এবং এইচএসসি, ব্যবসায় ব্যবস্থাপনা ও প্রযুক্তি (বিএমটি) সহ ২০০৪-২০০৫ শিক্ষাবর্ষ থেকে চালু হয়। কলেজে অভিজ্ঞ শিক্ষকমণ্ডলী, সুশৃঙ্খল প্রশাসন, শক্তিশালী নিরাপত্তা, বড় কম্পিউটার ল্যাব, পাঠাগার এবং সিসিটিভি নজরদারি রয়েছে।
                    </p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check-circle"></i> <span data-i18n="home.about.feat1">ফুলপুর, ময়মনসিংহে শুধুমাত্র মহিলাদের ক্যাম্পাস</span></li>
                        <li><i class="fas fa-check-circle"></i> <span data-i18n="home.about.feat2">এইচএসসি এবং ডিগ্রি প্রোগ্রাম প্রদান</span></li>
                        <li><i class="fas fa-check-circle"></i> <span data-i18n="home.about.feat3">অভিজ্ঞ ও প্রশিক্ষিত শিক্ষকমণ্ডলী</span></li>
                        <li><i class="fas fa-check-circle"></i> <span data-i18n="home.about.feat4">বড় কম্পিউটার ল্যাব, পাঠাগার ও সিসিটিভি</span></li>
                        <li><i class="fas fa-check-circle"></i> <span data-i18n="home.about.feat5">সুশৃঙ্খল ও নিরাপদ শিক্ষা পরিবেশ</span></li>
                    </ul>
                    <a href="pages/about.php" class="btn btn-ghost">
                        <span data-i18n="home.about.btn">আমাদের ইতিহাস পড়ুন</span> <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════ WHY CHOOSE PMDC ══════════════════ -->
    <section class="section-padding section-alt">
        <div class="container">
            <div class="section-head reveal">
                <div class="section-kicker" data-i18n="home.why.kicker">কেন পিএমডিসি</div>
                <h2 data-i18n="home.why.h2">নারীর সাফল্যের জন্য নির্মিত</h2>
                <p data-i18n="home.why.sub">আমরা যা করি তার সবকিছু একাডেমিক উৎকর্ষতা, নিরাপত্তা এবং প্রতিটি শিক্ষার্থীর ক্ষমতায়নকে কেন্দ্র করে।</p>
            </div>
            <div class="why-grid">
                <div class="why-card reveal">
                    <div class="why-icon blue"><i class="fas fa-award"></i></div>
                    <h3 data-i18n="home.why.c1.h">বোর্ড অনুমোদিত প্রোগ্রাম</h3>
                    <p data-i18n="home.why.c1.p">সমস্ত প্রোগ্রাম বাংলাদেশ শিক্ষা বোর্ডের অধীনে স্বীকৃত, যা আপনার যোগ্যতাকে জাতীয়ভাবে বৈধ ও সম্মানিত করে।</p>
                </div>
                <div class="why-card reveal">
                    <div class="why-icon gold"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h3 data-i18n="home.why.c2.h">যোগ্য শিক্ষকমণ্ডলী</h3>
                    <p data-i18n="home.why.c2.p">আমাদের শিক্ষকমণ্ডলী বছরের পর বছরের অভিজ্ঞতা ও নিষ্ঠা নিয়ে প্রতিটি শিক্ষার্থীকে ব্যক্তিগত মনোযোগ দেন।</p>
                </div>
                <div class="why-card reveal">
                    <div class="why-icon green"><i class="fas fa-shield-alt"></i></div>
                    <h3 data-i18n="home.why.c3.h">নিরাপদ ক্যাম্পাস</h3>
                    <p data-i18n="home.why.c3.p">একটি শুধুমাত্র মহিলাদের ক্যাম্পাস পরিবেশ যা নিরাপত্তা, স্বস্তি এবং বিঘ্নমুক্ত শিক্ষার অভিজ্ঞতাকে অগ্রাধিকার দেয়।</p>
                </div>
                <div class="why-card reveal">
                    <div class="why-icon purple"><i class="fas fa-laptop"></i></div>
                    <h3 data-i18n="home.why.c4.h">আধুনিক সুবিধাসমূহ</h3>
                    <p data-i18n="home.why.c4.p">সুসজ্জিত বিজ্ঞান ল্যাব, তথ্য প্রযুক্তি অবকাঠামো এবং আধুনিক শিক্ষার চাহিদা পূরণে সমৃদ্ধ পাঠাগার।</p>
                </div>
                <div class="why-card reveal">
                    <div class="why-icon red"><i class="fas fa-hand-holding-heart"></i></div>
                    <h3 data-i18n="home.why.c5.h">বৃত্তি কার্যক্রম</h3>
                    <p data-i18n="home.why.c5.p">মেধা ও প্রয়োজন ভিত্তিক বৃত্তি প্রদান করা হয় যাতে মেধাবী শিক্ষার্থীরা আর্থিক বাধা ছাড়াই শিক্ষা চালিয়ে যেতে পারে।</p>
                </div>
                <div class="why-card reveal">
                    <div class="why-icon teal"><i class="fas fa-users"></i></div>
                    <h3 data-i18n="home.why.c6.h">শক্তিশালী সম্প্রদায়</h3>
                    <p data-i18n="home.why.c6.p">একটি সক্রিয় প্রাক্তন শিক্ষার্থী নেটওয়ার্ক এবং পারস্পরিক সহায়তার সংস্কৃতি যা স্নাতকের পরেও অব্যাহত থাকে।</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════ ACADEMICS ══════════════════ -->
    <section id="academics" class="section-padding">
        <div class="container">
            <div class="section-head reveal">
                <div class="section-kicker" data-i18n="home.hsc.kicker">এইচএসসি ও ডিগ্রি প্রোগ্রাম</div>
                <h2 data-i18n="home.hsc.h2">বিভাগসমূহ</h2>
                <p data-i18n="home.hsc.sub">একাদশ-দ্বাদশ শ্রেণির জন্য আপনার একাডেমিক বিভাগ বেছে নিন, অথবা কলেজের ডিগ্রি প্রোগ্রামগুলো অন্বেষণ করুন।</p>
            </div>
            <div class="programs-grid">

                <!-- Science -->
                <article class="program-card reveal">
                    <div class="program-img">
                        <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=600&q=80" alt="Science Group">
                        <div class="program-img-overlay"></div>
                        <span class="program-img-tag tag-sci"><i class="fas fa-flask"></i> <span data-i18n="home.sci.h3">বিজ্ঞান বিভাগ</span></span>
                    </div>
                    <div class="program-content">
                        <h3 data-i18n="home.sci.h3">বিজ্ঞান বিভাগ</h3>
                        <p data-i18n="home.sci.p">পদার্থ, রসায়ন, জীববিজ্ঞান ও উচ্চতর গণিত — পরবর্তী প্রজন্মের বিজ্ঞানী, ডাক্তার ও প্রকৌশলী গড়ে তোলে। বিষয় কোড: 174–179, 265–266.</p>
                        <a href="pages/academics.php#groups" class="read-more"><span data-i18n="home.viewsubjects">বিষয়সমূহ দেখুন</span> <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <!-- Commerce -->
                <article class="program-card reveal">
                    <div class="program-img">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600&q=80" alt="Commerce Group">
                        <div class="program-img-overlay"></div>
                        <span class="program-img-tag tag-com"><i class="fas fa-briefcase"></i> <span data-i18n="home.com.h3">ব্যবসায় শিক্ষা</span></span>
                    </div>
                    <div class="program-content">
                        <h3 data-i18n="home.com.h3">ব্যবসায় শিক্ষা বিভাগ</h3>
                        <p data-i18n="home.com.p">হিসাববিজ্ঞান, অর্থ ও ব্যাংকিং, ব্যবসায় সংগঠন ও ব্যবস্থাপনা — আগামীর ব্যবসায়িক নেতৃত্ব গড়ে তোলে। বিষয় কোড: 253–254, 277–278, 286–293.</p>
                        <a href="pages/academics.php#groups" class="read-more"><span data-i18n="home.viewsubjects">বিষয়সমূহ দেখুন</span> <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <!-- Humanities -->
                <article class="program-card reveal">
                    <div class="program-img">
                        <img src="https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=600&q=80" alt="Humanities Group">
                        <div class="program-img-overlay"></div>
                        <span class="program-img-tag tag-hum"><i class="fas fa-book"></i> <span data-i18n="home.hum.h3">মানবিক বিভাগ</span></span>
                    </div>
                    <div class="program-content">
                        <h3 data-i18n="home.hum.h3">মানবিক বিভাগ</h3>
                        <p data-i18n="home.hum.p">পৌরনীতি, সমাজবিজ্ঞান, অর্থনীতি, ইতিহাস ও ভূগোল — চিন্তাশীল নাগরিক ও সহানুভূতিশীল সামাজিক চিন্তাবিদ গড়ে তোলে। বিষয় কোড: 109–118, 269–305.</p>
                        <a href="pages/academics.php#groups" class="read-more"><span data-i18n="home.viewsubjects">বিষয়সমূহ দেখুন</span> <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <!-- Compulsory -->
                <article class="program-card reveal">
                    <div class="program-img">
                        <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&q=80" alt="Compulsory Subjects">
                        <div class="program-img-overlay"></div>
                        <span class="program-img-tag tag-comp"><i class="fas fa-book-open"></i> <span data-i18n="home.comp.h3">বাধ্যতামূলক বিষয়</span></span>
                    </div>
                    <div class="program-content">
                        <h3 data-i18n="home.comp.h3">বাধ্যতামূলক বিষয়</h3>
                        <p data-i18n="home.comp.p">সব শিক্ষার্থী তাদের বিভাগ নির্বিশেষে বাংলা ১ ও ২য় পত্র (১০১/১০২), ইংরেজি ১ ও ২য় পত্র (১০৭/১০৮) ও তথ্যপ্রযুক্তি (২৭৫) পড়েন।</p>
                        <a href="pages/academics.php#groups" class="read-more"><span data-i18n="home.viewsubjects">বিষয়সমূহ দেখুন</span> <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <!-- ══════════════════ DEGREE PROGRAMS ══════════════════ -->
    <section class="section-padding section-alt" id="degree">
        <div class="container">
            <div class="section-head reveal">
                <div class="section-kicker" data-i18n="home.degree.kicker">ডিগ্রি প্রোগ্রামসমূহ</div>
                <h2 data-i18n="home.degree.h2">স্নাতক ডিগ্রি (ডিগ্রি কোর্স)</h2>
                <p data-i18n="home.degree.sub">বাংলাদেশ জাতীয় বিশ্ববিদ্যালয়ের অধীনে — ২০০৩-২০০৪ সাল থেকে ৩ বছরের ডিগ্রি প্রোগ্রাম।</p>
            </div>
            <div class="programs-grid">

                <!-- BA -->
                <article class="program-card reveal">
                    <div class="program-img">
                        <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=600&q=80" alt="Bachelor of Arts">
                        <div class="program-img-overlay"></div>
                        <span class="program-img-tag" style="background:rgba(124,58,237,.85);"><i class="fas fa-book"></i> <span data-i18n="home.ba.h3">কলা বিভাগ (বিএ)</span></span>
                    </div>
                    <div class="program-content">
                        <h3 data-i18n="home.ba.h3">কলা বিভাগ (বিএ)</h3>
                        <p data-i18n="home.ba.p">ইতিহাস, দর্শন, রাষ্ট্রবিজ্ঞান ও ইসলামিক স্টাডিজ — ৩ বছরের উদার কলা প্রোগ্রাম।</p>
                        <a href="pages/degree-program.php" class="read-more"><span data-i18n="home.viewprog">প্রোগ্রাম দেখুন</span> <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <!-- BSS -->
                <article class="program-card reveal">
                    <div class="program-img">
                        <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=600&q=80" alt="Bachelor of Social Science">
                        <div class="program-img-overlay"></div>
                        <span class="program-img-tag" style="background:rgba(37,99,235,.85);"><i class="fas fa-users"></i> <span data-i18n="home.bss.h3">সমাজবিজ্ঞান বিভাগ (বিএসএস)</span></span>
                    </div>
                    <div class="program-content">
                        <h3 data-i18n="home.bss.h3">সমাজবিজ্ঞান বিভাগ (বিএসএস)</h3>
                        <p data-i18n="home.bss.p">অর্থনীতি, সমাজকল্যাণ, রাষ্ট্রবিজ্ঞান ও ইসলামিক স্টাডিজ — সামাজিকভাবে সচেতন নেতৃত্ব গড়ে তোলে।</p>
                        <a href="pages/degree-program.php" class="read-more"><span data-i18n="home.viewprog">প্রোগ্রাম দেখুন</span> <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <!-- BSc -->
                <article class="program-card reveal">
                    <div class="program-img">
                        <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=600&q=80" alt="Bachelor of Science">
                        <div class="program-img-overlay"></div>
                        <span class="program-img-tag" style="background:rgba(5,150,105,.85);"><i class="fas fa-flask"></i> <span data-i18n="home.bsc.h3">বিজ্ঞান বিভাগ (বিএসসি)</span></span>
                    </div>
                    <div class="program-content">
                        <h3 data-i18n="home.bsc.h3">বিজ্ঞান বিভাগ (বিএসসি)</h3>
                        <p data-i18n="home.bsc.p">উদ্ভিদবিজ্ঞান, প্রাণিবিজ্ঞান ও রসায়ন — একটি কঠোর বিজ্ঞান প্রোগ্রাম।</p>
                        <a href="pages/degree-program.php" class="read-more"><span data-i18n="home.viewprog">প্রোগ্রাম দেখুন</span> <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <!-- BMT -->
                <article class="program-card reveal">
                    <div class="program-img">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600&q=80" alt="Business Management & Technology">
                        <div class="program-img-overlay"></div>
                        <span class="program-img-tag" style="background:rgba(217,119,6,.85);"><i class="fas fa-briefcase"></i> <span data-i18n="home.bmt.h3">ব্যবসায় ব্যবস্থাপনা ও প্রযুক্তি (বিএমটি)</span></span>
                    </div>
                    <div class="program-content">
                        <h3 data-i18n="home.bmt.h3">ব্যবসায় ব্যবস্থাপনা ও প্রযুক্তি (বিএমটি)</h3>
                        <p data-i18n="home.bmt.p">হিসাববিজ্ঞান, বিপণন, অর্থনীতি ও ডিজিটাল প্রযুক্তি — ব্যবসা ও প্রযুক্তির সমন্বয়ে আধুনিক প্রোগ্রাম।</p>
                        <a href="pages/degree-program.php" class="read-more"><span data-i18n="home.viewprog">প্রোগ্রাম দেখুন</span> <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

            </div>
            <div class="degree-footer reveal">
                <span><i class="fas fa-university"></i> <span data-i18n="home.degree.nu">বাংলাদেশ জাতীয় বিশ্ববিদ্যালয় কর্তৃক পরিচালিত</span></span>
                <a href="pages/degree-program.php" class="btn btn-outline"><span data-i18n="home.degree.btn">সম্পূর্ণ বিবরণ দেখুন</span> <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- ══════════════════ NEWS & EVENTS ══════════════════ -->

    <section id="news" class="section-padding">
        <div class="container">
            <div class="section-head reveal">
                <div class="section-kicker" data-i18n="home.news.kicker">সর্বশেষ আপডেট</div>
                <h2 data-i18n="home.news.h2">সংবাদ ও ইভেন্ট</h2>
                <p data-i18n="home.news.sub">কলেজের সংবাদ, পরীক্ষার সময়সূচি এবং আসন্ন ইভেন্ট সম্পর্কে আপডেট থাকুন।</p>
            </div>
            <div class="news-grid">

                <!-- News List -->
                <div class="news-list reveal">

                    <div class="news-item">
                        <div class="news-date-box">
                            <span class="news-day">15</span>
                            <span class="news-month">Oct</span>
                        </div>
                        <div class="news-details">
                            <span class="news-tag tag-results"><i class="fas fa-trophy"></i> Results</span>
                            <h4>HSC Board Exam Results 2025 — 92% Pass Rate</h4>
                            <p>Phulpur Mohila Degree College continues to celebrate strong HSC outcomes, with students progressing through the Half-Yearly, Year-Change, Pre-Test, and Test examination system.</p>
                            <a href="pages/results.php" class="read-more"><span data-i18n="home.news.viewresults">ফলাফল দেখুন</span> <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="news-item">
                        <div class="news-date-box">
                            <span class="news-day">22</span>
                            <span class="news-month">Sep</span>
                        </div>
                        <div class="news-details">
                            <span class="news-tag tag-exam"><i class="fas fa-calendar-alt"></i> Examination</span>
                            <h4>HSC Test Examination 2026 — Schedule Released</h4>
                            <p>The Test Examination for HSC 2nd Year students is one of the college's key academic checkpoints. Admit cards must be collected 10 days before the exam.</p>
                            <a href="pages/announcements.php" class="read-more"><span data-i18n="home.news.readmore">আরও পড়ুন</span> <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="news-item">
                        <div class="news-date-box">
                            <span class="news-day">05</span>
                            <span class="news-month">Sep</span>
                        </div>
                        <div class="news-details">
                            <span class="news-tag tag-admission"><i class="fas fa-user-plus"></i> Admission</span>
                            <h4>Class XI Admission 2025–26 — Applications Open</h4>
                            <p>Admissions are open for HSC 1st Year students in Science, Humanities, and Business Studies groups. Degree programme information can be obtained from the college office.</p>
                            <a href="pages/announcements.php" class="read-more"><span data-i18n="home.news.readmore">আরও পড়ুন</span> <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                </div>

                <!-- Events Sidebar -->
                <aside class="events-sidebar reveal">
                    <h3><i class="fas fa-calendar-star"></i> <span data-i18n="home.events.h3">আসন্ন অনুষ্ঠানসমূহ</span></h3>

                    <div class="event-card">
                        <h4>অভিভাবক সমাবেশ (Parents' Meeting)</h4>
                        <div class="event-meta"><i class="fas fa-clock"></i> 10:00 AM – 1:00 PM</div>
                        <p>Parents and guardians are invited to discuss academic progress, attendance, and discipline with class teachers.</p>
                    </div>

                    <div class="event-card">
                        <h4>সাংস্কৃতিক অনুষ্ঠান (Cultural Program)</h4>
                        <div class="event-meta"><i class="fas fa-clock"></i> 4:00 PM onwards</div>
                        <p>Annual cultural program showcasing the talent of our Class XI and XII students.</p>
                    </div>

                    <div class="event-card">
                        <h4>HSC Test Examination</h4>
                        <div class="event-meta"><i class="fas fa-calendar"></i> Scheduled by college notice</div>
                        <p>HSC 2nd Year students must pass the Test Examination to be eligible for HSC form fill-up.</p>
                    </div>
                </aside>

            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
