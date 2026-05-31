<?php
$page       = 'contact';
$page_title = 'Contact Us | Phulpur Mohila Degree College';
$page_css   = 'contact.css';
$base_path  = '../';
include '../includes/header.php';
?>

    <!-- ══════════════════ PAGE HEADER ══════════════════ -->
    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-kicker reveal">Get in Touch</div>
            <h1 class="reveal">Contact Us</h1>
            <p class="reveal">We're here to help. Reach out to us for admission queries, academic information, or general enquiries about Phulpur Mohila Degree College.</p>
        </div>
    </section>

    <!-- ══════════════════ MAIN SECTION ══════════════════ -->
    <section class="section-padding">
        <div class="container">
            <div class="contact-layout">

                <!-- ════ LEFT: Info + Directory ════ -->
                <div class="contact-left">

                    <!-- Address Card -->
                    <div class="info-card reveal">
                        <h3>Visit Our College</h3>
                        <p>Our college office is open Sunday through Thursday during office hours. Walk-in visits are welcome.</p>

                        <div class="info-item">
                            <div class="ii-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="ii-body">
                                <div class="ii-label">Address</div>
                                <div class="ii-val">Phulpur, Mymensingh District<br>Bangladesh</div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="ii-icon"><i class="fas fa-phone"></i></div>
                            <div class="ii-body">
                                <div class="ii-label">Phone</div>
                                <div class="ii-val"><a href="tel:01712-227983">01712-227983</a></div>
                                <div class="ii-note">Principal: Rowshan Ara Begum</div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="ii-icon"><i class="fas fa-envelope"></i></div>
                            <div class="ii-body">
                                <div class="ii-label">General Email</div>
                                <div class="ii-val"><a href="mailto:pmdc@edu.bd">pmdc@edu.bd</a></div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="ii-icon"><i class="fas fa-file-alt"></i></div>
                            <div class="ii-body">
                                <div class="ii-label">Examination Cell</div>
                                <div class="ii-val"><a href="mailto:exam@pmdc.edu.bd">exam@pmdc.edu.bd</a></div>
                            </div>
                        </div>
                    </div>

                    <!-- Social -->
                    <div class="social-card reveal">
                        <div class="sc-label">Follow Us</div>
                        <div class="sc-links">
                            <a href="#" class="sc-btn sc-fb" aria-label="Facebook"><i class="fab fa-facebook-f"></i> Facebook</a>
                            <a href="#" class="sc-btn sc-yt" aria-label="YouTube"><i class="fab fa-youtube"></i> YouTube</a>
                        </div>
                    </div>

                </div>

                <!-- ════ RIGHT: Contact Form ════ -->
                <div class="contact-form-wrap reveal">
                    <div class="form-card">
                        <div class="fc-head">
                            <h2>Send a Message</h2>
                            <p>Fill in the form below and our office team will respond within 1–2 working days.</p>
                        </div>

                        <div id="successMsg" class="form-success" style="display:none;">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Message sent!</strong>
                                <span>Thank you. We'll get back to you within 1–2 working days.</span>
                            </div>
                        </div>

                        <form id="contactForm" onsubmit="handleContact(event)">
                            <div class="cf-row">
                                <div class="form-group">
                                    <label for="cf_name">Full Name <span class="req">*</span></label>
                                    <input type="text" id="cf_name" placeholder="Your full name" required>
                                </div>
                                <div class="form-group">
                                    <label for="cf_email">Email Address <span class="req">*</span></label>
                                    <input type="email" id="cf_email" placeholder="you@example.com" required>
                                </div>
                            </div>
                            <div class="cf-row">
                                <div class="form-group">
                                    <label for="cf_phone">Phone Number</label>
                                    <input type="tel" id="cf_phone" placeholder="+880 1XXX-XXXXXX">
                                </div>
                                <div class="form-group">
                                    <label for="cf_subject">Subject <span class="req">*</span></label>
                                    <select id="cf_subject" required>
                                        <option value="">Select a topic…</option>
                                        <option value="admission">Admission Enquiry</option>
                                        <option value="results">Results &amp; Examination</option>
                                        <option value="scholarship">Scholarship</option>
                                        <option value="academic">Academic Information</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cf_message">Message <span class="req">*</span></label>
                                <textarea id="cf_message" rows="5" placeholder="Write your message here…" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-submit" id="submitBtn">
                                <span class="btn-text"><i class="fas fa-paper-plane"></i> Send Message</span>
                                <span class="btn-spin" style="display:none;"><i class="fas fa-spinner fa-spin"></i> Sending…</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ══════════════════ MAP ══════════════════ -->
    <div class="map-wrap">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3641.3!2d90.5!3d24.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjTCsDU0JzAwLjAiTiA5MMKwMzAnMDAuMCJF!5e0!3m2!1sen!2sbd!4v1716780000000!5m2!1sen!2sbd"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Phulpur, Mymensingh, Bangladesh">
        </iframe>
    </div>

    <script>
    function handleContact(e) {
        e.preventDefault();
        const btn  = document.getElementById('submitBtn');
        btn.querySelector('.btn-text').style.display = 'none';
        btn.querySelector('.btn-spin').style.display = 'inline-flex';
        btn.disabled = true;

        setTimeout(() => {
            document.getElementById('contactForm').style.display = 'none';
            document.getElementById('successMsg').style.display  = 'flex';
        }, 1400);
    }
    </script>

<?php include '../includes/footer.php'; ?>