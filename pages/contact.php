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
            <div class="ph-kicker reveal">
                <span class="show-en">Get in Touch</span>
                <span class="show-bn">যোগাযোগ করুন</span>
            </div>
            <h1 class="reveal">
                <span class="show-en">Contact Us</span>
                <span class="show-bn">যোগাযোগ</span>
            </h1>
            <p class="reveal">
                <span class="show-en">We're here to help. Reach out to us for admission queries, academic information, or general enquiries about Phulpur Mohila Degree College.</span>
                <span class="show-bn">আমরা সাহায্য করতে এখানে আছি। ভর্তি, একাডেমিক তথ্য বা কলেজের সাধারণ জিজ্ঞাসার জন্য আমাদের সাথে যোগাযোগ করুন।</span>
            </p>
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
                        <h3>
                            <span class="show-en">Visit Our College</span>
                            <span class="show-bn">আমাদের কলেজ পরিদর্শন করুন</span>
                        </h3>
                        <p>
                            <span class="show-en">Our college office is open Sunday through Thursday during office hours. Walk-in visits are welcome.</span>
                            <span class="show-bn">আমাদের কলেজ অফিস রবিবার থেকে বৃহস্পতিবার অফিস চলাকালীন খোলা থাকে। সরাসরি পরিদর্শন করতে পারেন।</span>
                        </p>

                        <div class="info-item">
                            <div class="ii-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="ii-body">
                                <div class="ii-label">
                                    <span class="show-en">Address</span>
                                    <span class="show-bn">ঠিকানা</span>
                                </div>
                                <div class="ii-val">
                                    <span class="show-en">Phulpur, Mymensingh District<br>Bangladesh</span>
                                    <span class="show-bn">ফুলপুর, ময়মনসিংহ জেলা<br>বাংলাদেশ</span>
                                </div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="ii-icon"><i class="fas fa-phone"></i></div>
                            <div class="ii-body">
                                <div class="ii-label">
                                    <span class="show-en">Phone</span>
                                    <span class="show-bn">ফোন</span>
                                </div>
                                <div class="ii-val"><a href="tel:01712-227983">01712-227983</a></div>
                                <div class="ii-note">
                                    <span class="show-en">Principal: Rowshan Ara Begum</span>
                                    <span class="show-bn">অধ্যক্ষ: রওশন আরা বেগম</span>
                                </div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="ii-icon"><i class="fas fa-envelope"></i></div>
                            <div class="ii-body">
                                <div class="ii-label">
                                    <span class="show-en">General Email</span>
                                    <span class="show-bn">সাধারণ ইমেইল</span>
                                </div>
                                <div class="ii-val"><a href="mailto:pmdc@edu.bd">pmdc@edu.bd</a></div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="ii-icon"><i class="fas fa-file-alt"></i></div>
                            <div class="ii-body">
                                <div class="ii-label">
                                    <span class="show-en">Examination Cell</span>
                                    <span class="show-bn">পরীক্ষা সেল</span>
                                </div>
                                <div class="ii-val"><a href="mailto:exam@pmdc.edu.bd">exam@pmdc.edu.bd</a></div>
                            </div>
                        </div>
                    </div>

                    <!-- Social -->
                    <div class="social-card reveal">
                        <div class="sc-label">
                            <span class="show-en">Follow Us</span>
                            <span class="show-bn">আমাদের অনুসরণ করুন</span>
                        </div>
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
                            <h2>
                                <span class="show-en">Send a Message</span>
                                <span class="show-bn">একটি বার্তা পাঠান</span>
                            </h2>
                            <p>
                                <span class="show-en">Fill in the form below and our office team will respond within 1–2 working days.</span>
                                <span class="show-bn">নিচের ফর্মটি পূরণ করুন এবং আমাদের অফিস টিম ১-২ কার্যদিবসের মধ্যে উত্তর দেবে।</span>
                            </p>
                        </div>

                        <div id="successMsg" class="form-success" style="display:none;">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>
                                    <span class="show-en">Message sent!</span>
                                    <span class="show-bn">বার্তা পাঠানো হয়েছে!</span>
                                </strong>
                                <span>
                                    <span class="show-en">Thank you. We'll get back to you within 1–2 working days.</span>
                                    <span class="show-bn">ধন্যবাদ। আমরা ১-২ কার্যদিবসের মধ্যে আপনার সাথে যোগাযোগ করব।</span>
                                </span>
                            </div>
                        </div>

                        <form id="contactForm" onsubmit="handleContact(event)">
                            <div class="cf-row">
                                <div class="form-group">
                                    <label for="cf_name">
                                        <span class="show-en">Full Name</span>
                                        <span class="show-bn">পুরো নাম</span>
                                        <span class="req">*</span>
                                    </label>
                                    <input type="text" id="cf_name" data-i18n-ph="cf.name.ph" required>
                                </div>
                                <div class="form-group">
                                    <label for="cf_email">
                                        <span class="show-en">Email Address</span>
                                        <span class="show-bn">ইমেইল ঠিকানা</span>
                                        <span class="req">*</span>
                                    </label>
                                    <input type="email" id="cf_email" data-i18n-ph="cf.email.ph" required>
                                </div>
                            </div>
                            <div class="cf-row">
                                <div class="form-group">
                                    <label for="cf_phone">
                                        <span class="show-en">Phone Number</span>
                                        <span class="show-bn">ফোন নম্বর</span>
                                    </label>
                                    <input type="tel" id="cf_phone" data-i18n-ph="cf.phone.ph">
                                </div>
                                <div class="form-group">
                                    <label for="cf_subject">
                                        <span class="show-en">Subject</span>
                                        <span class="show-bn">বিষয়</span>
                                        <span class="req">*</span>
                                    </label>
                                    <select id="cf_subject" required>
                                        <option value="" class="show-en">Select a topic…</option>
                                        <option value="" class="show-bn">একটি বিষয় নির্বাচন করুন…</option>
                                        
                                        <option value="admission" class="show-en">Admission Enquiry</option>
                                        <option value="admission" class="show-bn">ভর্তি জিজ্ঞাসা</option>
                                        
                                        <option value="results" class="show-en">Results &amp; Examination</option>
                                        <option value="results" class="show-bn">ফলাফল ও পরীক্ষা</option>
                                        
                                        <option value="scholarship" class="show-en">Scholarship</option>
                                        <option value="scholarship" class="show-bn">বৃত্তি</option>
                                        
                                        <option value="academic" class="show-en">Academic Information</option>
                                        <option value="academic" class="show-bn">একাডেমিক তথ্য</option>
                                        
                                        <option value="other" class="show-en">Other</option>
                                        <option value="other" class="show-bn">অন্যান্য</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cf_message">
                                    <span class="show-en">Message</span>
                                    <span class="show-bn">বার্তা</span>
                                    <span class="req">*</span>
                                </label>
                                <textarea id="cf_message" rows="5" data-i18n-ph="cf.msg.ph" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-submit" id="submitBtn">
                                <span class="btn-text">
                                    <i class="fas fa-paper-plane"></i> 
                                    <span class="show-en">Send Message</span>
                                    <span class="show-bn">বার্তা পাঠান</span>
                                </span>
                                <span class="btn-spin" style="display:none;">
                                    <i class="fas fa-spinner fa-spin"></i> 
                                    <span class="show-en">Sending…</span>
                                    <span class="show-bn">পাঠানো হচ্ছে…</span>
                                </span>
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
    async function handleContact(e) {
        e.preventDefault();
        const btn  = document.getElementById('submitBtn');
        btn.querySelector('.btn-text').style.display = 'none';
        btn.querySelector('.btn-spin').style.display = 'inline-flex';
        btn.disabled = true;

        const data = {
            name: document.getElementById('cf_name').value.trim(),
            email: document.getElementById('cf_email').value.trim(),
            phone: document.getElementById('cf_phone').value.trim(),
            subject: document.getElementById('cf_subject').value,
            message: document.getElementById('cf_message').value.trim()
        };

        try {
            const res = await fetch('<?= BASE_URL ?>/api/contact-submit.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await res.json();
            
            if (result.ok) {
                document.getElementById('contactForm').style.display = 'none';
                document.getElementById('successMsg').style.display  = 'flex';
            } else {
                alert(result.msg || 'Error submitting message');
                btn.querySelector('.btn-text').style.display = 'inline-flex';
                btn.querySelector('.btn-spin').style.display = 'none';
                btn.disabled = false;
            }
        } catch(err) {
            alert('Network error. Please try again.');
            btn.querySelector('.btn-text').style.display = 'inline-flex';
            btn.querySelector('.btn-spin').style.display = 'none';
            btn.disabled = false;
        }
    }
    </script>

<?php include '../includes/footer.php'; ?>