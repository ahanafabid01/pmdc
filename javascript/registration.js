/**
 * javascript/registration.js
 * Multi-step form handler for HSC/Degree public registration.
 */
document.addEventListener('DOMContentLoaded', () => {
    const formType = document.body.dataset.formType || 'hsc';
    const steps = document.querySelectorAll('.reg-step');
    const nodes = document.querySelectorAll('.reg-step-node');
    let currentStep = 0;

    function showToast(msg, type = 'error') {
        const toast = document.getElementById('regToast');
        if (!toast) return;
        toast.innerHTML = `<i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}"></i> ${msg}`;
        toast.className = `reg-toast show ${type}`;
        // Ensure it has basic styles to look professional if CSS is missing
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.background = type === 'error' ? '#ef4444' : '#10b981';
        toast.style.color = '#fff';
        toast.style.padding = '12px 24px';
        toast.style.borderRadius = '8px';
        toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        toast.style.zIndex = '9999';
        toast.style.fontSize = '0.95rem';
        toast.style.fontWeight = '500';
        toast.style.display = 'flex';
        toast.style.alignItems = 'center';
        toast.style.gap = '8px';
        toast.style.transition = 'all 0.3s ease';
        
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.classList.remove('show'), 300);
        }, 4000);
        toast.style.opacity = '1';
    }

    // Navigation
    document.querySelectorAll('[data-action="next"]').forEach(btn => {
        btn.addEventListener('click', () => {
            // Step 2 Validation for HSC dynamic subjects
            if (currentStep === 1 && formType === 'hsc') {
                const optCbs = document.querySelectorAll('.dyn-opt-cb');
                let selectedElectives = [];
                if (optCbs.length > 0) {
                    const checkedCbs = document.querySelectorAll('.dyn-opt-cb:checked');
                    if (checkedCbs.length !== 3) {
                        showToast("You must select exactly 3 Elective Subjects.");
                        return;
                    }
                    selectedElectives = Array.from(checkedCbs).map(cb => cb.value);
                }
                
                const fourthRadios = document.querySelectorAll('input[name="fourth_subject"]');
                let selectedFourth = null;
                if (fourthRadios.length > 0) {
                    const checkedFourth = document.querySelector('input[name="fourth_subject"]:checked');
                    if (!checkedFourth) {
                        showToast("You must select exactly 1 Optional Subject.");
                        return;
                    }
                    selectedFourth = checkedFourth.value;
                }
                
                if (selectedElectives.length > 0 && selectedFourth) {
                    if (selectedElectives.includes(selectedFourth)) {
                        showToast("Elective and Optional subjects cannot be the same!");
                        return;
                    }
                }
            }
            
            if (currentStep < steps.length - 1) {
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

    // Dynamic Optional Subjects for HSC
    const desiredGroup = document.getElementById('desired_group');
    const container = document.getElementById('dynamic_subjects_container');
    
    if (desiredGroup && container && typeof programSubjects !== 'undefined') {
        desiredGroup.addEventListener('change', () => {
            const group = desiredGroup.value;
            container.style.display = group ? 'block' : 'none';
            container.innerHTML = '';
            
            if (!group || !programSubjects[group]) return;
            
            const data = programSubjects[group];
            let html = '';
            
            // Generate exact UI matching user screenshot
            html += `
            <div class="hsc-sub-wrap" style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); border:1px solid #e2e8f0; width:100%;">
                <div style="text-align:center; margin-bottom:24px;">
                    <h3 style="color:#047857; font-weight:700; font-size:1.35rem; margin-bottom:8px;">Student Registration</h3>
                    <p style="color:#b45309; font-weight:600; font-size:1rem;">Subjects to be Studied in HSC</p>
                </div>
                
                <div style="margin-bottom:20px;">
                    <div style="font-weight:600; color:#1e293b; margin-bottom:12px; font-size:0.95rem;">(A) Compulsory Subjects</div>
                    <div style="display:flex; flex-direction:column; gap:10px; margin-left:8px;">
                        <label style="display:flex; align-items:center; gap:10px; font-weight:400; color:#334155; font-size:0.95rem;">
                            <input type="checkbox" checked disabled style="width:18px; height:18px; accent-color:#059669;"> Bangla ((101, 102))
                        </label>
                        <label style="display:flex; align-items:center; gap:10px; font-weight:400; color:#334155; font-size:0.95rem;">
                            <input type="checkbox" checked disabled style="width:18px; height:18px; accent-color:#059669;"> English ((107, 108))
                        </label>
                        <label style="display:flex; align-items:center; gap:10px; font-weight:400; color:#334155; font-size:0.95rem;">
                            <input type="checkbox" checked disabled style="width:18px; height:18px; accent-color:#059669;"> Information and Communication Technology ((275))
                        </label>
                    </div>
                </div>
            `;

            // (B) Elective Subjects
            if (data.optional && data.optional.length > 0) {
                html += `
                <div style="margin-bottom:20px;">
                    <div style="font-weight:600; color:#1e293b; margin-bottom:12px; font-size:0.95rem;">(B) Elective Subjects (Any 3)</div>
                    <div style="display:flex; flex-direction:column; gap:10px; margin-left:8px;">
                `;
                data.optional.forEach((sub) => {
                    html += `
                        <label style="display:flex; align-items:center; gap:10px; cursor:pointer; font-weight:400; color:#334155; font-size:0.95rem;">
                            <input type="checkbox" name="opt_subject[]" value="${sub}" class="dyn-opt-cb" style="width:18px; height:18px; accent-color:#059669;"> ${sub}
                        </label>
                    `;
                });
                html += `</div><span class="reg-err" id="err_opt_subjects" style="margin-top:8px;display:block;"></span></div>`;
            }

            // (C) Optional Subjects
            if (data.fourth && data.fourth.length > 0) {
                html += `
                <div style="margin-bottom:20px;">
                    <div style="font-weight:600; color:#1e293b; margin-bottom:12px; font-size:0.95rem;">(C) Optional Subjects (Any 1)</div>
                    <div style="display:flex; flex-direction:column; gap:10px; margin-left:8px;">
                `;
                data.fourth.forEach((sub) => {
                    html += `
                        <label style="display:flex; align-items:center; gap:10px; cursor:pointer; font-weight:400; color:#334155; font-size:0.95rem;">
                            <input type="radio" name="fourth_subject" value="${sub}" required style="width:18px; height:18px; accent-color:#059669;"> ${sub}
                        </label>
                    `;
                });
                html += `</div><span class="reg-err" id="err_fourth_subject" style="margin-top:8px;display:block;"></span></div>`;
            }
            
            html += `</div>`;
            
            container.innerHTML = html;
            
            const optCbs = container.querySelectorAll('.dyn-opt-cb');
            const fourthRadios = container.querySelectorAll('input[name="fourth_subject"]');
            
            function checkOverlap(triggerEl) {
                const checkedElectives = Array.from(container.querySelectorAll('.dyn-opt-cb:checked')).map(cb => cb.value);
                const checkedFourth = container.querySelector('input[name="fourth_subject"]:checked');
                
                if (checkedFourth && checkedElectives.includes(checkedFourth.value)) {
                    triggerEl.checked = false;
                    showToast("Elective and Optional subjects cannot be the same!");
                }
            }

            optCbs.forEach(cb => {
                cb.addEventListener('change', (e) => {
                    const checkedCount = container.querySelectorAll('.dyn-opt-cb:checked').length;
                    if (checkedCount > 3) {
                        cb.checked = false;
                        showToast("You can only select exactly 3 Elective Subjects.");
                        return;
                    }
                    checkOverlap(e.target);
                });
            });

            fourthRadios.forEach(radio => {
                radio.addEventListener('change', (e) => {
                    checkOverlap(e.target);
                });
            });
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
            
            // Add Optional and 4th Subjects if present
            const optCbs = document.querySelectorAll('.dyn-opt-cb:checked');
            if (optCbs.length > 0) {
                const optVals = Array.from(optCbs).map(cb => cb.value).join(', ');
                addRow('Optional Subjects', optVals);
            }
            const fourthSelect = document.querySelector('input[name="fourth_subject"]:checked');
            if (fourthSelect && fourthSelect.value) {
                addRow('Optional Subject', fourthSelect.value);
            }
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
                // Extract Optional Subjects
                const optCbs = document.querySelectorAll('.dyn-opt-cb:checked');
                if (optCbs.length > 0) {
                    academic['optional_subjects'] = Array.from(optCbs).map(cb => cb.value);
                }
                // Extract 4th Subject
                const fourthSelect = document.querySelector('input[name="fourth_subject"]:checked');
                if (fourthSelect && fourthSelect.value) {
                    academic['fourth_subject'] = fourthSelect.value;
                }
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
                const apiUrl = (window.BASE_URL || '') + '/api/registration-submit.php';
                const res = await fetch(apiUrl, {
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
