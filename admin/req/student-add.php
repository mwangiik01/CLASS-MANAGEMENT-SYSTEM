<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        
        if (isset($_POST['email']) && isset($_POST['password'])) {
            include '../../DB_connection.php';
            
            $email = $_POST['email'];
            $password = $_POST['password'];

            $data = '&email='.$email.'&password='.$password;

            if (empty($password)) {
                $em  = "Password is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (empty($email)) {
                $em = "Email is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else {
                // Hashing the password
                $password = password_hash($password, PASSWORD_DEFAULT);

                $sql  = "INSERT INTO newstudents(password, email) VALUES(?, ?)";
                $stmt = $conn->prepare($sql);
                // Corrected statement to pass parameters as an array
                $stmt->execute([$password, $email]);

                $sm = "New student registered successfully";
                header("Location: ../student-add.php?success=$sm");
                exit;
            }
        } else {
            $em = "An error occurred";
            header("Location: ../student-add.php?error=$em");
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
