<?php
session_start();
if (isset($_SESSION['lecturer_id']) && $_SESSION['role'] === 'Lecturer') {
    include "../DB_connection.php";

    if ($_POST) {
        $unit_id = intval($_POST['unit_id']);
        $attendanceData = $_POST['attendance'];

        foreach ($attendanceData as $student_id => $lessons) {
            foreach ($lessons as $lesson_number => $status) {
                // Check if the attendance record exists
                $stmtCheck = $conn->prepare("
                    SELECT id FROM attendance 
                    WHERE unit_id = ? AND student_id = ? AND lesson_number = ?
                ");
                $stmtCheck->execute([$unit_id, $student_id, $lesson_number]);
                $record = $stmtCheck->fetch();

                if ($record) {
                    // Update existing record
                    $stmtUpdate = $conn->prepare("
                        UPDATE attendance 
                        SET status = ? 
                        WHERE id = ?
                    ");
                    $stmtUpdate->execute([$status, $record['id']]);
                } else {
                    // Insert new record
                    $stmtInsert = $conn->prepare("
                        INSERT INTO attendance (unit_id, student_id, lesson_number, status) 
                        VALUES (?, ?, ?, ?)
                    ");
                    $stmtInsert->execute([$unit_id, $student_id, $lesson_number, $status]);
                }
            }
        }

        header("Location: ../attendance.php?unit_id=$unit_id&success=Attendance+saved");
        exit;
    }
} else {
    echo "Unauthorized access.";
    exit;
}
?>
