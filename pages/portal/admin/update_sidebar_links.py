import os
import re

admin_dir = r"c:\xampp\htdocs\pmdc\pages\portal\admin"

# Match both single-line and multi-line variants of the Students link
# e.g. <a href="#" class="nav-item"><i class="fas fa-users"></i><span>Students</span>
# or <a href="#" class="nav-item">\n<i class="fas fa-users"></i>\n<span>Students</span>

pattern = re.compile(
    r'<a\s+href="[^"]*"\s+class="nav-item(\sactive)?"[^>]*>\s*<i\s+class="fas fa-users"></i>\s*<span>Students</span>',
    re.IGNORECASE | re.MULTILINE
)

for filename in os.listdir(admin_dir):
    if filename.endswith(".php"):
        filepath = os.path.join(admin_dir, filename)
        with open(filepath, "r", encoding="utf-8") as f:
            content = f.read()

        if filename == "students.php":
            # For students.php, ensure it's active
            replacement = r'<a href="students.php" class="nav-item active"><i class="fas fa-users"></i><span>Students</span>'
        else:
            replacement = r'<a href="students.php" class="nav-item"><i class="fas fa-users"></i><span>Students</span>'

        new_content = pattern.sub(replacement, content)

        # Let's also catch the multi-line version cleanly if the above regex missed it because of spaces
        multi_line_pattern = re.compile(
            r'<a\s+href="[^"]*"\s+class="nav-item[^>]*>\s*<i\s+class="fas fa-users"></i>\s*<span>Students</span>\s*(<span[^>]*>.*?</span>)?\s*</a>',
            re.IGNORECASE | re.MULTILINE | re.DOTALL
        )
        
        # It's safer to just do a simple replace since we know the exact string in single line
        single_line_target = '<a href="#" class="nav-item"><i class="fas fa-users"></i><span>Students</span><span class="badge">450</span></a>'
        single_line_repl = '<a href="students.php" class="nav-item"><i class="fas fa-users"></i><span>Students</span></a>'
        
        new_content = new_content.replace(single_line_target, single_line_repl)
        
        # Another target just in case there's no badge
        single_line_target_no_badge = '<a href="#" class="nav-item"><i class="fas fa-users"></i><span>Students</span></a>'
        new_content = new_content.replace(single_line_target_no_badge, single_line_repl)

        if new_content != content:
            with open(filepath, "w", encoding="utf-8") as f:
                f.write(new_content)
            print(f"Updated sidebar in {filename}")

print("Done updating sidebars.")
