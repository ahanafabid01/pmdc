/**
 * javascript/registration.js
 * Multi-step form handler for HSC/Degree public registration.
 */
document.addEventListener('DOMContentLoaded', () => {
    const formType = document.body.dataset.formType || 'hsc';
    const steps = document.querySelectorAll('.reg-step');
    const nodes = document.querySelectorAll('.reg-step-node');
    let currentStep = 0;

    // Navigation
    document.querySelectorAll('[data-action="next"]').forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                // Optionally validate inputs here
                showStep(currentStep + 1);
            }
        });
    });

    document.querySelectorAll('[data-action="back"]').forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentStep > 0) showStep(currentStep - 1);
        });
    });

    document.querySelectorAll('.reg-summary-edit').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const targetStep = parseInt(e.target.dataset.gotoStep) - 1;
            if (!isNaN(targetStep) && targetStep >= 0) showStep(targetStep);
        });
    });

    // Summary Toggle
    const summaryToggle = document.querySelector('.reg-summary-toggle');
    const summaryBody = document.querySelector('.reg-summary-body');
    if (summaryToggle && summaryBody) {
        summaryToggle.addEventListener('click', () => {
            summaryBody.classList.toggle('open');
            const icon = summaryToggle.querySelector('.fa-chevron-down, .fa-chevron-up');
            if (icon) {
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            }
        });
    }

    function showStep(index) {
        steps[currentStep].classList.remove('active');
        nodes[currentStep].classList.remove('active');
        currentStep = index;
        steps[currentStep].classList.add('active');
        nodes[currentStep].classList.add('active');
        
        // Update summary on final step
        if (currentStep === steps.length - 1) {
            updateSummary();
        }

        // Auto scroll to top of form
        const formWrap = document.getElementById('regFormWrap');
        if (formWrap) {
            // Add a small offset to account for any fixed headers if needed, but smooth scroll is usually fine
            formWrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Image previews
    function setupUpload(inputId, previewId, nameId) {
        const input = document.getElementById(inputId);
        if (!input) return;
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                document.getElementById(nameId).textContent = file.name;
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.getElementById(previewId);
                    if (file.type.startsWith('image/')) {
                        img.src = e.target.result;
                        img.style.display = 'block';
                        img.previousElementSibling.style.display = 'none'; // hide placeholder
                    } else {
                        // For PDFs, hide image tag and show PDF icon in placeholder
                        img.style.display = 'none';
                        const placeholder = img.previousElementSibling;
                        placeholder.style.display = 'flex';
                        const icon = placeholder.querySelector('i');
                        if (icon) {
                            icon.className = 'fas fa-file-pdf';
                            icon.style.color = '#dc2626';
                        }
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    setupUpload('upload_photo', 'photo_preview', 'photo_filename');
    setupUpload('upload_cert', 'cert_preview', 'cert_filename');
    setupUpload('upload_birth', 'birth_preview', 'birth_filename');

    // Remove buttons
    document.querySelectorAll('.reg-upload-remove').forEach(btn => {
        btn.addEventListener('click', function() {
            const zone = this.closest('.reg-upload-zone');
            const input = zone.querySelector('input[type="file"]');
            const img = zone.querySelector('img');
            const name = zone.querySelector('.reg-upload-filename');
            const placeholder = zone.querySelector('.reg-photo-placeholder, .reg-doc-placeholder');
            
            input.value = '';
            img.src = '';
            img.style.display = 'none';
            name.textContent = '';
            if (placeholder) placeholder.style.display = 'flex';
        });
    });

    // Address Sync Logic
    const sameAddrCb = document.getElementById('same_address');
    const presentAddr = document.getElementById('present_address');
    const permanentAddr = document.getElementById('permanent_address');

    if (sameAddrCb && presentAddr && permanentAddr) {
        const syncAddress = () => {
            if (sameAddrCb.checked) {
                permanentAddr.value = presentAddr.value;
                permanentAddr.readOnly = true;
                permanentAddr.style.backgroundColor = '#f1f5f9'; // visually locked
                // trigger change so live summary updates
                permanentAddr.dispatchEvent(new Event('input', { bubbles: true }));
            } else {
                permanentAddr.readOnly = false;
                permanentAddr.style.backgroundColor = '';
            }
        };

        sameAddrCb.addEventListener('change', syncAddress);
        presentAddr.addEventListener('input', () => {
            if (sameAddrCb.checked) syncAddress();
        });
    }

    function updateSummary() {
        const tbody = document.getElementById('summaryBody');
        if (!tbody) return;
        
        let summaryHtml = '<table style="width:100%; border-collapse:collapse; font-size: 0.85rem;">';
        const addRow = (label, val) => {
            if (val) summaryHtml += `<tr><td style="padding:4px 0; color:#64748b;">${label}</td><td style="padding:4px 0; font-weight:600; text-align:right;">${val}</td></tr>`;
        };

        addRow('Name (EN)', document.getElementById('full_name_en')?.value);
        addRow('Date of Birth', document.getElementById('dob')?.value);
        addRow('Religion', document.getElementById('religion')?.value);
        addRow('Blood Group', document.getElementById('blood_group')?.value);
        addRow('National ID', document.getElementById('nid_number')?.value);
        addRow('Birth Cert No.', document.getElementById('birth_cert_num')?.value);
        addRow('Email', document.getElementById('email')?.value);
        addRow('Guardian Phone', document.getElementById('guardian_phone')?.value);
        addRow('Student Phone', document.getElementById('student_phone')?.value);
        addRow('Father Name', document.getElementById('father_name')?.value);
        addRow('Mother Name', document.getElementById('mother_name')?.value);
        addRow('Present Address', document.getElementById('present_address')?.value);
        
        if (formType === 'hsc') {
            addRow('SSC Roll', document.getElementById('ssc_roll')?.value);
            addRow('SSC Board', document.getElementById('ssc_board')?.value);
            addRow('SSC GPA', document.getElementById('ssc_gpa')?.value);
            addRow('Program Preference', document.getElementById('desired_group')?.value);
        } else {
            addRow('HSC Roll', document.getElementById('hsc_roll')?.value);
            addRow('HSC Board', document.getElementById('hsc_board')?.value);
            addRow('HSC GPA', document.getElementById('hsc_gpa')?.value);
            addRow('Program Preference', document.getElementById('desired_program')?.value);
        }

        const pm = document.querySelector('input[name="payment_method"]:checked')?.value;
        addRow('Payment Method', pm);
        addRow('Txn ID', document.getElementById('transaction_id')?.value);
        
        summaryHtml += '</table>';
        tbody.innerHTML = summaryHtml;
    }

    // Auto-update summary live
    const formWrap = document.getElementById('regFormWrap');
    if (formWrap) {
        formWrap.addEventListener('input', updateSummary);
        formWrap.addEventListener('change', updateSummary);
    }

    // Form Submission
    const submitBtn = document.getElementById('btnSubmit');
    if (submitBtn) {
        submitBtn.addEventListener('click', () => {
            const overlay = document.getElementById('regConfirmOverlay');
            if (overlay) {
                overlay.style.display = '';
                overlay.classList.add('active');
            }
        });
    }

    const cancelBtn = document.getElementById('confirmCancel');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            const overlay = document.getElementById('regConfirmOverlay');
            if (overlay) overlay.classList.remove('active');
        });
    }

    const confirmSubmitBtn = document.getElementById('confirmSubmit');
    if (confirmSubmitBtn) {
        confirmSubmitBtn.addEventListener('click', async () => {
            const overlay = document.getElementById('regConfirmOverlay');
            if (overlay) overlay.classList.remove('active');
            
            const btn = document.getElementById('btnSubmit');
            const spinner = document.getElementById('submitSpinner');
            btn.disabled = true;
            spinner.style.display = 'inline-block';

            const formData = new FormData();
            formData.append('type', formType);
            
            // Personal Data
            const personal = {};
            ['full_name_en', 'full_name_bn', 'dob', 'religion', 'blood_group', 'nid_number', 'birth_cert_num', 'father_name', 'father_nid', 'father_occupation', 'mother_name', 'mother_nid', 'mother_occupation', 'guardian_phone', 'student_phone', 'email', 'present_address', 'permanent_address'].forEach(id => {
                const el = document.getElementById(id);
                if (el) personal[id] = el.value;
            });
            formData.append('personal_data', JSON.stringify(personal));

            // Academic Data
            const academic = {};
            if (formType === 'hsc') {
                ['ssc_roll', 'ssc_reg', 'ssc_board', 'ssc_year', 'ssc_gpa', 'ssc_group', 'desired_group', 'desired_section', 'prev_institution'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) academic[id] = el.value;
                });
            } else {
                ['hsc_roll', 'hsc_reg', 'hsc_board', 'hsc_year', 'hsc_gpa', 'hsc_group', 'desired_program', 'prev_institution'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) academic[id] = el.value;
                });
            }
            formData.append('academic_data', JSON.stringify(academic));

            // Payment Data
            formData.append('payment_method', document.querySelector('input[name="payment_method"]:checked')?.value || '');
            formData.append('transaction_id', document.getElementById('transaction_id')?.value || '');
            formData.append('amount_paid', document.getElementById('amount_paid')?.value || '0');
            formData.append('payment_date', document.getElementById('payment_date')?.value || '');

            // Files
            const photoInput = document.getElementById('upload_photo');
            if (photoInput && photoInput.files[0]) formData.append('photo', photoInput.files[0]);
            
            const certInput = document.getElementById('upload_cert');
            if (certInput && certInput.files[0]) formData.append('certificate', certInput.files[0]);
            
            const birthInput = document.getElementById('upload_birth');
            if (birthInput && birthInput.files[0]) formData.append('birth_cert', birthInput.files[0]);

            try {
                const res = await fetch('../api/registration-submit.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await res.json();
                
                if (data.success) {
                    document.getElementById('regFormWrap').style.display = 'none';
                    document.getElementById('regSuccess').style.display = 'block';
                    document.getElementById('successRefNumber').textContent = data.ref_number;
                } else {
                    alert('Submission failed: ' + (data.message || 'Unknown error'));
                }
            } catch (err) {
                alert('Submission failed due to a network error.');
            } finally {
                btn.disabled = false;
                spinner.style.display = 'none';
            }
        });
    }

    // Print functionality
    const btnPrint = document.getElementById('btnPrint');
    if (btnPrint) {
        btnPrint.addEventListener('click', () => {
            window.print();
        });
    }
});
