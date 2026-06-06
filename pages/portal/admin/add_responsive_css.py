import os

css_path = r"c:\xampp\htdocs\pmdc\pages\portal\admin\css\students.css"

append_css = """
/* ── Responsive Admin UI ──────────────────────────────────────────── */
@media (max-width: 1280px) {
    .tm-stats-row { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 640px) {
    .tm-page-header { flex-direction: column; align-items: stretch; gap: 16px; padding: 24px; }
    .tm-header-actions { flex-direction: column; align-items: stretch; width: 100%; gap: 10px; }
    .btn-export, .btn-add-staff { width: 100%; justify-content: center; }
    
    .ra-filter-bar { flex-direction: column; align-items: stretch; }
    .tm-search-box { max-width: none; width: auto; }
    .ra-select { width: 100%; }

    .tm-stats-row { grid-template-columns: 1fr; }

    .tm-table-footer { flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: 12px; }
}
"""

with open(css_path, "a", encoding="utf-8") as f:
    f.write(append_css)

print("Added responsive media queries")
