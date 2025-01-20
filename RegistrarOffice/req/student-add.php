<?php
session_start();
if (isset($_SESSION['r_user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Registrar Office') {
    include '../DB_connection.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch student data
        $stmt = $conn->prepare("SELECT * FROM studentregistration WHERE id = ?");
        $stmt->execute([$id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            // Move to 'students' table
            $sql = "INSERT INTO students (registration_number, fname, mname, lname, gender, date_of_birth, course_name)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql);
            $stmt_insert->execute([
                $student['registration_number'], $student['fname'], $student['mname'], $student['lname'],
                $student['gender'], $student['date_of_birth'], $student['course_name']
            ]);

            // Remove from 'studentregistration'
            $stmt_delete = $conn->prepare("DELETE FROM studentregistration WHERE id = ?");
            $stmt_delete->execute([$id]);

            header("Location: ../student-add.php?success=Student verified and moved to main records.");
            exit;
        } else {
            header("Location: ../student-add.php?error=Student not found.");
            exit;
        }
    } else {
        header("Location: ../student-add.php?error=Invalid request.");
        exit;
    }
} else {
    header("Location: .././login.php");
    exit;
}
?>
