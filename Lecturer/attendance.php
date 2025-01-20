<?php
session_start();
if (isset($_SESSION['lecturer_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Lecturer') {
        include "../DB_connection.php";

        if (isset($_GET['unit_id'])) {
            $unit_id = intval($_GET['unit_id']);

            // Fetch unit details
            $stmt = $conn->prepare("SELECT * FROM units WHERE unit_id = :unit_id");
            $stmt->bindParam(':unit_id', $unit_id, PDO::PARAM_INT);
            $stmt->execute();
            $unit = $stmt->fetch(PDO::FETCH_ASSOC);

            // Fetch students enrolled in the current unit
            $stmtStudents = $conn->prepare("
                SELECT s.student_id, s.fname, s.mname, s.lname 
                FROM students s
                JOIN student_unit_enrollments sue ON s.student_id = sue.student_id
                WHERE sue.unit_id = ?
            ");
            $stmtStudents->execute([$unit_id]);
            $students = $stmtStudents->fetchAll(PDO::FETCH_ASSOC);

            // Fetch attendance records
            $stmtAttendance = $conn->prepare("
                SELECT * FROM attendance 
                WHERE unit_id = ? AND lesson_number <= 14
            ");
            $stmtAttendance->execute([$unit_id]);
            $attendanceRecords = $stmtAttendance->fetchAll(PDO::FETCH_ASSOC);

            // Organize attendance by student ID and lesson
            $attendanceByStudent = [];
            foreach ($attendanceRecords as $record) {
                $attendanceByStudent[$record['student_id']][$record['lesson_number']] = $record['status'];
            }
        } else {
            echo "No unit selected.";
            exit;
        }
    } else {
        echo "Unauthorized access.";
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer - Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body class="body-login">
<?php include "inc/navbar.php"; ?>
<div class="container shadow p-4 bg-white">
    <h4>Unit: <?php echo htmlspecialchars($unit['unit_name']); ?></h4>
    <h5>Mark Attendance for 14 Lessons</h5>

    <form action="./req/save_attendance.php" method="POST">
        <input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>">
        <table class="table table-bordered table-hover table-responsive">
            <thead class="table-dark">
                <tr>
                    <th>Student Name</th>
                    <?php for ($i = 1; $i <= 14; $i++) { ?>
                        <th>Lesson <?php echo $i; ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student) { 
                    $studentId = $student['student_id'];
                ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($student['fname'] . ' ' . $student['lname']); ?>
                            <input type="hidden" name="student_ids[]" value="<?php echo $studentId; ?>">
                        </td>
                        <?php for ($lesson = 1; $lesson <= 14; $lesson++) { 
                            $status = $attendanceByStudent[$studentId][$lesson] ?? '';
                        ?>
                            <td>
                                <select name="attendance[<?php echo $studentId; ?>][<?php echo $lesson; ?>]" class="form-select">
                                    <option value="" <?php if ($status === '') echo 'selected'; ?>>--</option>
                                    <option value="Present" <?php if ($status === 'Present') echo 'selected'; ?>>Present</option>
                                    <option value="Absent" <?php if ($status === 'Absent') echo 'selected'; ?>>Absent</option>
                                </select>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Save Attendance</button>
    </form>
</div>
</body>
</html>
