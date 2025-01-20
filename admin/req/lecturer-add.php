<?php
session_start();
if (isset($_SESSION['Admin_ID']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
            isset($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['pass'], 
                  $_POST['personal_email'], $_POST['phone_number'], $_POST['address'], 
                  $_POST['employee_number'], $_POST['qualification'], $_POST['gender'], 
                  $_POST['date_of_birth'])
        ) {
            include '../../DB_connection.php';
            include "../data/lecturer.php";

            // Sanitize inputs
            $fname = trim($_POST['fname']);
            $lname = trim($_POST['lname']);
            $email = trim($_POST['email']);
            $personal_email = trim($_POST['personal_email']);
            $pass = trim($_POST['pass']);
            $phone_number = trim($_POST['phone_number']);
            $address = trim($_POST['address']);
            $employee_number = trim($_POST['employee_number']);
            $qualification = trim($_POST['qualification']);
            $gender = trim($_POST['gender']);
            $date_of_birth = trim($_POST['date_of_birth']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $em = "Invalid email format!";
                header("Location: ../lecturer-add.php?error=$em");
                exit;
            }

            $pass = password_hash($pass, PASSWORD_DEFAULT);

            try {
                $sql = "INSERT INTO lecturers (fname, lname, email, personal_email, password, phone_number, address, 
                                               employee_number, qualification, gender, date_of_birth) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$fname, $lname, $email, $personal_email, $pass, $phone_number, $address, $employee_number, $qualification, $gender, $date_of_birth]);

                $sm = "New Lecturer registered successfully!";
                header("Location: ../lecturer-add.php?success=$sm");
                exit;
            } catch (PDOException $e) {
                $em = "Database error: " . $e->getMessage();
                header("Location: ../lecturer-add.php?error=$em");
                exit;
            }
        } else {
            $em = "All fields are required!";
            header("Location: ../lecturer-add.php?error=$em");
            exit;
        }
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
