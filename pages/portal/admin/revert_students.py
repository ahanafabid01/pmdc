import os
import re

php_path = r"c:\xampp\htdocs\pmdc\pages\portal\admin\students.php"

with open(php_path, "r", encoding="utf-8") as f:
    content = f.read()

# Reverse 1. Page Header
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

content = content.replace(page_header_new, page_header_old)

# Reverse 2. Stats Row
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

content = content.replace(stats_new, stats_old)

# Reverse 3. Filter Bar Classes
content = content.replace('<div class="tm-card" style="padding:0; margin-bottom: 20px;">', '<div class="card filter-bar-card">')
content = content.replace('<div class="ra-filter-bar" style="flex-wrap: wrap;">', '<div class="filter-bar">')
content = content.replace('<div class="tm-search-box" style="flex:1; min-width: 250px;">', '<div class="filter-search">')
content = content.replace('class="ra-select"', 'class="filter-select"')

# Add labels back to filter groups
# It's tricky to restore exactly via regex, let's just replace the block manually.
filter_block_regex = r'<div class="filter-search">.*?<select id="sortFilter" class="filter-select">.*?</select>'
original_filter_block = """<div class="filter-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="studentSearch" placeholder="Search by name, roll, or registration number...">
                </div>
                <div class="filter-group">
                    <label>Session (শিক্ষাবর্ষ)</label>
                    <select id="sessionFilter" class="filter-select">
                        <option value="">All Sessions</option>
                        <option value="2022–2023">2022–2023</option>
                        <option value="2023–2024">2023–2024</option>
                        <option value="2024–2025">2024–2025</option>
                        <option value="2025–2026">2025–2026</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Year</label>
                    <select id="yearFilter" class="filter-select">
                        <option value="">All Years</option>
                        <option value="xi">HSC 1st Year (একাদশ)</option>
                        <option value="xii">HSC 2nd Year (দ্বাদশ)</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Group (বিভাগ)</label>
                    <select id="groupFilter" class="filter-select">
                        <option value="">All Groups</option>
                        <option value="science">বিজ্ঞান (Science)</option>
                        <option value="commerce">ব্যবসায় শিক্ষা (Business Studies)</option>
                        <option value="humanities">মানবিক (Humanities)</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Section</label>
                    <select id="sectionFilter" class="filter-select">
                        <option value="">All Sections</option>
                        <option value="A">Section A</option>
                        <option value="B">Section B</option>
                        <option value="C">Section C</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Sort</label>
                    <select id="sortFilter" class="filter-select">
                        <option value="name">Name (A–Z)</option>
                        <option value="roll">Roll Number</option>
                        <option value="recent">Recently Added</option>
                    </select>"""

content = re.sub(filter_block_regex, original_filter_block, content, flags=re.DOTALL)


# Reverse 4. Table Classes
content = content.replace('<div class="tm-card" id="tableView" style="padding:0;">', '<div class="card" id="tableView">')
content = content.replace('<div class="tm-table-wrap">', '<div class="table-responsive">')
content = content.replace('<table class="tm-table"', '<table class="students-table"')
content = content.replace('<div class="tm-table-footer">', '<div class="table-footer">')
content = content.replace('<div id="tableInfo">Loading…</div>', '<div class="table-info" id="tableInfo">Loading…</div>')
content = content.replace('<div class="tm-pagination"', '<div class="pagination"')

# Write back
with open(php_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Reverted students.php HTML")
