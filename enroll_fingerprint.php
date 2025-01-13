<?php
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'] ?? null;
    $fingerprint_id = $_POST['fingerprint_id'] ?? null;

    if ($student_id && $fingerprint_id) {
        try {
            $stmt = $conn->prepare("INSERT INTO fingerprints (student_id, fingerprint_id) 
                                    VALUES (:student_id, :fingerprint_id)
                                    ON DUPLICATE KEY UPDATE fingerprint_id = :fingerprint_id");
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':fingerprint_id', $fingerprint_id);
            $stmt->execute();

            echo "Fingerprint registered successfully";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid input data";
    }
} else {
    echo "Invalid request method";
}
?>
