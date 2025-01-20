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
	<title>Students Enrolled in <?php echo htmlspecialchars($unit['unit_name']); ?></title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.webp">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
        .container {
            max-width: 500px;
            margin: 20px auto;
            border: 2px solid red;
            border-radius: 10px;
            margin-top: 5px;
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
<?php include "inc/navbar.php"; ?>
<div class="container shadow p-4 bg-white">
    <h4>Marks Submission</h4>
<ul class="list-group">
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
                        echo "<a href='final-marks.php?unit_id=" . htmlspecialchars($unit['unit_id']) . "&lecturer_id=" . htmlspecialchars($lecturerId) . "&semester_id=" . htmlspecialchars($unit['semester_id']) . "&year_id=" . htmlspecialchars($unit['year_id']) . "'>";
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
            </ul>

        <div class="mt-4 text-center">
            <a href="units.php" class="btn btn-secondary">Back to Units</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(4) a").addClass('active');
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
