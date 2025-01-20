<?php  
session_start();
if (isset($_SESSION['r_user_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Registrar Office') {
        include "../DB_connection.php";
        include "data/student-add.php";
        $students = getAllstudentregistration($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registra Verify Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .container {
            max-width: 1500px;
        }
       
    </style>    
</head>
<body class="body-login">
    <?php 
        include "inc/navbar.php";
    ?>
    <div class="container shadow p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center">
            
        <form action="student-add.php" method="POST">
            <button type="submit" name="update" class="btn btn-primary">Verify All students</button>
        </form>
            <form action="lecturer-search.php" class="d-flex" method="get">
                <input type="text" class="form-control me-2" name="searchKey" placeholder="Search...">
                <button class="btn btn-primary">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </form>
        </div>

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

        <!-- Student Table -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">School Email</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Registration Number</th>
                        <th scope="col">Course</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($students && count($students) > 0) { 
                        $i = 0; 
                        foreach ($students as $student) { 
                            $i++; ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td><?= $student['newstudent_id'] ?></td>
                                <td>
                                    <a href="student-view.php?newstudent_id=<?= $student['newstudent_id'] ?>">
                                        <?= htmlspecialchars($student['fname']) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($student['lname']) ?></td>
                                <td><?= htmlspecialchars($student['email']) ?></td>
                                <td><?= htmlspecialchars($student['phone_number']) ?></td>
                                <td><?= htmlspecialchars($student['registration_number']) ?></td>
                                <td><?php
                                    // Fetch course name using the course_id from the courses table
                                    $stmt = $conn->prepare("SELECT course_name FROM courses WHERE course_id = ?");
                                    $stmt->execute([$student['course_id']]);
                                    $course = $stmt->fetch(PDO::FETCH_ASSOC);

                                    if ($course) {
                                        echo htmlspecialchars($course['course_name']);
                                    } else {
                                        echo "Course not found";
                                    }
                                    ?></td>
                                <td>
                                    <a href="student-edit.php?newstudent_id=<?= $student['newstudent_id'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="student-delete.php?newstudent_id=<?= $student['newstudent_id'] ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php } 
                    } else { ?>
                        <tr>
                            <td colspan="9" class="text-center">No registered students available.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>    
    <script>
        $(document).ready(function() {
            $("#navLinks li:nth-child(3) a").addClass('active');
        });
    </script>
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
