<?php
session_start();
if (isset($_SESSION['Admin_ID']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/course.php"; // Assuming this file contains course functions

        // Get list of courses (Modify this query as needed)
        $query = "SELECT course_id, course_name FROM courses";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $courses = $stmt->fetchAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Shifting students
            $course_id = $_POST['course_id'];
            $new_semester_id = $_POST['new_semester_id'];
            $new_year_id = $_POST['new_year_id'];

            // Fetch the students for the course and current semester/year
            $query = "
                SELECT sc.student_id, s.fname, s.lname
                FROM students s
                JOIN student_course_enrollments sc ON s.student_id = sc.student_id
                WHERE s.year_id = :year_id AND s.semester_id = :semester_id AND sc.course_id = :course_id
            ";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                ':year_id' => $_POST['year_id'],
                ':semester_id' => $_POST['semester_id'],
                ':course_id' => $course_id
            ]);
            $students = $stmt->fetchAll();

            // Update each student's semester and year
            foreach ($students as $student) {
                $updateQuery = "
                    UPDATE students
                    SET semester_id = :new_semester_id, year_id = :new_year_id
                    WHERE student_id = :student_id
                ";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->execute([
                    ':new_semester_id' => $new_semester_id,
                    ':new_year_id' => $new_year_id,
                    ':student_id' => $student['student_id']
                ]);
            }

            echo "Students successfully shifted!";
            header("Location: semester-enrolment.php?success=Student Successfully shifted$sm&$data");
                    exit;
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Shift Semesters</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .container {
            max-width: 500px;
            margin: 20px auto;
            margin-top: 5px;
            border: 2px solid red;
            border-radius: 10px;
            border-style: solid;
            border-color: green;
            border-left-color: coral;
            border-right-color: cornflowerblue;
        }
    </style>

</head>
<body class="body-login">
    <?php 
        include "inc/navbar.php";
    ?>
    <div class="container shadow p-4 bg-white">
        <a href="index.php"
           class="btn btn-dark">Go Back</a>
        <h1 class="text-center">Shift Students Between Semesters/Years</h1>
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
        <form action="" method="POST">
            <div class="mb-3">
                <label for="course_id" class="form-label">Select Course</label>
                <select id="course_id" name="course_id" class="form-control" required>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?php echo $course['course_id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="semester_id" class="form-label">Select Semester</label>
                <select id="semester_id" name="semester_id" class="form-control" required>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="year_id" class="form-label">Select Year</label>
                <select id="year_id" name="year_id" class="form-control" required>
                    <option value="1">First Year</option>
                    <option value="2">Second Year</option>
                    <option value="3">Third Year</option>
                    <option value="4">Fourth Year</option>
                    <option value="5">Fifth Year</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="new_semester_id" class="form-label">Move to Semester</label>
                <select id="new_semester_id" name="new_semester_id" class="form-control" required>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="new_year_id" class="form-label">Move to Year</label>
                <select id="new_year_id" name="new_year_id" class="form-control" required>
                    <option value="1">First Year</option>
                    <option value="2">Second Year</option>
                    <option value="3">Third Year</option>
                    <option value="4">Fourth Year</option>
                    <option value="5">Fifth Year</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Shift Students</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
