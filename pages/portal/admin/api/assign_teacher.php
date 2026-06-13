<?php
header('Content-Type: application/json');
require_once '../../../../includes/session_check.php';
require_once '../../../../includes/config.php';

// Ensure the caller is an admin
if ($_SESSION['role'] !== 'admin') {
    echo json_encode(['ok' => false, 'msg' => 'Unauthorized']);
    exit;
}

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $action = $_GET['action'] ?? '';

    if ($action === 'meta') {
        $programs = $pdo->query("SELECT id, name, full_name, type, compulsory_subjects, optional_subjects, fourth_subjects, subject_codes FROM academics_programs")->fetchAll(PDO::FETCH_ASSOC);
        
        $classes_list = [];
        $program_subjects = [];
        
        foreach ($programs as $p) {
            $name = !empty($p['full_name']) ? $p['full_name'] : $p['name'];
            $classes_list[] = ['id' => $p['id'], 'name' => $name, 'type' => $p['type']];
            
            $compulsory = json_decode($p['compulsory_subjects'] ?? '[]', true) ?: [];
            $optional   = json_decode($p['optional_subjects']   ?? '[]', true) ?: [];
            $fourth     = json_decode($p['fourth_subjects']     ?? '[]', true) ?: [];
            $codes      = json_decode($p['subject_codes']       ?? '{}', true) ?: [];
            
            $allSubs = array_values(array_unique(array_merge($compulsory, $optional, $fourth)));
            sort($allSubs);
            
            // Expand each subject into per-paper options
            $expanded = [];
            foreach ($allSubs as $sub) {
                $key   = preg_replace('/\s*\(.*?\)\s*/', '', $sub); // strip Bengali
                $entry = $codes[$key] ?? null;
                
                if ($entry && isset($entry['1st']) && isset($entry['2nd'])) {
                    // Two-paper subject
                    $expanded[] = [
                        'value'   => $sub . '||1st',
                        'label'   => $key . ' — 1st Paper [' . $entry['1st'] . ']',
                        'subject' => $sub,
                        'paper'   => '1st',
                        'code'    => $entry['1st'],
                    ];
                    $expanded[] = [
                        'value'   => $sub . '||2nd',
                        'label'   => $key . ' — 2nd Paper [' . $entry['2nd'] . ']',
                        'subject' => $sub,
                        'paper'   => '2nd',
                        'code'    => $entry['2nd'],
                    ];
                } elseif ($entry && isset($entry['only'])) {
                    // Single-paper subject (ICT)
                    $expanded[] = [
                        'value'   => $sub . '||only',
                        'label'   => $key . ' [' . $entry['only'] . ']',
                        'subject' => $sub,
                        'paper'   => 'only',
                        'code'    => $entry['only'],
                    ];
                } else {
                    // No codes configured yet
                    $expanded[] = [
                        'value'   => $sub . '||only',
                        'label'   => $key,
                        'subject' => $sub,
                        'paper'   => 'only',
                        'code'    => null,
                    ];
                }
            }
            
            $program_subjects[$p['id']] = $expanded;
        }
        
        echo json_encode(['ok' => true, 'classes' => $classes_list, 'program_subjects' => $program_subjects]);
        exit;
    }

    if ($action === 'list_all') {
        $stmt = $pdo->prepare("
            SELECT a.id, u.name as staff_name, u.username as staff_id, 
                   COALESCE(NULLIF(p.full_name, ''), p.name) as class_name, 
                   a.subject_name, a.paper
            FROM teacher_assignments a
            JOIN users u ON a.user_id = u.id
            JOIN academics_programs p ON a.program_id = p.id
            ORDER BY u.name, class_name
        ");
        $stmt->execute();
        $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['ok' => true, 'assignments' => $assignments]);
        exit;
    }

    if ($action === 'list') {
        $staffId = $_GET['staff_id'] ?? '';
        
        // Find corresponding user
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$staffId]); // Using staffId as username for teachers
        $userId = $stmt->fetchColumn();
        
        if (!$userId) {
            echo json_encode(['ok' => true, 'assignments' => []]);
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT a.id, 
                   COALESCE(NULLIF(p.full_name, ''), p.name) as class_name, 
                   a.subject_name, a.paper
            FROM teacher_assignments a
            JOIN academics_programs p ON a.program_id = p.id
            WHERE a.user_id = ?
        ");
        $stmt->execute([$userId]);
        $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['ok' => true, 'assignments' => $assignments]);
        exit;
    }

    if ($action === 'add') {
        $data = json_decode(file_get_contents('php://input'), true);
        $staffId    = $data['staff_id']    ?? '';
        $staffName  = $data['staff_name']  ?? '';
        $classId    = $data['class_id']    ?? '';
        $subjectId  = $data['subject_id']  ?? ''; // subject_name string
        $paper      = $data['paper']       ?? null; // '1st', '2nd', 'only', or null
        
        if (!$staffId || !$classId || !$subjectId) {
            echo json_encode(['ok' => false, 'msg' => 'Missing fields']);
            exit;
        }

        // Fetch staff email
        $stmt = $pdo->prepare("SELECT email FROM staff WHERE id = ?");
        $stmt->execute([$staffId]);
        $staffEmail = $stmt->fetchColumn();

        if (!$staffEmail || $staffEmail === 'N/A') {
            echo json_encode(['ok' => false, 'msg' => 'Teacher must have a valid email address']);
            exit;
        }
        
        // Create user if doesn't exist
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$staffEmail]);
        $userId = $stmt->fetchColumn();
        
        $loginCreated = false;
        if (!$userId) {
            $pass = password_hash('password123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, role, name) VALUES (?, ?, 'teacher', ?)");
            $stmt->execute([$staffEmail, $pass, $staffName]);
            $userId = $pdo->lastInsertId();
            $loginCreated = true;
        }
        
        // Insert assignment — normalize paper to null if 'only'
        $paperVal = ($paper === 'only' || $paper === null) ? null : $paper;
        try {
            $stmt = $pdo->prepare("INSERT INTO teacher_assignments (user_id, program_id, subject_name, paper) VALUES (?, ?, ?, ?)");
            $stmt->execute([$userId, $classId, $subjectId, $paperVal]);
            echo json_encode(['ok' => true, 'msg' => 'Assignment added!', 'loginCreated' => $loginCreated]);
        } catch(PDOException $e) {
            echo json_encode(['ok' => false, 'msg' => 'Assignment already exists for this teacher/subject/paper']);
        }
        exit;
    }
    
    if ($action === 'delete') {
        $id = $_GET['id'] ?? '';
        $stmt = $pdo->prepare("DELETE FROM teacher_assignments WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['ok' => true]);
        exit;
    }

} catch (PDOException $e) {
    echo json_encode(['ok' => false, 'msg' => 'Database error: ' . $e->getMessage()]);
}
