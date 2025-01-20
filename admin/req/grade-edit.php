<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
    	

if (isset($_POST['grade_code']) &&
    isset($_POST['grade']) &&
    isset($_POST['Grade_ID'])) {
    
    include '../../DB_connection.php';

    $grade_code = $_POST['grade_code'];
    $grade = $_POST['grade'];
    $Grade_ID = $_POST['Grade_ID'];
   
    $data = 'grade_code='.$grade_code.'&grade='.$grade.'&Grade_ID='.$Grade_ID;

    if (empty($grade_code)) {
        $em  = "Grade Code is required";
        header("Location: ../grade-edit.php?error=$em&$data");
        exit;
    }else if (empty($grade)) {
        $em  = "Grade is required";
        header("Location: ../grade-edit.php?error=$em&$data");
        exit;
    }else {

        $sql  = "UPDATE grades SET grade=?, grade_code=?
                 WHERE Grade_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$grade, $grade_code, $Grade_ID]);
        $sm = "Grade updated successfully";
        header("Location: ../grade-edit.php?success=$sm&$data");
        exit;
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../grade.php?error=$em");
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