import os
import re

php_path = r"c:\xampp\htdocs\pmdc\pages\portal\admin\students.php"

with open(php_path, "r", encoding="utf-8") as f:
    content = f.read()

# 1. Replace Page Header
page_header_old = """        <!-- ── Page Header ── -->
        <div class="page-header">
            <div class="page-header-left">
                <h1 class="page-title"><i class="fas fa-users"></i> Students (শিক্ষার্থীবৃন্দ)</h1>
                <p class="page-subtitle">Full student profiles — HSC 1st Year &amp; 2nd Year across all groups</p>
            </div>
            <div class="page-header-actions">
                <button class="btn-export" id="exportBtn"><i class="fas fa-download"></i> Export CSV</button>
                <button class="btn-primary-action" id="addStudentBtn">
                    <i class="fas fa-user-plus"></i> Add Student
                </button>
            </div>
        </div>"""

page_header_new = """        <!-- ── Page Header ── -->
        <div class="tm-page-header">
            <div class="tm-page-title">
                <h1><i class="fas fa-users"></i> Students (শিক্ষার্থীবৃন্দ)</h1>
                <p>Full student profiles — HSC 1st Year &amp; 2nd Year across all groups</p>
            </div>
            <div class="tm-header-actions">
                <button class="btn-export" id="exportBtn"><i class="fas fa-download"></i> Export CSV</button>
                <button class="btn-add-staff" id="addStudentBtn">
                    <i class="fas fa-user-plus"></i> Add Student
                </button>
            </div>
        </div>"""

content = content.replace(page_header_old, page_header_new)

# 2. Replace Stats Row
stats_old = """        <!-- ── Summary Stats ── -->
        <div class="student-stats-row">
            <div class="sstat-card">
                <i class="fas fa-users sstat-icon" style="color:#3182ce;"></i>
                <div><div class="sstat-val" id="statTotal">120</div><div class="sstat-lbl">Total Students</div></div>
            </div>
            <div class="sstat-card">
                <i class="fas fa-flask sstat-icon" style="color:#38a169;"></i>
                <div><div class="sstat-val" id="statSci">40</div><div class="sstat-lbl">Science</div></div>
            </div>
            <div class="sstat-card">
                <i class="fas fa-briefcase sstat-icon" style="color:#d69e2e;"></i>
                <div><div class="sstat-val" id="statCom">40</div><div class="sstat-lbl">Business Studies</div></div>
            </div>
            <div class="sstat-card">
                <i class="fas fa-book sstat-icon" style="color:#805ad5;"></i>
                <div><div class="sstat-val" id="statHum">40</div><div class="sstat-lbl">Humanities</div></div>
            </div>
        </div>"""

stats_new = """        <!-- ── Summary Stats ── -->
        <div class="tm-stats-row">
            <div class="tm-stat-pill">
                <i class="fas fa-users" style="color:var(--blue);font-size:1rem;flex-shrink:0;"></i>
                <span class="ts-val" id="statTotal">120</span>
                <span class="ts-lbl">Total Students</span>
            </div>
            <div class="tm-stat-pill">
                <i class="fas fa-flask" style="color:#16a34a;font-size:1rem;flex-shrink:0;"></i>
                <span class="ts-val" id="statSci">40</span>
                <span class="ts-lbl">Science</span>
            </div>
            <div class="tm-stat-pill">
                <i class="fas fa-briefcase" style="color:#ca8a04;font-size:1rem;flex-shrink:0;"></i>
                <span class="ts-val" id="statCom">40</span>
                <span class="ts-lbl">Business Studies</span>
            </div>
            <div class="tm-stat-pill">
                <i class="fas fa-book" style="color:#7c3aed;font-size:1rem;flex-shrink:0;"></i>
                <span class="ts-val" id="statHum">40</span>
                <span class="ts-lbl">Humanities</span>
            </div>
        </div>"""

content = content.replace(stats_old, stats_new)

# 3. Replace Filter Bar Classes
content = content.replace('<div class="card filter-bar-card">', '<div class="tm-card" style="padding:0; margin-bottom: 20px;">')
content = content.replace('<div class="filter-bar">', '<div class="ra-filter-bar" style="flex-wrap: wrap;">')
content = content.replace('<div class="filter-search">', '<div class="tm-search-box" style="flex:1; min-width: 250px;">')
content = content.replace('class="filter-select"', 'class="ra-select"')

# Remove labels inside filter groups to match admin style
content = re.sub(r'<div class="filter-group">\s*<label>[^<]+</label>\s*<select', '<select', content)
content = re.sub(r'</select>\s*</div>', '</select>', content)

# 4. Replace Table Classes
content = content.replace('<div class="card" id="tableView">', '<div class="tm-card" id="tableView" style="padding:0;">')
content = content.replace('<div class="table-responsive">', '<div class="tm-table-wrap">')
content = content.replace('<table class="students-table"', '<table class="tm-table"')
content = content.replace('<div class="table-footer">', '<div class="tm-table-footer">')
content = content.replace('<div class="table-info"', '<div id="tableInfo"')
content = content.replace('<div class="pagination"', '<div class="tm-pagination"')

# Write back
with open(php_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Optimized students.php HTML")
