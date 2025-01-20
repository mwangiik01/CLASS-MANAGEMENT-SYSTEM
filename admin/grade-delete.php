<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['Grade_ID'])) {

  if ($_SESSION['role'] == 'Admin') {
     include "../DB_connection.php";
     include "data/grade.php";

     $id = $_GET['Grade_ID'];
     if (removeGrade($id, $conn)) {
     	$sm = "Successfully deleted!";
        header("Location: grade.php?success=$sm");
        exit;
     }else {
        $em = "Unknown error occurred";
        header("Location: grade.php?error=$em");
        exit;
     }


  }else {
    header("Location: grade.php");
    exit;
  } 
}else {
	header("Location: grade.php");
	exit;
} 