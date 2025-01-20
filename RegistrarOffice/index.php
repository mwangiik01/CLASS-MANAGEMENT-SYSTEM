<?php 
session_start();
if (isset($_SESSION['r_user_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Registrar Office') {
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registrar Office - Home</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style>
         .container{
            border: 0px;
        }
    </style>


</head>
<body class="body-login">
  <?php
	   include "inc/navbar.php";
	?>

  <div class="container mt-5">
        <div class="container text-center">
          <div class="row row-cols-5">
          <a href="lecturer.php"
              class="col btn btn-dark m-2 py-3">
          <i class="fa fa-user-md fs-1" aria-hidden="true">
          </i><br>
              View Lecturers
          </a>

          <a href="lecturer-add.php" class="col btn btn-dark m-2 py-3">
          <i class="fa fa-user-md fs-1" aria-hidden="true">
          </i><br>
              Verify Lecurer 
          </a>

          <a href="student.php" class="col btn btn-dark m-2 py-3">
          <i class="fa fa-graduation-cap fs-1" aria-hidden="true">
          </i><br>
             View Students
          </a>

          <a href="student-add.php" class="col btn btn-dark m-2 py-3">
          <i class="fa fa-graduation-cap fs-1" aria-hidden="true">
          </i><br>
              Student Verification
          </a>
          
        </div>
      </div>
    </div> 
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(1) a").addClass('active');
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