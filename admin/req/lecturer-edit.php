<?php
session_start();

if (isset($_SESSION['Admin_ID']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include '../../DB_connection.php';
            include "../data/lecturer.php"; 

            // Retrieve and sanitize inputs
            $lecturer_id = htmlspecialchars(trim($_POST['lecturer_id']));
            $fname = htmlspecialchars(trim($_POST['fname']));
            $mname = htmlspecialchars(trim($_POST['mname']));
            $lname = htmlspecialchars(trim($_POST['lname']));
            $password = htmlspecialchars(trim($_POST['pass']));
            $email = htmlspecialchars(trim($_POST['email']));
            $email = htmlspecialchars(trim($_POST['email']));
            $phone_number = htmlspecialchars(trim($_POST['phone_number']));
            $address = htmlspecialchars(trim($_POST['address']));
            $employee_number = htmlspecialchars(trim($_POST['employee_number']));
            $qualification = htmlspecialchars(trim($_POST['qualification']));
            $gender = htmlspecialchars(trim($_POST['gender']));
            $date_of_birth = htmlspecialchars(trim($_POST['date_of_birth']));

            $data = "fname=$fname&mname=$mname&lname=$lname&email=$email&phone_number=$phone_number&address=$address&employee_number=$employee_number&qualification=$qualification&gender=$gender&date_of_birth=$date_of_birth";
            
            if (empty($fname)) {
                $em = "First name is required";
                header("Location: ../lecturer-edit.php?lecturer_id=$lecturer_id&error=$em&$data");
                exit;
            } else if (empty($lname)) {
                $em = "Last name is required";
                header("Location: ../lecturer-edit.php?lecturer_id=$lecturer_id&error=$em&$data");
                exit;
            } else if (empty($email)) {
                $em = "Email is required";
                header("Location: ../lecturer-edit.php?lecturer_id=$lecturer_id&error=$em&$data");
                exit;
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $em = "Invalid email format";
                header("Location: ../lecturer-edit.php?lecturer_id=$lecturer_id&error=$em&$data");
                exit;
            } else if (empty($password)) {
                $em = "Password is required";
                header("Location: ../lecturer-edit.php?lecturer_id=$lecturer_id&error=$em&$data");
                exit;
            }

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Update lecturer details
            $sql = "UPDATE lecturers SET fname=?, mname=?, lname=?, pass=?, email=?, email=?, phone_number=?, address=?, employee_number=?, qualification=?, gender=?, date_of_birth=? WHERE lecturer_id=?";
            $stmt = $conn->prepare($sql);
            
            if ($stmt->execute([$fname, $mname, $lname, $hashed_password, $email, $email, $phone_number, $address, $employee_number, $qualification, $gender, $date_of_birth, $lecturer_id])) {
                $sm = "Lecturer details updated successfully.";
                header("Location: ../lecturer-edit.php?lecturer_id=$lecturer_id&success=$sm");
                exit;
            } else {
                $em = "Failed to update lecturer details.";
                header("Location: ../lecturer-edit.php?lecturer_id=$lecturer_id&error=$em&$data");
                exit;
            }
        } else {
            header("Location: ../lecturer-edit.php?error=Please fill in all required fields.");
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
