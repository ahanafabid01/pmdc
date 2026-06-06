import os

css_path = r"c:\xampp\htdocs\pmdc\pages\portal\admin\css\students.css"

with open(css_path, "r", encoding="utf-8") as f:
    content = f.read()

append_css = """
/* ═══════════════════════════════════════════════════════════
   ADDED: Admin Portal Optimized UI Components 
═══════════════════════════════════════════════════════════ */

/* ── Page header ──────── */
.tm-page-header {
    display: flex; align-items: center; justify-content: space-between;
    gap: 20px; flex-wrap: wrap;
    background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
    border-radius: 16px;
    padding: 28px 32px;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    margin-bottom: 24px;
}
.tm-page-header::before {
    content: ''; position: absolute; top: 0; right: 0; bottom: 0; width: 40%;
    background-image: radial-gradient(rgba(255,255,255,.06) 1px, transparent 1px);
    background-size: 22px 22px; pointer-events: none;
}
.tm-page-title { position: relative; z-index: 1; }
.tm-page-title h1 {
    font-size: 1.5rem; font-weight: 800; color: #fff;
    margin-bottom: 6px;
    display: flex; align-items: center; gap: 10px;
}
.tm-page-title h1 i { color: #fff; opacity: 0.8; }
.tm-page-title p {
    font-size: .875rem; color: rgba(255,255,255,.6);
    font-family: 'Inter', sans-serif;
}
.tm-header-actions {
    display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    position: relative; z-index: 1;
}

.btn-export {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 16px; border-radius: 10px;
    border: 1px solid rgba(255,255,255,.2);
    background: rgba(255,255,255,.1); color: #fff;
    font-size: .82rem; font-weight: 600;
    font-family: 'Inter', sans-serif;
    transition: all var(--transition); backdrop-filter: blur(4px);
}
.btn-export:hover { 
    background: rgba(255,255,255,.2); border-color: rgba(255,255,255,.3); color: #fff;
}

.btn-add-staff {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 9px 20px; border-radius: 10px;
    background: #fff; color: var(--navy);
    border: none; font-size: .875rem; font-weight: 800;
    font-family: 'Inter', sans-serif;
    cursor: pointer; transition: all var(--transition);
    box-shadow: 0 4px 14px rgba(0,0,0,.15);
}
.btn-add-staff:hover { background: #f8fafc; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.2); }

/* ── Stats pills ────────── */
.tm-stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
.tm-stat-pill {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 22px 22px 18px;
    display: grid;
    grid-template-columns: 48px 1fr;
    grid-template-rows: auto auto;
    column-gap: 16px; row-gap: 4px;
    align-items: center;
    box-shadow: var(--shadow);
    transition: transform var(--transition), box-shadow var(--transition);
}
.tm-stat-pill:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
.tm-stat-pill i { 
    grid-column: 1; grid-row: 1 / 3;
    width: 48px; height: 48px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; color: #fff;
}
.tm-stat-pill:nth-child(1) i { background: #3b82f6; color: #fff !important; }
.tm-stat-pill:nth-child(2) i { background: #10b981; color: #fff !important; }
.tm-stat-pill:nth-child(3) i { background: #f59e0b; color: #fff !important; }
.tm-stat-pill:nth-child(4) i { background: #8b5cf6; color: #fff !important; }

.ts-val { grid-column: 2; grid-row: 1; font-size: 1.8rem; font-weight: 800; color: var(--text); line-height: 1; margin-top: 4px; }
.ts-lbl { grid-column: 2; grid-row: 2; font-size: .78rem; font-weight: 600; color: var(--muted); font-family: 'Inter', sans-serif; text-transform: uppercase; letter-spacing: 0.05em; }

/* ── Table card ──────────────────────────────────────────── */
.tm-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    min-width: 0;
    width: 100%;
}
.tm-table-wrap { overflow-x: auto; width: 100%; }

.tm-table {
    width: 100%; border-collapse: collapse; min-width: 800px;
}
.tm-table thead th {
    background: #f8fafc;
    padding: 11px 16px;
    text-align: left;
    font-size: .72rem; font-weight: 700;
    color: var(--muted); text-transform: uppercase;
    letter-spacing: .07em;
    border-bottom: 1px solid var(--border);
    white-space: nowrap;
}
.tm-table tbody tr { transition: background var(--transition); }
.tm-table tbody tr:hover { background: #f8fafc; }
.tm-table tbody td {
    padding: 12px 16px;
    border-bottom: 1px solid #f1f5f9;
    font-size: .855rem; color: var(--text);
    font-family: 'Inter', sans-serif;
    vertical-align: middle;
}
.tm-table tbody tr:last-child td { border-bottom: none; }

/* ── Filter Bar ──────────────────────────────────────────── */
.ra-filter-bar {
    display: flex; align-items: center; gap: 12px;
    padding: 16px 20px;
    background: #fff;
    border-bottom: 1px solid var(--border);
}
.tm-search-box {
    display: flex; align-items: center; gap: 10px;
    background: #f8fafc;
    border: 1.5px solid transparent;
    border-radius: 10px;
    padding: 9px 16px;
    flex: 1;
    transition: all var(--transition);
}
.tm-search-box:focus-within { border-color: var(--blue); background: #fff; box-shadow: 0 0 0 3px var(--blue-light); }
.tm-search-box i { color: var(--muted); font-size: .85rem; }
.tm-search-box input {
    border: none; background: none; outline: none;
    font-size: .875rem; color: var(--text);
    font-family: 'Inter', sans-serif; width: 100%;
}
.ra-select {
    padding: 9px 30px 9px 14px;
    border: 1.5px solid var(--border);
    border-radius: 9px;
    font-size: .84rem; font-weight: 600;
    color: var(--text); background: #fff;
    outline: none; cursor: pointer;
    font-family: 'Inter', sans-serif;
    transition: all var(--transition);
    -webkit-appearance: none; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='7' viewBox='0 0 11 7'%3E%3Cpath d='M1 1l4.5 4.5L10 1' stroke='%2364748b' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
}
.ra-select:focus { border-color: var(--blue); box-shadow: 0 0 0 3px var(--blue-light); }

/* Table footer */
.tm-table-footer {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    border-top: 1px solid var(--border);
    background: #fff;
    font-size: .8rem; color: var(--muted);
    font-family: 'Inter', sans-serif;
    flex-wrap: wrap; gap: 10px;
}
.tm-pagination { display: flex; gap: 4px; }
"""

if "/* ── Page header ──────── */" not in content:
    with open(css_path, "a", encoding="utf-8") as f:
        f.write(append_css)
    print("Added admin CSS classes to students.css")
else:
    print("Admin CSS already exists in students.css")
