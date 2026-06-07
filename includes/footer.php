    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-grid">

                <!-- Col 1: Brand -->
                <div class="footer-col">
                    <div class="footer-logo">
                        <div class="footer-logo-icon"><i class="fas fa-school"></i></div>
                        <span class="footer-logo-abbr">PMDC</span>
                    </div>
                    <p data-i18n="footer.desc">ফুলপুর মহিলা ডিগ্রি কলেজ — ১৯৯৪ সাল থেকে মানসম্পন্ন শিক্ষার মাধ্যমে নারীর ক্ষমতায়নে নিবেদিত।</p>
                    <div class="social-icons">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="footer-col">
                    <h3 data-i18n="footer.quicklinks">দ্রুত সংযোগ</h3>
                    <ul class="footer-links">
                        <li><a href="<?= BASE_URL ?>/" data-i18n="footer.home">হোম</a></li>
                        <li><a href="<?= BASE_URL ?>/about" data-i18n="footer.about">প্রতিষ্ঠান পরিচিতি</a></li>
                        <li><a href="<?= BASE_URL ?>/academic/class-routine" data-i18n="footer.academicslink">একাডেমিক</a></li>
                        <li><a href="<?= BASE_URL ?>/announcement" data-i18n="footer.announcementslink">বিজ্ঞপ্তি</a></li>
                        <li><a href="<?= BASE_URL ?>/results" data-i18n="footer.results">ফলাফল</a></li>
                        <li><a href="<?= BASE_URL ?>/contact" data-i18n="footer.contactlink">যোগাযোগ</a></li>
                    </ul>
                </div>

                <!-- Col 3: Academics -->
                <div class="footer-col">
                    <h3 data-i18n="footer.academics">একাডেমিক</h3>
                    <ul class="footer-links">
                        <li><a href="<?= BASE_URL ?>/academic/class-routine#groups" data-i18n="footer.science">বিজ্ঞান বিভাগ</a></li>
                        <li><a href="<?= BASE_URL ?>/academic/class-routine#groups" data-i18n="footer.commerce">ব্যবসায় শিক্ষা</a></li>
                        <li><a href="<?= BASE_URL ?>/academic/class-routine#groups" data-i18n="footer.humanities">মানবিক বিভাগ</a></li>
                        <li><a href="<?= BASE_URL ?>/academic/class-routine#groups" data-i18n="footer.compulsory">বাধ্যতামূলক বিষয়</a></li>
                        <li><a href="<?= BASE_URL ?>/results" data-i18n="footer.examresults">পরীক্ষার ফলাফল</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact -->
                <div class="footer-col">
                    <h3 data-i18n="footer.contact">যোগাযোগ করুন</h3>
                    <div class="footer-contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Phulpur, Mymensingh, Bangladesh</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+880-1712-227983</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>pmdc@edu.bd</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-clock"></i>
                        <span data-i18n="footer.hours">রবি–বৃহ: সকাল ৮:০০ – বিকাল ৪:০০</span>
                    </div>
                </div>

            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <span data-i18n="footer.copyright">ফুলপুর মহিলা ডিগ্রি কলেজ। সর্বস্বত্ব সংরক্ষিত।</span></p>
                <p>
                    <a href="#" data-i18n="footer.privacy">গোপনীয়তা নীতি</a> &nbsp;·&nbsp;
                    <a href="#" data-i18n="footer.terms">ব্যবহারের শর্ত</a> &nbsp;·&nbsp;
                    <a href="<?= BASE_URL ?>/admin/login" data-i18n="footer.staffportal">স্টাফ পোর্টাল</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Modal -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <h3 id="modalTitle">Coming Soon</h3>
            <p data-i18n="modal.desc">এই ফিচারটি বর্তমানে উন্নয়নাধীন। সহায়তার জন্য কলেজ অফিসে যোগাযোগ করুন।</p>
            <button class="modal-close" onclick="closeModal()" data-i18n="modal.close">বন্ধ করুন</button>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/javascript/main.js?v=<?= time() ?>"></script>
    <?php if(isset($page_js)): ?>
    <script src="<?= BASE_URL ?>/javascript/<?php echo $page_js; ?>?v=<?= time() ?>"></script>
    <?php endif; ?>

</body>
</html>
