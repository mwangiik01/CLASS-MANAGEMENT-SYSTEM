<?php 
session_start();
if (isset($_SESSION['lecturer_id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Lecturer') {
        include "../DB_connection.php";
        include "data/class.php";
        include "data/course.php"; // Include the correct data handler for courses
        include "data/lecturer.php";

        $lecturer_id = $_SESSION['lecturer_id'];
        $lecturer = getLecturerById($lecturer_id, $conn);

        // Get courses taught by the lecturer
        $courses = getCoursesByLecturerId($lecturer_id, $conn);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer - Courses</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.webp">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <?php if ($courses != 0) { ?>
            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Course Code</th>
                            <th scope="col">Course Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($courses as $course) { $i++; ?>
                        <tr>
                            <th scope="row"><?= $i ?></th>
                            <td><?= $course['course_code'] ?></td>
                            <td><?= $course['course_name'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="alert alert-info w-50 mx-auto mt-5" role="alert">
                No courses assigned to this lecturer.
            </div>
        <?php } ?>
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
