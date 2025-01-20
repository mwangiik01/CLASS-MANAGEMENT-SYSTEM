<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role']) &&
    isset($_GET['unit_id'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/unit.php";

       $id = $_GET['unit_id'];
       if (removeUnit($id, $conn)) {
           $sm = "Successfully deleted!";
           header("Location: unit.php?success=$sm");
           exit;
       } else {
           $em = "Unknown error occurred";
           header("Location: unit.php?error=$em");
           exit;
       }

    } else {
        header("Location: unit.php");
        exit;
    }
} else {
    header("Location: unit.php");
    exit;
} 
?>
