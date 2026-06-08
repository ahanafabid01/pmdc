<?php
header('Content-Type: application/json');
require_once '../includes/config.php';

$action = $_GET['action'] ?? '';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );

    if ($action === 'exams') {
        $stmt = $pdo->query("SELECT id, name, year FROM exams WHERE status = 'active' ORDER BY id DESC");
        $exams = $stmt->fetchAll();

        // Fetch Classes from academics_programs
        $classes = [];
        try {
            $stmt = $pdo->query("SELECT DISTINCT type FROM academics_programs WHERE type = 'hsc' ORDER BY type DESC");
            $dbClasses = $stmt->fetchAll(PDO::FETCH_COLUMN);
            foreach ($dbClasses as $c) {
                $classes[] = strtoupper($c); // e.g. "HSC"
            }
        } catch(Exception $e) {}

        // Fetch Groups from academics_programs
        $groups = [];
        try {
            $stmt = $pdo->query("SELECT DISTINCT name FROM academics_programs WHERE type = 'hsc' ORDER BY name");
            $groups = $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch(Exception $e) {}

        // Fetch Years from classes
        $years = [];
        try {
            $stmt = $pdo->query("SELECT DISTINCT year FROM classes WHERE name LIKE 'HSC%' ORDER BY year");
            $dbYears = $stmt->fetchAll(PDO::FETCH_COLUMN);
            foreach ($dbYears as $y) {
                if (strtolower($y) === 'xi') $years[] = 'HSC 1st Year';
                elseif (strtolower($y) === 'xii') $years[] = 'HSC 2nd Year';
                else $years[] = ucfirst($y);
            }
        } catch(Exception $e) {}

        // Fetch distinct sessions from students if any
        $stmt = $pdo->query("SELECT DISTINCT session FROM students WHERE session IS NOT NULL AND session != '' ORDER BY session DESC");
        $sessions = $stmt->fetchAll(PDO::FETCH_COLUMN);
        // Fallback for sessions if students table is empty
        if (empty($sessions)) {
            try {
                $stmt = $pdo->query("SELECT DISTINCT session FROM registration_settings WHERE session IS NOT NULL");
                $sessions = $stmt->fetchAll(PDO::FETCH_COLUMN);
            } catch (Exception $e) {}
        }

        echo json_encode([
            'ok' => true,
            'exams' => $exams,
            'classes' => $classes,
            'sessions' => $sessions,
            'groups' => $groups,
            'years' => $years
        ]);
    } 
    elseif ($action === 'search') {
        $exam_id = (int)($_GET['exam_id'] ?? 0);
        $roll = $_GET['roll'] ?? '';

        if (!$exam_id || !$roll) {
            echo json_encode(['ok' => false, 'msg' => 'Please provide Exam and Roll No.']);
            exit;
        }

        // 1. Find the student
        $stmt = $pdo->prepare("SELECT id, name, roll, regno, session, academic_group as `group`, section FROM students WHERE roll = ? LIMIT 1");
        $stmt->execute([$roll]);
        $student = $stmt->fetch();

        if (!$student) {
            echo json_encode(['ok' => false, 'msg' => 'Student not found with this Roll No.']);
            exit;
        }

        // 2. Find the program id for the student's group
        $groupMap = [
            'science' => 'hsc-science',
            'humanities' => 'hsc-humanities',
            'business' => 'hsc-business',
            'commerce' => 'hsc-business',
            'ba' => 'deg-ba',
            'arts' => 'deg-ba',
            'bmt' => 'deg-bmt',
            'bsc' => 'deg-bsc',
            'bss' => 'deg-bss'
        ];
        $progId = $groupMap[strtolower($student['group'])] ?? '';

        if (!$progId) {
            echo json_encode(['ok' => false, 'msg' => 'Invalid academic group for this student.']);
            exit;
        }

        // 3. Check if released
        $stmt = $pdo->prepare("SELECT is_released FROM exam_releases WHERE exam_id = ? AND program_id = ?");
        $stmt->execute([$exam_id, $progId]);
        $is_released = $stmt->fetchColumn();

        if (!$is_released) {
            echo json_encode(['ok' => false, 'msg' => 'Results for this exam have not been published yet.']);
            exit;
        }

        // 4. Fetch marks
        $stmt = $pdo->prepare("
            SELECT subject_name, mark, full_marks 
            FROM exam_marks 
            WHERE exam_id = ? AND student_id = ?
            ORDER BY subject_name
        ");
        $stmt->execute([$exam_id, $student['id']]);
        $marks = $stmt->fetchAll();

        if (empty($marks)) {
            echo json_encode(['ok' => false, 'msg' => 'No marks found for this student.']);
            exit;
        }

        // Calculate GPA
        $totalGp = 0;
        $failed = false;
        $subjectCount = count($marks);
        $processedMarks = [];

        foreach ($marks as $m) {
            $pct = ($m['mark'] / $m['full_marks']) * 100;
            $gp = 0;
            $letter = 'F';

            if ($pct >= 80) { $gp = 5.0; $letter = 'A+'; }
            elseif ($pct >= 70) { $gp = 4.0; $letter = 'A'; }
            elseif ($pct >= 60) { $gp = 3.5; $letter = 'A-'; }
            elseif ($pct >= 50) { $gp = 3.0; $letter = 'B'; }
            elseif ($pct >= 40) { $gp = 2.0; $letter = 'C'; }
            elseif ($pct >= 33) { $gp = 1.0; $letter = 'D'; }
            else { $failed = true; }

            $totalGp += $gp;
            
            $processedMarks[] = [
                'subject' => $m['subject_name'],
                'mark' => $m['mark'],
                'full_marks' => $m['full_marks'],
                'letter' => $letter,
                'gp' => number_format($gp, 2)
            ];
        }

        $cgpa = $failed ? 0.00 : ($totalGp / $subjectCount);

        echo json_encode([
            'ok' => true,
            'student' => [
                'name' => $student['name'],
                'roll' => $student['roll'],
                'regno' => $student['regno'],
                'group' => $student['group'],
                'session' => $student['session']
            ],
            'marks' => $processedMarks,
            'gpa' => number_format($cgpa, 2),
            'status' => $failed ? 'FAILED' : 'PASSED'
        ]);
    } else {
        echo json_encode(['ok' => false, 'msg' => 'Unknown action']);
    }
} catch (Exception $e) {
    echo json_encode(['ok' => false, 'msg' => 'Database error: ' . $e->getMessage()]);
}
