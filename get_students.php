<?php
include 'db_connection.php';

$sql = "SELECT id, CONCAT(fname, ' ', lname) AS name FROM students";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
?>
