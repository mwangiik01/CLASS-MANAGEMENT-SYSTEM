<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/student.php";
       include "data/course.php";
       $students = getAllStudents($conn);
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
	.container {
	max-width: 1500px;
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
        if ($students != 0) {
     ?>
    
    <div class="container shadow p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <a href="student-add.php" class="btn btn-dark">Add New Student</a>
            <form action="student-search.php" class="d-flex" method="get">
                <input type="text" class="form-control me-2" name="searchKey" placeholder="Search...">
                <button class="btn btn-primary">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </form>
        </div>

        <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?= $_GET['error'] ?>
        </div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-info mt-3" role="alert">
            <?= $_GET['success'] ?>
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
                        <th scope="col">School_Email</th>
                        <th scope="col">Course</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; foreach ($students as $student) { $i++; ?>
                    <tr>
                        <th scope="row"><?= $i ?></th>
                        <td><?= $student['student_id'] ?></td>
                        <td>
                            <a href="student-view.php?student_id=<?= $student['student_id'] ?>" class="text-decoration-none">
                                <?= $student['fname'] ?>
                            </a>
                        </td>
                        <td><?= $student['lname'] ?></td>
                        <td><?= $student['email'] ?></td>
                        <td>
                            <?php
                                $c = '';
                                $course = str_split(trim($student['course_id']));
                                foreach ($course as $course_id) {
                                    $courses = getCourseById($course_id, $conn);
                                    if (is_array($courses) && isset($courses['course_name'])) {
                                        $c .= $courses['course_name'] . ', ';
                                    }
                                }
                                echo rtrim($c, ', ');
                            ?>
                        </td>
                        <td>
                            <a href="student-edit.php?student_id=<?= $student['student_id'] ?>" class="btn btn-warning">Edit</a>
							<a href="student-pass.php?student_id=<?= $student['student_id'] ?>" class="btn btn-warning">Password Reset</a>
                            <a href="student-delete.php?student_id=<?= $student['student_id'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
           </div>
         <?php }else{ ?>
             <div class="alert alert-info .w-450 m-5" 
                  role="alert">
                Empty!
              </div>
         <?php } ?>
     </div>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(3) a").addClass('active');
        });
    </script>

</body>
</html>
<?php 

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>