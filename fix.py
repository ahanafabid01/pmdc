import os

js_path = r"c:\xampp\htdocs\pmdc\pages\portal\admin\js\teacher.js"
tail_path = r"c:\xampp\htdocs\pmdc\pages\portal\admin\js\teacher_tail.js"

with open(js_path, "r", encoding="utf-8") as f:
    lines = f.readlines()

# Find the end of Event bindings BEFORE it got corrupted
# We will search from the end backwards for '// Escape key' or '// Search'
keep_lines = []
for idx, line in enumerate(lines):
    if line.strip() == "// Escape key":
        # Keep everything up to here, and 3 lines after (if e.key === 'Escape')
        # Wait, the tail file ALREADY HAS event bindings!
        # Let's look at the tail file
        pass

with open(tail_path, "r", encoding="utf-8") as f:
    tail_content = f.read()

# Tail file starts with '/* ── Init ──'
# We should keep teacher.js lines up to exactly BEFORE '/* ── Init ──'
# If teacher.js doesn't have '/* ── Init ──', we keep up to '// Filter tabs' and its closing brace

cut_idx = -1
for i, line in enumerate(lines):
    if "/* ── Init" in line:
        cut_idx = i
        break

if cut_idx == -1:
    # Find the end of 'btn.addEventListener' in Filter tabs
    for i in range(len(lines)-1, -1, -1):
        if "this.dataset.cat;" in lines[i]:
            cut_idx = i + 4
            break

if cut_idx != -1:
    with open(js_path, "w", encoding="utf-8") as f:
        f.writelines(lines[:cut_idx])
        if lines[cut_idx-1].strip() != "":
            f.write("\n")
        f.write(tail_content)
    print("Fixed!")
else:
    print("Could not find cut point")
