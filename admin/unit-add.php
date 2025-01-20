<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include '../DB_connection.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Add Unit</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.webp">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
         .container {
            max-width: 600px;
        }
    </style>
</head>
<body class="body-login">
    <?php include "inc/navbar.php"; ?>
    
    <div class="container shadow p-4 bg-white">
        <a href="unit.php" class="btn btn-dark">Go Back</a>

        <form method="post" action="req/unit-add.php">
    <h3>Add New Unit</h3><hr>
    
    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $_GET['error'] ?>
        </div>
    <?php } ?>
    
    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success" role="alert">
            <?= $_GET['success'] ?>
        </div>
    <?php } ?>
    <br>
    <div class="mb-3">
        <label class="form-label">Unit Code</label>
        <input type="text" name="unit_code" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Unit Name</label>
        <input type="text" name="unit" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Course</label>
        <select name="course_id" class="form-control" required>
            <option value="">Select Course</option>
            <?php 
            // Fetch courses from the database
            $sql = "SELECT * FROM courses";
            $result = $conn->query($sql);
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='".$row['course_id']."'>".$row['course_name']."</option>";
            }
            ?>
        </select>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Semester</label>
        <select name="semester_id" class="form-control" required>
            <option value="">Select Semester</option>
            <?php
            // Fetch semesters from the database
            $sql = "SELECT * FROM semester";
            $result = $conn->query($sql);
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='".$row['semester_id']."'>".$row['semester_name']."</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Year</label>
        <select name="year_id" class="form-control" required>
            <option value="">Select Year</option>
            <?php
            // Fetch years from the database
            $sql = "SELECT * FROM years";
            $result = $conn->query($sql);
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='".$row['year_id']."'>".$row['year_name']."</option>";
            }
            ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Create</button>
</form>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(10) a").addClass('active');
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
