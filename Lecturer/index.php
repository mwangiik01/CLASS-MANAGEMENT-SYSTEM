<?php 
session_start();
if (isset($_SESSION['lecturer_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Lecturer') {
       include "../DB_connection.php";
       include "data/lecturer.php";
       include "data/unit.php";
	   include "data/grade.php";
       include "data/section.php";
       include "data/class.php";


       $lecturer_id = $_SESSION['lecturer_id'];
       $lecturer = getLecturerById($lecturer_id, $conn);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lecturer - Home</title>
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
  
        .list-group-item {
            cursor: pointer;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 5px 0;
        }
        .list-group-item:hover {
            background-color: #007bff;
            color: white;
        }
  </style>
</head>
<body class="body-login">
    <?php 
        include "inc/navbar.php";

        if ($lecturer != 0) {
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
                          <li class="list-group-item">Name:   <?=$lecturer['fname']?> <?=$lecturer['mname']?> <?=$lecturer['lname']?></li>
                          <li class="list-group-item">Employee Number:  <?=$lecturer['employee_number']?></li>
                          <li class="list-group-item">Lecturer Email:   <?=$lecturer['email']?></li>
                          <li class="list-group-item">National ID Number:   <?=$lecturer['national_id_number']?></li>
                          <li class="list-group-item">Passport Number:  <?=$lecturer['passport_number']?></li>
                          <li class="list-group-item">Gender:   <?=$lecturer['gender']?></li>
                          <li class="list-group-item">Date of Birth:  <?=$lecturer['date_of_birth']?></li>
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
                          <li class="list-group-item">Phone Number:   <?=$lecturer['phone_number']?></li>
                          <li class="list-group-item">Postal Code:  <?=$lecturer['postal_code']?></li>
                          <li class="list-group-item">Email:  <?=$lecturer['email']?></li>
                          <li class="list-group-item">Town:   <?=$lecturer['town']?></li>
                          <li class="list-group-item">Postal Address:   <?=$lecturer['postal_address']?></li>
                      </ul>
                  </div>
              </div>

           <!-- Contact Information Card -->
           <div class="col-md-6 mb-4">
                  <div class="card" style="width: 100%;">
                      <div class="card-body">
                          <h5 class="card-title text-center">My Units</h5>
                      </div>
                      <?php
                // Assuming $lecturer['lecturer_id'] is the lecturer's ID
                $lecturerId = $lecturer['lecturer_id'];

                // Query to fetch unit names, IDs, semester, and year assigned to this lecturer
                $query = "
                    SELECT u.unit_id, u.unit_name, sue.semester_id, sue.year_id
                    FROM units u
                    JOIN lecturer_unit_assignments lua ON u.unit_id = lua.unit_id
                    JOIN student_unit_enrollments sue ON u.unit_id = sue.unit_id
                    WHERE lua.lecturer_id = ?
                    GROUP BY u.unit_id
                ";
                $stmt = $conn->prepare($query);
                $stmt->execute([$lecturerId]);
                $units = $stmt->fetchAll();

                // Generate the unit list
                if (count($units) > 0) {
                    foreach ($units as $unit) {
                        // Wrap the <li> in an <a> tag for redirection
                        echo "<a href='student-grade.php?unit_id=" . htmlspecialchars($unit['unit_id']) . "&lecturer_id=" . htmlspecialchars($lecturerId) . "&semester_id=" . htmlspecialchars($unit['semester_id']) . "&year_id=" . htmlspecialchars($unit['year_id']) . "'>";
                        echo "<li class='list-group-item'>";
                        echo htmlspecialchars($unit['unit_name']);
                        // Display the semester and year as additional info
                        echo " (Semester: " . htmlspecialchars($unit['semester_id']) . ", Year: " . htmlspecialchars($unit['year_id']) . ")";
                        echo "</li>";
                        echo "</a>";
                    }
                } else {
                    echo "<li class='list-group-item'>No units assigned</li>";
                }
                ?>
                  </div>
              </div>
             

              <!-- Schedule Card -->
              <div class="col-md-6 mb-4">
                  <div class="card" style="width: 100%;">
                      <div class="card-body">
                          <h5 class="card-title text-center">My Schedule</h5>
                      </div>
                      <ul class="list-group list-group-flush">
                          <li class="list-group-item">
                              <?php 
                                $c = '';
                                $classes = str_split(trim($lecturer['class']));

                                foreach ($classes as $class_id) {
                                    $class = getClassById($class_id, $conn);

                                    $c_temp = getGradeById($class['grade'], $conn);
                                    $section = getSectionById($class['section'], $conn);
                                    if ($c_temp != 0) 
                                      $c .= $c_temp['grade_code'].'-'.
                                            $c_temp['grade'].$section['section'].', ';
                                }
                                echo rtrim($c, ', ');
                              ?>
                          </li>
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