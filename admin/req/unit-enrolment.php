<?php
session_start();
if (isset($_SESSION['Admin_ID']) && $_SESSION['role'] === 'Admin') {
    include "../../DB_connection.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $unit_id = $_POST['unit_id'] ?? null;
        $lecturer_id = $_POST['lecturer_id'] ?? null;
        $course_id = $_POST['course_id'] ?? null;
        $semester_id = $_POST['semester_id'] ?? null;
        $year_id = $_POST['year_id'] ?? null;

        if (!$unit_id || !$lecturer_id || !$course_id || !$semester_id || !$year_id) {
            header("Location: ../unit-enrolment.php?error=All fields are required&unit_id=$unit_id");
            exit;
        }

        try {
            // Start transaction
            $conn->beginTransaction();

            // Assign the lecturer to the unit in the lecturer_unit_assignments table
            $stmt_lecturer = $conn->prepare("
                INSERT INTO lecturer_unit_assignments (lecturer_id, unit_id, assignment_date)
                VALUES (?, ?, NOW())
                ON DUPLICATE KEY UPDATE lecturer_id = VALUES(lecturer_id)
            ");
            $stmt_lecturer->execute([$lecturer_id, $unit_id]);

            // Fetch all students enrolled in the selected course
            $stmt_students = $conn->prepare("SELECT student_id FROM students WHERE course_id = ?");
            $stmt_students->execute([$course_id]);
            $students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

            if (!$students) {
                throw new Exception("No students found for the selected course.");
            }

            // Enroll each student into the unit with semester_id and year_id
            $stmt_enroll_students = $conn->prepare("
                INSERT INTO student_unit_enrollments (student_id, unit_id, enrollment_date, semester_id, year_id, enrollment_status)
                VALUES (?, ?, NOW(), ?, ?, 'enrolled')
            ");
            foreach ($students as $student) {
                $stmt_enroll_students->execute([
                    $student['student_id'], 
                    $unit_id, 
                    $semester_id, 
                    $year_id
                ]);
            }

            // Commit the transaction
            $conn->commit();
            header("Location: ../unit-enrolment.php?success=Enrollment successful&unit_id=$unit_id");
            exit;

        } catch (Exception $e) {
            $conn->rollBack();
            header("Location: ../unit-enrolment.php?error=" . $e->getMessage() . "&unit_id=$unit_id");
            exit;
        }
    } else {
        header("Location: ../unit-enrolment.php?error=Invalid request");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
