<?php
/**
 * get_teacher_context.php
 * Returns the authenticated teacher's assigned programs, subjects and real students.
 */
header('Content-Type: application/json');
require_once '../../../includes/session_check.php';
require_once '../../../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    echo json_encode(['ok' => false, 'msg' => 'Unauthorized']);
    exit;
}

// Map program_id → academic_group values stored in the students table
// e.g.  hsc-science   → ['science']
//        hsc-humanities → ['humanities']
//        deg-ba         → ['ba', 'BA', 'arts']
const PROGRAM_GROUP_MAP = [
    'hsc-science'    => ['science'],
    'hsc-humanities' => ['humanities'],
    'hsc-business'   => ['business', 'commerce', 'business studies'],
    'deg-ba'         => ['ba', 'arts', 'BA'],
    'deg-bmt'        => ['bmt', 'business management', 'BMT'],
    'deg-bsc'        => ['bsc', 'BSc', 'science'],
    'deg-bss'        => ['bss', 'BSS', 'social science'],
];

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );

    $userId = (int) $_SESSION['user_id'];

    /* ── 1. Get teacher's assignments with program details ── */
    $stmt = $pdo->prepare("
        SELECT 
            ta.id AS assignment_id,
            ta.program_id,
            ta.subject_name,
            COALESCE(NULLIF(ap.full_name, ''), ap.name) AS program_name,
            ap.type  AS program_type,
            ap.accent_color
        FROM teacher_assignments ta
        JOIN academics_programs ap ON ta.program_id = ap.id
        WHERE ta.user_id = ?
        ORDER BY ap.type, ap.name, ta.subject_name
    ");
    $stmt->execute([$userId]);
    $assignments = $stmt->fetchAll();

    /* ── 2. Build unique program list ── */
    $programsById = [];
    $subjectsList  = [];
    foreach ($assignments as $a) {
        if (!isset($programsById[$a['program_id']])) {
            $programsById[$a['program_id']] = [
                'id'           => $a['program_id'],
                'name'         => $a['program_name'],
                'type'         => $a['program_type'],
                'accent_color' => $a['accent_color'] ?? '#2563eb',
            ];
        }
        if (!in_array($a['subject_name'], $subjectsList)) {
            $subjectsList[] = $a['subject_name'];
        }
    }
    $programs = array_values($programsById);
    sort($subjectsList);

    /* ── 3. Fetch real students scoped to assigned programs ── */
    $students = [];
    if (!empty($programsById)) {
        // Build WHERE clause: match academic_group for each assigned program
        $groupConditions = [];
        $bindParams = [];
        foreach (array_keys($programsById) as $pid) {
            $groups = PROGRAM_GROUP_MAP[$pid] ?? [];
            foreach ($groups as $g) {
                $groupConditions[] = 'LOWER(s.academic_group) = LOWER(?)';
                $bindParams[] = $g;
            }
        }

        if (!empty($groupConditions)) {
            $whereClause = implode(' OR ', $groupConditions);
            $sql = "
                SELECT 
                    s.id, s.name, s.roll, s.regno,
                    s.year, s.academic_group AS `group`,
                    UPPER(COALESCE(s.section, 'A')) AS section,
                    s.session, s.optional_subject
                FROM students s
                WHERE ($whereClause)
                ORDER BY s.academic_group, s.year, s.section, s.roll
            ";
            $stmt2 = $pdo->prepare($sql);
            $stmt2->execute($bindParams);
            $students = $stmt2->fetchAll();
        }
    }

    /* ── 4. Build per-program subject mapping for dropdowns ── */
    $programSubjects = [];
    foreach ($assignments as $a) {
        $pid = $a['program_id'];
        if (!isset($programSubjects[$pid])) {
            $programSubjects[$pid] = [];
        }
        if (!in_array($a['subject_name'], $programSubjects[$pid])) {
            $programSubjects[$pid][] = $a['subject_name'];
        }
    }

    /* ── 5. Build sections per program ── */
    $programSections = [];
    foreach ($students as $s) {
        // find which program this student belongs to
        foreach (array_keys($programsById) as $pid) {
            $groups = PROGRAM_GROUP_MAP[$pid] ?? [];
            foreach ($groups as $g) {
                if (strtolower($s['group']) === strtolower($g)) {
                    if (!isset($programSections[$pid])) $programSections[$pid] = [];
                    if (!in_array($s['section'], $programSections[$pid])) {
                        $programSections[$pid][] = $s['section'];
                    }
                    break 2;
                }
            }
        }
    }

    echo json_encode([
        'ok'              => true,
        'teacher_name'    => $_SESSION['name'] ?? 'Teacher',
        'teacher_username'=> $_SESSION['username'] ?? '',
        'teacher_user_id' => $userId,
        'assignments'     => $assignments,
        'programs'        => $programs,
        'subjects'        => $subjectsList,
        'program_subjects'=> $programSubjects,
        'program_sections'=> $programSections,
        'students'        => $students,
        'student_count'   => count($students),
    ]);

} catch (PDOException $e) {
    echo json_encode(['ok' => false, 'msg' => 'Database error: ' . $e->getMessage()]);
}
?>
