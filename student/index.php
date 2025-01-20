<?php 
session_start();
if (isset($_SESSION['student_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Student') {
       include "../DB_connection.php";
       include "data/student.php";
       include "data/unit.php";
	    include "data/grade.php";

       $student_id = $_SESSION['student_id'];
       $student = getstudentById($student_id, $conn);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>student - Home</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.webp">
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

  .custom-list {
    list-style-type: none; /* Removes default bullet points */
    padding: 0;
}

.custom-list li {
    background: #f9f9f9;
    margin: 5px 0;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
  
  </style>
</head>
<body class="body-login">
    <?php 
        include "inc/navbar.php";

        if ($student != 0) {
     ?>
      <div class="container shadow p-4 bg-white">
          <div class="row">
              <!-- Basic Information Card -->
              <div class="col-md-6 mb-4">
                  <div class="card" style="width: 100%;">
                      <div class="card-body">
                          <h5 class="card-title text-center">Basic Information</h5>
                      </div>
                      <ul class="list-group list-group-flush">
                          <li class="list-group-item">Name:   <?=$student['fname']?> <?=$student['mname']?> <?=$student['lname']?></li>
                          <li class="list-group-item">Admision Number:  <?=$student['registration_number']?></li>
                          <li class="list-group-item">student Email:   <?=$student['email']?></li>
                          <li class="list-group-item">National ID Number:   <?=$student['National_ID_Number']?></li>
                          <li class="list-group-item">Passport Number:  <?=$student['Passport_Number']?></li>
                          <li class="list-group-item">Gender:   <?=$student['gender']?></li>
                          <li class="list-group-item">Date of Birth:  <?=$student['date_of_birth']?></li>
                          <li class="list-group-item">KCSE Index Number:   <?=$student['KCSE_Index_Number']?></li>
                      </ul>
                  </div>
              </div>

              <!-- Contact Information Card -->
              <div class="col-md-6 mb-4">
                  <div class="card" style="width: 100%;">
                      <div class="card-body">
                          <h5 class="card-title text-center">Contact Information</h5>
                      </div>
                      <ul class="list-group list-group-flush">
                          <li class="list-group-item">Phone Number:   <?=$student['phone_number']?></li>
                          <li class="list-group-item">Email:  <?=$student['personal_email']?></li>
                          <li class="list-group-item">Postal Address:   <?=$student['postal_address']?></li>
                          <li class="list-group-item">Postal Code:  <?=$student['postal_code']?></li>
                          <li class="list-group-item">Town:   <?=$student['town']?></li>
                      </ul>
                  </div>
              </div>

              <!-- Units Card -->
              <div class="col-md-6 mb-4">
                  <div class="card" style="width: 100%;">
                      <div class="card-body">
                          <h5 class="card-title text-center">My Current Units</h5>
                      </div>

                   
                      <ul class="list-group">
                        <?php
                        // Assuming $student['student_id'] is the student's ID
                        $studentId = $student['student_id'];

                        // Query to fetch unit names and IDs assigned to this student
                        $query = "
                            SELECT u.unit_id, u.unit_name
                            FROM units u
                            JOIN student_unit_enrollments lua ON u.unit_id = lua.unit_id
                            WHERE lua.student_id = ?
                        ";
                        $stmt = $conn->prepare($query);
                        $stmt->execute([$studentId]);
                        $units = $stmt->fetchAll();

                        // Generate the unit list
                        if (count($units) > 0) {
                            foreach ($units as $unit) {
                                // Wrap the <li> in an <a> tag for redirection
                                echo "<li class='list-group-item'>";
                                echo htmlspecialchars($unit['unit_name']);
                                echo "</li>";
                                echo "</a>";
                            }
                        } else {
                            echo "<li class='list-group-item'>No units assigned</li>";
                        }
                        ?>
                    </ul>


                  </div>
              </div>


          </div>
      </div>


     <?php 
        }else {
          header("Location: logout.php?error=An error occurred");
          exit;
        }
     ?>
    
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