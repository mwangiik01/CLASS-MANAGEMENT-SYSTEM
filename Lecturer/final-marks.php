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

            // Fetch lecturer name
            $stmtLecturer = $conn->prepare("SELECT fname, lname FROM lecturers WHERE lecturer_id = ?");
            $stmtLecturer->execute([$_SESSION['lecturer_id']]);
            $lecturer = $stmtLecturer->fetch();

            // Fetch students enrolled in the current unit, along with their semester_id and year_id
            $stmtStudents = $conn->prepare("
                SELECT s.student_id, s.fname, s.mname, s.lname, sue.semester_id, sue.year_id
                FROM students s
                JOIN student_unit_enrollments sue ON s.student_id = sue.student_id
                WHERE sue.unit_id = ?
            ");
            $stmtStudents->execute([$unit_id]);
            $students = $stmtStudents->fetchAll(PDO::FETCH_ASSOC);

            // Fetch max marks for the unit
            $stmtMaxMarks = $conn->prepare("SELECT * FROM unit_max_marks WHERE unit_id = ?");
            $stmtMaxMarks->execute([$unit_id]);
            $maxMarks = $stmtMaxMarks->fetch(PDO::FETCH_ASSOC);

            // Fetch student scores for the unit
            $stmtScores = $conn->prepare("SELECT * FROM student_score WHERE unit_id = ?");
            $stmtScores->execute([$unit_id]);
            $studentScores = $stmtScores->fetchAll(PDO::FETCH_ASSOC);

            // Organize scores by student ID for easier access
            $scoresByStudentId = [];
            foreach ($studentScores as $score) {
                $scoresByStudentId[$score['student_id']] = $score;
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
    <title>Lecturer - Manage Marks</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.webp">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/js/font-awesome.min.js"></script>
    <style>
        .container {
            max-width: 1500px;
            margin: 20px auto;
            border: 2px solid red;
            border-radius: 10px;
            margin-top: 5px;
        }
    </style>

</head>
<body class="body-login">
<?php include "inc/navbar.php"; ?>
<div class="container shadow p-4 bg-white">
    <a href="students.php" class="btn btn-dark"> Back To Units</a>
    <h4>Unit: <?php echo htmlspecialchars($unit['unit_name']); ?></h4>
    <h4>Lecturer: <?php echo htmlspecialchars($lecturer['fname'] . ' ' . $lecturer['lname']); ?></h4>
        <!-- Error or success messages -->
        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger mt-3 n-table" role="alert">
                <?= $_GET['error'] ?>
            </div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-info mt-3 n-table" role="alert">
                <?= $_GET['success'] ?>
            </div>
        <?php } ?>
        <form action="./req/final-marks.php" method="POST">
    <input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>">
    <input type="hidden" name="semester_id" value="<?php echo $semester_id; ?>">
    <input type="hidden" name="year_id" value="<?php echo $year_id; ?>">

    <table class="table table-bordered table-hover table-responsive">
        <thead class="sticky-header">
            <tr>
                <th>Student Name</th>
                <th>Final CAT</th>
                <th>Final Assignment</th>
                <th>Final Lab</th>
                <th>Final Exam</th>
                <th>Total Marks</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['fname'] . ' ' . $student['mname'] . ' ' . $student['lname']); ?></td>
                    <input type="hidden" name="student_marks[<?php echo $student['student_id']; ?>][student_id]" value="<?php echo $student['student_id']; ?>" />

                    <td><input type="text" id="final-cat-<?php echo $student['student_id']; ?>" name="student_marks[<?php echo $student['student_id']; ?>][final_cat]" class="form-control" value="<?php echo $scoresByStudentId[$student['student_id']]['final_cat'] ?? ''; ?>" readonly></td>

                    <td><input type="text" id="final-assignment-<?php echo $student['student_id']; ?>" name="student_marks[<?php echo $student['student_id']; ?>][final_assignment]" class="form-control" value="<?php echo $scoresByStudentId[$student['student_id']]['final_assignment'] ?? ''; ?>" readonly></td>

                    <td><input type="text" id="final-lab-<?php echo $student['student_id']; ?>" name="student_marks[<?php echo $student['student_id']; ?>][final_lab]" class="form-control" value="<?php echo $scoresByStudentId[$student['student_id']]['final_lab'] ?? ''; ?>" readonly></td>

                    <td><input type="text" id="main-exam-<?php echo $student['student_id']; ?>" name="student_marks[<?php echo $student['student_id']; ?>][main_exam]" class="form-control" value="<?php echo $scoresByStudentId[$student['student_id']]['main_exam'] ?? ''; ?>" readonly></td>

                    <td><input type="text" id="total_score-<?php echo $student['student_id']; ?>" name="student_marks[<?php echo $student['student_id']; ?>][total_score]" class="form-control" value="<?php echo $scoresByStudentId[$student['student_id']]['total_score'] ?? ''; ?>" readonly></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Submit Results</button>
</form>


</div>

</body>
</html>
