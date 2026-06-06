$css = @"

/* ════════════════════ FORM TABS ════════════════════ */
.form-tabs {
    display: flex;
    overflow-x: auto;
    gap: 8px;
    border-bottom: 2px solid #e2e8f0;
    margin-bottom: 24px;
    padding-bottom: 8px;
    scrollbar-width: none;
}
.form-tabs::-webkit-scrollbar { display: none; }

.ftab {
    background: transparent;
    border: none;
    padding: 10px 18px;
    font-size: 15px;
    font-weight: 600;
    color: #64748b;
    border-radius: 8px;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}
.ftab:hover { background: #f1f5f9; color: #0f172a; }
.ftab.active { background: #eef2ff; color: #4f46e5; position: relative; }
.ftab.active::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 100%;
    height: 3px;
    background: #4f46e5;
    border-radius: 3px 3px 0 0;
}

/* ════════════════════ PHOTO UPLOAD ════════════════════ */
.photo-upload-area {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    background: #f8fafc;
    padding: 24px;
    border-radius: 12px;
    border: 1px dashed #cbd5e1;
}
.photo-preview {
    width: 120px;
    height: 150px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    overflow: hidden;
    position: relative;
    border: 2px solid #e2e8f0;
}
.photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.photo-preview i { font-size: 48px; margin-bottom: 8px; color: #cbd5e1; }
.photo-preview span { font-size: 12px; text-align: center; padding: 0 8px; }
.photo-instructions { flex: 1; }
.photo-instructions p { margin-bottom: 8px; font-size: 15px; color: #334155; }
.photo-instructions ul { margin-left: 20px; color: #64748b; font-size: 14px; margin-bottom: 16px; }
.photo-instructions li { margin-bottom: 4px; }
.photo-upload-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}
.photo-upload-btn:hover { background: #f1f5f9; border-color: #94a3b8; color: #0f172a; }
"@

Add-Content -Path "c:\xampp\htdocs\pmdc\pages\portal\admin\css\students.css" -Value $css
Write-Host "CSS Appended Successfully"
