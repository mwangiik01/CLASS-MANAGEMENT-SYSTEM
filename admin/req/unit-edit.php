<?php
session_start();
if (isset($_SESSION['Admin_ID']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {

        if (isset($_POST['unit_name']) &&
            isset($_POST['unit_code']) &&
            isset($_POST['unit_id']) &&
            isset($_POST['semester_id']) &&
            isset($_POST['year_id'])) {
            
            include '../../DB_connection.php';

            $unit_name = trim($_POST['unit_name']);
            $unit_code = trim($_POST['unit_code']);
            $unit_id = trim($_POST['unit_id']);
            $semester_id = trim($_POST['semester_id']);
            $year_id = trim($_POST['year_id']);

            $data = 'unit_id='.$unit_id;

            if (empty($unit_id)) {
                $em = "Unit ID is required";
                header("Location: ../unit-edit.php?error=$em&$data");
                exit;
            } else if (empty($unit_name)) {
                $em = "Unit name is required";
                header("Location: ../unit-edit.php?error=$em&$data");
                exit;
            } else if (empty($unit_code)) {
                $em = "Unit code is required";
                header("Location: ../unit-edit.php?error=$em&$data");
                exit;
            } else if (empty($semester_id)) {
                $em = "Semester is required";
                header("Location: ../unit-edit.php?error=$em&$data");
                exit;
            } else if (empty($year_id)) {
                $em = "Year is required";
                header("Location: ../unit-edit.php?error=$em&$data");
                exit;
            } else {
                // Check if a unit with the same name or code already exists, excluding the current unit
                $sql_check = "SELECT * FROM units WHERE (unit_name = ? OR unit_code = ?) AND unit_id != ?";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->execute([$unit_name, $unit_code, $unit_id]);
                
                if ($stmt_check->rowCount() > 0) {
                    $em = "A unit with this name or code already exists";
                    header("Location: ../unit-edit.php?error=$em&$data");
                    exit;
                } else {
                    // Update the unit details including semester_id and year_id
                    $sql = "UPDATE units SET unit_name = ?, unit_code = ?, semester_id = ?, year_id = ? WHERE unit_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$unit_name, $unit_code, $semester_id, $year_id, $unit_id]);
                    
                    $sm = "Unit updated successfully";
                    header("Location: ../unit-edit.php?success=$sm&$data");
                    exit;
                }
            }
            
        } else {
            $em = "An error occurred";
            header("Location: ../unit.php?error=$em");
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
