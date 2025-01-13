<?php

$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "electrical department";  // Replace with your actual database name

try {
    // Creating a PDO connection
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    
    // Set the PDO error mode to exception for better error handling
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optional: You can print a success message (for debugging purposes)
    // echo "Connected successfully"; 
} catch(PDOException $e) {
    // If the connection fails, print the error message
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
