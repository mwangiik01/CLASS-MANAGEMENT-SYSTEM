<?php
// Database configuration
$host = 'localhost';
$dbname = 'cms_database';
$username = 'root';
$password = '';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Placeholder function to capture fingerprint data
function captureFingerprint() {
    // Replace this with the actual SDK method for capturing fingerprints
    return "unique_fingerprint_id"; // Simulated fingerprint ID
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fingerprintId = captureFingerprint(); // Capture fingerprint from scanner

    if ($fingerprintId) {
        try {
            // Find the student associated with this fingerprint
            $stmt = $pdo->prepare("SELECT id FROM students WHERE fingerprint_id = :fingerprint_id");
            $stmt->bindParam(':fingerprint_id', $fingerprintId, PDO::PARAM_STR);
            $stmt->execute();

            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($student) {
                $studentId = $student['id'];
                $date = date('Y-m-d'); // Current date

                // Check if attendance record already exists for today
                $attendanceCheck = $pdo->prepare("SELECT id FROM attendance WHERE student_id = :student_id AND date = :date");
                $attendanceCheck->execute([':student_id' => $studentId, ':date' => $date]);
                $existingRecord = $attendanceCheck->fetch(PDO::FETCH_ASSOC);

                if ($existingRecord) {
                    echo "Attendance already marked for today.";
                } else {
                    // Mark attendance as present
                    $insertStmt = $pdo->prepare("INSERT INTO attendance (student_id, date, status) VALUES (:student_id, :date, 'present')");
                    $insertStmt->execute([':student_id' => $studentId, ':date' => $date]);
                    echo "Attendance marked as present.";
                }
            } else {
                echo "Student not found.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Fingerprint capture failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fingerprint Attendance</title>
</head>
<body>
    <h1>Fingerprint Attendance System</h1>
    <form method="POST">
        <button type="submit">Mark Attendance</button>
    </form>
</body>
</html>
