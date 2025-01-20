<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])     &&
	isset($_GET['lecturer_id'])) {
	
	if ($_SESSION['role'] == 'Admin') {
	
	  include "../DB_connection.php";
      include "data/lecturer.php";
	  
	  $id = $_GET['lecturer_id'];
	  if (removeLecturer($id, $conn)) {
		$sm = "Successfully deleted!";
	    header("Location: lecturer.php?success=$sm");
	    exit;
	  }else {
		$em = "Unknown error occured";
	    header("Location: lecturer.php?error=$em");
	    exit;
	  }
	
  }else {
	header("Location: lecturer.php");
	exit;
  }
  }else {
	header("Location: lecturer.php");
	exit;
  }