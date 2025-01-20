<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
        

if (isset($_POST['fname'])      &&
    isset($_POST['lname'])      &&
    isset($_POST['mname'])   &&
	isset($_POST['student_id']) &&
	isset($_POST['personal_personal_email']) &&
	isset($_POST['phone_number']) &&
	isset($_POST['course']) &&
    isset($_POST['date_of_birth']) &&
	isset($_POST['gender'])        &&
	isset($_POST['parent_fname'])  &&
	isset($_POST['parent_lname'])  &&
	isset($_POST['parent_phone_number']) &&
	isset($_POST['grade'])) {
    
    include '../../DB_connection.php';
    include "../data/student.php";

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mname = $_POST['mname'];
	
	$personal_email = $_POST['personal_email'];
	$phone_number = $_POST['phone_number'];
	$registration_number = $_POST['registration_number'];
	$course = $_POST['course'];
	$date_of_birth = $_POST['date_of_birth'];
	$gender = $_POST['gender'];
	$parent_fname = $_POST['parent_fname'];
	$parent_lname = $_POST['parent_lname'];
	$parent_phone_number = $_POST['parent_phone_number'];

    $student_id = $_POST['student_id'];
    

    $data = 'student_id='.$student_id;

    if (empty($fname)) {
        $em  = "First name is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($lname)) {
        $em  = "Last name is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($personal_email)) {
		$em = "personal_email is required";
		header("Location: ../student-edit.php?error=$em&$data");
		exit;
	}else if (empty($address)) {
        $em  = "Address is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($phone_number)) {
		$em = "phone_number is required";
		header("Location: ../student-edit.php?error=$em&$data");
		exit;
	}else if (empty($course)) {
		$em = "course is required";
		header("Location: ../student-edit.php?error=$em&$data");
		exit;
	}else if (empty($date_of_birth)) {
        $em  = "Date of birth is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($gender)) {
        $em  = "Gender is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;

    }else {
        $sql = "UPDATE students SET
                mname = ?, fname=?, lname=?,personal_email=? ,phone_number=? ,registration_number=? ,course=?, gender = ?, date_of_birth=?, parent_fname=?, parent_lname=?, parent_phone_number=?, 
                WHERE student_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$mname,$fname, $lname, $personal_email, $phone_number, $registration_number, $course, $gender, $date_of_birth, $parent_fname, $parent_lname, $parent_phone_number, $student_id]);
        $sm = "successfully updated!";
        header("Location: ../student-edit.php?success=$sm&$data");
        exit;
    }
    
  }else {
    $em = "An error occurred";
    header("Location: ../student-edit.php?error=$em");
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