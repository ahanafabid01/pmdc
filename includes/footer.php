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
                    <p>Phulpur Mohila Degree College — empowering women through quality education since 1980. Affiliated with the Bangladesh Education Board.</p>
                    <div class="social-icons">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>index.php">Home</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/about.php">About Us</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/academics.php">Academics</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/announcements.php">Announcements</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/results.php">Results</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/contact.php">Contact</a></li>
                    </ul>
                </div>

                <!-- Col 3: Academics -->
                <div class="footer-col">
                    <h3>Academics</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/academics.php#groups">Science Group</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/academics.php#groups">Commerce Group</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/academics.php#groups">Humanities Group</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/academics.php#groups">Compulsory Subjects</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/results.php">Exam Results</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact -->
                <div class="footer-col">
                    <h3>Contact Us</h3>
                    <div class="footer-contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Phulpur, Mymensingh, Bangladesh</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+880-1700-000000</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>pmdc@edu.bd</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-clock"></i>
                        <span>Sun–Thu: 8:00 AM – 4:00 PM</span>
                    </div>
                </div>

            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Phulpur Mohila Degree College. All Rights Reserved.</p>
                <p>
                    <a href="#">Privacy Policy</a> &nbsp;·&nbsp;
                    <a href="#">Terms of Use</a> &nbsp;·&nbsp;
                    <a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/portal/portal-login.php">Staff Portal</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Modal -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <h3 id="modalTitle">Coming Soon</h3>
            <p>This feature is currently under development. Please contact the college office for assistance.</p>
            <button class="modal-close" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script src="<?php echo isset($base_path) ? $base_path : ''; ?>javascript/main.js"></script>
    <?php if(isset($page_js)): ?>
    <script src="<?php echo isset($base_path) ? $base_path : ''; ?>javascript/<?php echo $page_js; ?>"></script>
    <?php endif; ?>

</body>
</html>
