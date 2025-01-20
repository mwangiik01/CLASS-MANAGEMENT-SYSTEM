<?php
require '../../DB_connection.php'; // Include your database connection

if (isset($_GET['unit_id'])) {
    $unitId = $_GET['unit_id'];

    // Query to fetch students for the given unit from the enrolments table
    $query = "
        SELECT s.student_id, s.student_name
        FROM students s
        JOIN enrolments e ON s.student_id = e.student_id
        WHERE e.unit_id = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute([$unitId]);
    $students = $stmt->fetchAll();

    // Return JSON response
    if (count($students) > 0) {
        echo json_encode($students);
    } else {
        echo json_encode([]);
    }
}
?>
