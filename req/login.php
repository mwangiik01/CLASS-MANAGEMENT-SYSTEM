<?php
session_start();


if (isset($_POST['email']) &&
    isset($_POST['pass']) &&
	isset($_POST['role'])) {
	
    include "../DB_connection.php";
	
    $email = $_POST['email'];
	$pass = $_POST['pass'];
	$role = $_POST['role'];
	
	if (empty($email)) {
		$em = "email is required";
		header("Location: ../login.php?error=$em");
		exit;
	}else if (empty($pass)) {
		$em = "Password is required";
		header("Location: ../login.php?error=$em");
		exit;
	}else if (empty($role)) {
		$em = "An error occured";
		header("Location: ../login.php?error=$em");
		exit;
	}else {
		
		if($role == '1'){
			$sql = "SELECT * FROM admin
           			WHERE email = ?";
			$role = "Admin";
		}else if($role == '2'){
			$sql = "SELECT * FROM lecturers
           			WHERE email = ?";
			$role = "Lecturer";
		}else if($role == '3'){
			$sql = "SELECT * FROM newstudents
           			WHERE email = ?";
			$role = "newstudent";
		}else if($role == '4'){
			$sql = "SELECT * FROM students
           			WHERE email = ?";
			$role = "Student";
		}else if($role == '5'){
        	$sql = "SELECT * FROM registrar_office 
        	        WHERE email = ?";
        	$role = "Registrar Office";
        }
		
		$stmt = $conn->prepare($sql);
		$stmt->execute([$email]);
		
		if($stmt->rowCount() ==1) {
		   $user = $stmt->fetch();
		   $email = $user['email'];
		   $password = $user['password'];
		   $email = $user['email'];
		   
		   if ($email === $email) {
			   if (password_verify($pass, $password)) {
				   
				   $_SESSION['role'] = $role;
				   if ($role == 'Admin') {
					   $id = $user['Admin_ID'];
					   $_SESSION['Admin_ID'] = $id;
					   header("Location: ../admin/index.php");
		               exit;
				   }else if ($role == 'newstudent') {
                        $id = $user['newstudents_id'];
                        $_SESSION['newstudents_id'] = $id;
                        header("Location: ../newstudents/student-add.php");
                        exit;
				   }else if ($role == 'Student') {
                        $id = $user['student_id'];
                        $_SESSION['student_id'] = $id;
                        header("Location: ../Student/index.php");
                        exit;
                    }else if ($role == 'Registrar Office') {
                        $id = $user['r_user_id'];
                        $_SESSION['r_user_id'] = $id;
                        header("Location: ../RegistrarOffice/index.php");
                        exit;
                    }else if($role == 'Lecturer'){
                    	$id = $user['lecturer_id'];
                        $_SESSION['lecturer_id'] = $id;
                        header("Location: ../Lecturer/index.php");
                        exit;
					}
               }else {
			      $em = "Incorrect email or Password";
		          header("Location: ../login.php?error=$em");
		          exit;
		       }
			   
		   }else {
			  $em = "Incorrect email or Password";
		      header("Location: ../login.php?error=$em");
		      exit;
		   }  
		}else{
			$em = "Incorrect email or Password";
		    header("Location: ../login.php?error=$em");
		    exit;
		}
	  }
	}else{
		header("Location: ../login.php");
		exit;
	}