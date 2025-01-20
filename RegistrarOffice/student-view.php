<?php 
session_start();
if (isset($_SESSION['r_user_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Registrar Office') {
       include "../DB_connection.php";
       include "data/student.php";
       include "data/unit.php";

       if(isset($_GET['student_id'])){

       $student_id = $_GET['student_id'];

       $student = getStudentById($student_id, $conn);    
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - students</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="body-login">
    <?php 
        include "inc/navbar.php";
        if ($students != 0) {
     ?>
     <div>
         <div class="container shadow p-4 bg-white">
          <img src="../Images/student-<?=$students['gender']?>.webp" class="card" alt="...">
          <br>
          <div class="card-body">
          <h5 class="card-title text-center"><?=$students['fname']?> <?=$students['mname']?> <?=$students['lname']?></h5>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Address: <?=$students['address']?></li>
			      <li class="list-group-item">Email: <?=$students['email']?></li>
            <li class="list-group-item">Phone number: <?=$students['phone_number']?></li>
			      <li class="list-group-item">Employee number: <?=$students['employee_number']?></li>
            <li class="list-group-item">Qualification: <?=$students['qualification']?></li>
			      <li class="list-group-item">Date of birth: <?=$students['date_of_birth']?></li>
            <li class="list-group-item">Gender: <?=$students['gender']?></li>
            <li class="list-group-item">Date joined: <?=$students['date_joined']?></li>

            <li class="list-group-item">Unit: 
                <?php 
                   $u = '';
                   $units = str_split(trim($students['units']));
                   foreach ($units as $unit) {
                      $u_temp = getUnitById($unit, $conn);
                      if ($u_temp != 0) 
                        $u .=$u_temp['unit_code'].', ';
                   }
                   echo $u;
                ?>
            </li>
            
          </ul>
        </div>
     </div>
     <?php 
        }else {
          header("Location: student.php");
          exit;
        }
     ?>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(2) a").addClass('active');
        });
    </script>

</body>
</html>
<?php 

    }else {
        header("Location: student.php");
        exit;
    }

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>