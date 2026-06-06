import os
import glob

directory = r"c:\xampp\htdocs\pmdc\pages\portal\admin"
files = glob.glob(os.path.join(directory, "*.php"))

# We want to insert the Assign Teachers link right after Academic Calendar
target_string = '<a href="academic-calendar.php" class="nav-item"><i class="fas fa-calendar-alt"></i><span>Academic Calendar</span></a>'
link_to_add = '            <a href="assign_teachers.php" class="nav-item"><i class="fas fa-tasks"></i><span>Assign Teachers</span></a>'

for file in files:
    if "assign_teachers.php" in file:
        continue # Already has the active link we put
    
    with open(file, "r", encoding="utf-8") as f:
        content = f.read()
    
    if link_to_add.strip() not in content and target_string in content:
        content = content.replace(target_string, target_string + "\n" + link_to_add)
        with open(file, "w", encoding="utf-8") as f:
            f.write(content)
        print(f"Updated {os.path.basename(file)}")

print("Done")
