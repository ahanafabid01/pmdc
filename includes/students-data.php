<?php
/**
 * students-data.php
 * Data layer for PMDC Students
 */
require_once __DIR__ . '/config.php';

/* ── DB connection ──────────────────────────────────────────────────── */
function pmdc_students_db() {
    static $pdo = null;
    if ($pdo) return $pdo;
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        return null;
    }
    return $pdo;
}

/* ── Ensure table exists ────────────────────────────────────────────── */
function pmdc_students_init() {
    $db = pmdc_students_db();
    if (!$db) return false;
    $db->exec("CREATE TABLE IF NOT EXISTS students (
        id               VARCHAR(50) PRIMARY KEY,
        name             VARCHAR(255) NOT NULL,
        initials         VARCHAR(5) NOT NULL,
        roll             VARCHAR(50) NOT NULL,
        regno            VARCHAR(50) NOT NULL,
        year             VARCHAR(20) NOT NULL,
        academic_group   VARCHAR(50) NOT NULL,
        optional_subject VARCHAR(100),
        section          VARCHAR(20),
        session          VARCHAR(50),
        institution      VARCHAR(255),
        
        dob              DATE,
        gender           VARCHAR(20),
        religion         VARCHAR(50),
        blood_group      VARCHAR(10),
        nid              VARCHAR(50),
        birth_cert       VARCHAR(50),
        
        phone            VARCHAR(50),
        email            VARCHAR(255),
        present_addr     TEXT,
        permanent_addr   TEXT,
        
        father_name      VARCHAR(255),
        father_nid       VARCHAR(50),
        father_phone     VARCHAR(50),
        father_occ       VARCHAR(100),
        
        mother_name      VARCHAR(255),
        mother_nid       VARCHAR(50),
        mother_phone     VARCHAR(50),
        mother_occ       VARCHAR(100),
        
        guardian_name    VARCHAR(255),
        guardian_phone   VARCHAR(50),
        guardian_rel     VARCHAR(50),
        
        photo_url        VARCHAR(255),
        color            VARCHAR(20),
        added_date       DATE,
        
        created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    return true;
}

/* ── CRUD Operations ────────────────────────────────────────────────── */

function pmdc_get_all_students() {
    $db = pmdc_students_db();
    if (!$db) return [];
    // Format column names to match the camelCase used in JS if needed,
    // but we can also just fetch and map in api-students.php
    $stmt = $db->query("SELECT * FROM students ORDER BY added_date DESC, id DESC");
    return $stmt->fetchAll();
}

function pmdc_add_student($data) {
    $db = pmdc_students_db();
    if (!$db) return false;
    
    $sql = "INSERT INTO students (
        id, name, initials, roll, regno, year, academic_group, optional_subject, section, session, institution,
        dob, gender, religion, blood_group, nid, birth_cert,
        phone, email, present_addr, permanent_addr,
        father_name, father_nid, father_phone, father_occ,
        mother_name, mother_nid, mother_phone, mother_occ,
        guardian_name, guardian_phone, guardian_rel,
        photo_url, color, added_date
    ) VALUES (
        :id, :name, :initials, :roll, :regno, :year, :academic_group, :optional_subject, :section, :session, :institution,
        :dob, :gender, :religion, :blood_group, :nid, :birth_cert,
        :phone, :email, :present_addr, :permanent_addr,
        :father_name, :father_nid, :father_phone, :father_occ,
        :mother_name, :mother_nid, :mother_phone, :mother_occ,
        :guardian_name, :guardian_phone, :guardian_rel,
        :photo_url, :color, :added_date
    )";
    $stmt = $db->prepare($sql);
    return $stmt->execute($data);
}

function pmdc_update_student($id, $data) {
    $db = pmdc_students_db();
    if (!$db) return false;
    
    $data['id'] = $id; // ensure ID matches
    
    $sql = "UPDATE students SET
        name = :name, initials = :initials, roll = :roll, regno = :regno, year = :year, 
        academic_group = :academic_group, optional_subject = :optional_subject, section = :section, 
        session = :session, institution = :institution,
        dob = :dob, gender = :gender, religion = :religion, blood_group = :blood_group, 
        nid = :nid, birth_cert = :birth_cert,
        phone = :phone, email = :email, present_addr = :present_addr, permanent_addr = :permanent_addr,
        father_name = :father_name, father_nid = :father_nid, father_phone = :father_phone, father_occ = :father_occ,
        mother_name = :mother_name, mother_nid = :mother_nid, mother_phone = :mother_phone, mother_occ = :mother_occ,
        guardian_name = :guardian_name, guardian_phone = :guardian_phone, guardian_rel = :guardian_rel,
        photo_url = :photo_url, color = :color, added_date = :added_date
        WHERE id = :id";
    $stmt = $db->prepare($sql);
    return $stmt->execute($data);
}

function pmdc_delete_student($id) {
    $db = pmdc_students_db();
    if (!$db) return false;
    $stmt = $db->prepare("DELETE FROM students WHERE id = ?");
    return $stmt->execute([$id]);
}

// Auto-init
pmdc_students_init();
