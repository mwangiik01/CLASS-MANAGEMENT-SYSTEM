<?php
session_start();

if (isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['role'])) {
    include "../DB_connection.php";
    
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $role = $_POST['role'];
    
    if (empty($email)) {
        $em = "Email is required";
        header("Location: ../newlogin.php?error=$em");
        exit;
    } else if (empty($pass)) {
        $em = "Password is required";
        header("Location: ../newlogin.php?error=$em");
        exit;
    } else if (empty($role)) {
        $em = "Role is required";
        header("Location: ../newlogin.php?error=$em");
        exit;
    } else {
        if ($role == 'newstudent') {
            // Check for new student login
            $sql = "SELECT * FROM newstudents WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);

            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch();
                $dbEmail = $user['email'];
                $password = $user['password'];

                if ($dbEmail === $email) {
                    if (password_verify($pass, $password)) {
                        $_SESSION['role'] = "New Student";
                        $_SESSION['student_id'] = $user['student_id'];
                        header("Location: ../newstudent/student-add.php");
                        exit;
                    } else {
                        $em = "Incorrect email or password";
                        header("Location: ../newlogin.php?error=$em");
                        exit;
                    }
                }
            } else {
                $em = "No account found with this email";
                header("Location: ../newlogin.php?error=$em");
                exit;
            }
        } else if ($role == 'newlecturer') {
            // Check for new lecturer login
            $sql = "SELECT * FROM newlecturers WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);

            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch();
                $dbEmail = $user['email'];
                $password = $user['password'];

                if ($dbEmail === $email) {
                    if (password_verify($pass, $password)) {
                        $_SESSION['role'] = "New Lecturer";
                        $_SESSION['lecturer_id'] = $user['lecturer_id'];
                        header("Location: ../newlecturer/lecturer-dashboard.php");
                        exit;
                    } else {
                        $em = "Incorrect email or password";
                        header("Location: ../newlogin.php?error=$em");
                        exit;
                    }
                }
            } else {
                $em = "No account found with this email";
                header("Location: ../newlogin.php?error=$em");
                exit;
            }
        } else {
            $em = "Invalid role";
            header("Location: ../newlogin.php?error=$em");
            exit;
        }
    }
} else {
    header("Location: ../newlogin.php");
    exit;
}
