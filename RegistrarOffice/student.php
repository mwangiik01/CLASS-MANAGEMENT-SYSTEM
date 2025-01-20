<?php 
session_start();
if (isset($_SESSION['r_user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Registrar Office') {
        include "../DB_connection.php";
        include "data/student.php";

        // Fetch students using the backend function
        $students = getAllstudents($conn);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Students</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        tr.clickable-row:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
        .container{
          max-width: 1500px;
        }
    </style>
</head>
<body class="body-login">
    <?php 
        include "inc/navbar.php";
        if (!empty($students)) {
    ?>
    <div class="container shadow p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <a href="student-add.php" class="btn btn-primary">Verify New Students</a>
            <form action="student-search.php" class="d-flex" method="get">
                <input type="text" class="form-control me-2" name="searchKey" placeholder="Search...">
                <button class="btn btn-primary">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </form>
        </div>
        
        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-info mt-3" role="alert">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php } ?>

        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Student Email</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Registration Number</th>
                        <th scope="col">Course</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; foreach ($students as $student): $i++; ?>
                    <tr class="clickable-row" data-href="student-view.php?student_id=<?= $student['student_id'] ?>">
                        <th scope="row"><?= $i ?></th>
                        <td><?= htmlspecialchars($student['student_id']) ?></td>
                        <td><?= htmlspecialchars($student['fname']) ?></td>
                        <td><?= htmlspecialchars($student['lname']) ?></td>
                        <td><?= htmlspecialchars($student['email']) ?></td>
                        <td><?= htmlspecialchars($student['phone_number']) ?></td>
                        <td><?= htmlspecialchars($student['registration_number']) ?></td>
                        <td><?= htmlspecialchars($student['course_name'] ?? 'Not Assigned') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Make rows clickable
        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', function() {
                window.location.href = this.dataset.href;
            });
        });
    </script>
</body>
</html>
<?php 
    } else { ?>
        <div class="alert alert-info text-center mt-5" role="alert">
            No students found.
        </div>
<?php 
    }
} else {
    header("Location: ../login.php");
    exit;
} 
?>
