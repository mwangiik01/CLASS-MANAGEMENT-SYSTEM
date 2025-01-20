<?php
session_start();
if (isset($_SESSION['Admin_ID']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {

        if (isset($_POST['unit']) &&
            isset($_POST['unit_code']) &&
            isset($_POST['semester_id']) && 
            isset($_POST['year_id']) &&     
            isset($_POST['course_id'])) {
            
            include '../../DB_connection.php';

            $unit = trim($_POST['unit']);
            $unit_code = trim($_POST['unit_code']);
            $semester_id = trim($_POST['semester_id']); 
            $year_id = trim($_POST['year_id']);       
            $course_id = trim($_POST['course_id']);

            // Check if fields are empty
            if (empty($unit)) {
                $em = "Unit name is required";
                header("Location: ../unit-add.php?error=$em");
                exit;
            } else if (empty($unit_code)) {
                $em = "Unit code is required";
                header("Location: ../unit-add.php?error=$em");
                exit;
            } else if (empty($semester_id)) {
                $em = "Semester is required";
                header("Location: ../unit-add.php?error=$em");
                exit;
            } else if (empty($year_id)) {
                $em = "Year is required";
                header("Location: ../unit-add.php?error=$em");
                exit;
            } else if (empty($course_id)) {
                $em = "Course is required";
                header("Location: ../unit-add.php?error=$em");
                exit;
            } else {

                // Check if the unit already exists
                $sql_check = "SELECT * FROM units WHERE unit_name = ? OR unit_code = ? AND course_id = ? AND semester_id = ? AND year_id = ?";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->execute([$unit, $unit_code, $course_id, $semester_id, $year_id]);
                
                if ($stmt_check->rowCount() > 0) {
                    $em = "The unit already exists in this course, semester, and year";
                    header("Location: ../unit-add.php?error=$em");
                    exit;
                } else {
                    // Insert the new unit
                    $sql = "INSERT INTO units (unit_name, unit_code, semester_id, year_id, course_id) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$unit, $unit_code, $semester_id, $year_id, $course_id]);
                    
                    $sm = "New unit created successfully";
                    header("Location: ../unit-add.php?success=$sm");
                    exit;
                }
            }
        } else {
            $em = "An error occurred. Please fill out all fields.";
            header("Location: ../unit-add.php?error=$em");
            exit;
        }
    } else {
        header("Location: ../../logout.php");
        exit;
    }
} else {
    header("Location: ../../logout.php");
    exit;
}
?>
