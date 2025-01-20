<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/lecturer.php";
       include "data/unit.php";

       if(isset($_GET['Lecturer_ID'])){

       $Lecturer_ID = $_GET['Lecturer_ID'];

       $lecturers = getLecturerById($Lecturer_ID,$conn);    
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Lecturers</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include "inc/navbar.php";
        if ($lecturers != 0) {
     ?>
     <div class="container mt-5">
         <div class="card" style="width: 22rem;">
          <img src="../Images/lecturer-<?=$lecturers['gender']?>.webp" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title text-center">@<?=$lecturers['username']?></h5>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">First name: <?=$lecturers['fname']?></li>
            <li class="list-group-item">Last name: <?=$lecturers['lname']?></li>
            <li class="list-group-item">Username: <?=$lecturers['username']?></li>

            <li class="list-group-item">Address: <?=$lecturers['address']?></li>
			<li class="list-group-item">Email: <?=$lecturers['email']?></li>
            <li class="list-group-item">Phone number: <?=$lecturers['phone_number']?></li>
			<li class="list-group-item">Employee number: <?=$lecturers['employee_number']?></li>
            <li class="list-group-item">Qualification: <?=$lecturers['qualification']?></li>
			<li class="list-group-item">Date of birth: <?=$lecturers['date_of_birth']?></li>
            <li class="list-group-item">Gender: <?=$lecturers['gender']?></li>
            <li class="list-group-item">Date joined: <?=$lecturers['date_joined']?></li>

            <li class="list-group-item">Unit: 
                <?php 
                   $u = '';
                   $units = str_split(trim($lecturers['units']));
                   foreach ($units as $unit) {
                      $u_temp = getUnitById($unit, $conn);
                      if ($u_temp != 0) 
                        $u .=$u_temp['unit_code'].', ';
                   }
                   echo $u;
                ?>
            </li>
            
          </ul>
          <div class="card-body">
            <a href="lecturer.php" class="card-link">Go Back</a>
          </div>
        </div>
     </div>
     <?php 
        }else {
          header("Location: lecturer.php");
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
        header("Location: lecturer.php");
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