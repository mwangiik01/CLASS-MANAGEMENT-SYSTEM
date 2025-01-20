<?php
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])) {
		
		if ($_SESSION['role'] == 'Admin') {


if (isset($_POST['admin_pass']) &&
    isset($_POST['new_pass']) &&
    isset($_POST['c_new_pass']) &&
	isset($_POST['Lecturer_ID'])) {
	
    include '../../DB_connection.php';	
	include "../data/lecturer.php";
	include "../data/admin.php";
	
	$admin_pass = $_POST['admin_pass'];
	$new_pass = $_POST['new_pass'];
    $c_new_pass = $_POST['c_new_pass'];
	
	$Lecturer_ID = $_POST['Lecturer_ID'];
	$id = $_SESSION['Admin_ID'];
		
	
	$data = 'Lecturer_ID='.$Lecturer_ID.'#change_password';
	
	if (empty($admin_pass)) {
		$em = "Admin Password is required";
		header("Location: ../lecturer-edit.php?perror=$em&$data");
		exit;
	}else if (empty($new_pass)) {
		$em = "New Password is required";
		header("Location: ../lecturer-edit.php?perror=$em&$data");
		exit;
	}else if (empty($c_new_pass)) {
		$em = "Confirmation Password is required";
		header("Location: ../lecturer-edit.php?perror=$em&$data");
		exit;
	}else if ($new_pass !== $c_new_pass) {
		$em = "New password and confirm password does not match";
		header("Location: ../lecturer-edit.php?perror=$em&$data");
		exit;
	}else if (!adminPasswordVerify($admin_pass, $conn, $id)) {
		$em = "Incorrect admin password";
		header("Location: ../lecturer-edit.php?perror=$em&$data");
		exit;
	}else {
		 // hashing the password
        $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
		
		$sql = "UPDATE lecturers SET
                password = ?
                WHERE Lecturer_ID=?";
				
		$stmt = $conn->prepare($sql);
        $stmt->execute([$new_pass, $Lecturer_ID]);
		
		$sm = "The password has been changed successfully!";
        header("Location: ../lecturer-edit.php?psuccess=$sm&$data");
        exit;
	}
	
    }else {
	  $em = "An error occurred";
	  header("Location: ../lecturer-edit.php?error=$em");
	  exit;
    }	
     }else {
    header("Location: ../../logout.php");
    exit;
  } 
}else {
	header("Location: ../../logout.php");
	exit;
}