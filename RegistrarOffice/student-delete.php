<?php 
session_start();
if (isset($_SESSION['r_user_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['newstudent_id'])) {

  if ($_SESSION['role'] == 'Registrar Office') {
     include "../DB_connection.php";
     include "data/student.php";

     $id = $_GET['newstudent_id'];
     if (removeStudent($id, $conn)) {
     	$sm = "Successfully deleted!";
        header("Location: student-add.php?success=$sm");
        exit;
     }else {
        $em = "Unknown error occurred";
        header("Location: student-add.php?error=$em");
        exit;
     }


  }else {
    header("Location: student-add.php");
    exit;
  } 
}else {
	header("Location: student-add.php");
	exit;
} 