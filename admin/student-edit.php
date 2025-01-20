<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['student_id'])) {

    if ($_SESSION['role'] == 'Admin') {
      
       include "../DB_connection.php";
       include "data/unit.php";
       include "data/grade.php";
       include "data/student.php";
	   include "data/section.php";
     include "data/course.php";

     // Fetch all courses
     $stmt_courses = $conn->query("SELECT course_id, course_name FROM courses");
     $courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);

       $subjects = getAllUnits($conn);
       $grades = getAllGrades($conn);
	   $sections = getAllsections($conn);
       
       $student_id = $_GET['student_id'];
       $student = getStudentById($student_id, $conn);

       if ($student == 0) {
         header("Location: student.php");
         exit;
       }


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Edit Student</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
       
        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            
        }
    </style>
</head>
<body class="body-login">
    <?php include "inc/navbar.php"; ?>
    <div class="container shadow p-4 bg-white">
        <a href="student.php"
           class="btn btn-dark">Go Back</a>

        <form method="post"
              class="shadow p-3 mt-5 form-w" 
              action="req/student-edit.php">
        <h3>Edit Student Info</h3><hr>
        <?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert">
           <?=$_GET['error']?>
          </div>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
          <div class="alert alert-success" role="alert">
           <?=$_GET['success']?>
          </div>
        <?php } ?>
        <div class="mb-3">
          <label class="form-label">First name</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$student['fname']?>" 
                 name="fname">
        </div>
        <div class="mb-3">
          <label class="form-label">Middle Name</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$student['mname']?>"
                 name="username">
        </div>
        <div class="mb-3">
          <label class="form-label">Last name</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$student['lname']?>"
                 name="lname">
        </div>
  
        <input type="text"
                value="<?=$student['student_id']?>"
                name="student_id"
                hidden>
		<div class="mb-3">
		    <label class="form-label">Personal email</label>
		    <input type="text" 
		           class="form-control"
				   value="<?=$student['personal_email']?>"
		           name="email">
		</div>
		<div class="mb-3">
		    <label class="form-label">phone_number</label>
		    <input type="text" 
		           class="form-control"
				   value="<?=$student['phone_number']?>"
		           name="phone_number">
		</div>
		<div class="mb-3">
		    <label class="form-label">registration_number</label>
		    <input type="text" 
		           class="form-control"
				   value="<?=$student['registration_number']?>"
		           name="registration_number">
		</div>
		<div class="mb-3">
                <label class="form-label">Course</label>
                <select class="form-control" name="course_id">
                    <?php if (!empty($courses)) { ?>
                        <?php foreach ($courses as $course) { ?>
                            <option value="<?= htmlspecialchars($course['course_id']) ?>" 
                                <?= $student['course_id'] === $course['course_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($course['course_name']) ?>
                            </option>
                        <?php } ?>
                    <?php } else { ?>
                        <option value="" disabled>No courses available</option>
                    <?php } ?>
                </select>
            </div>
		<div class="mb-3">
                <label class="form-label">Gender</label>
                <select class="form-control" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
		<div class="mb-3">
          <label class="form-label">Date of birth</label>
          <input type="date" 
                 class="form-control"
                 value="<?=$student['date_of_birth']?>"
                 name="date_of_birth">
        </div>
        <br><hr>
		
		<div class="mb-3">
          <label class="form-label">Parent first name</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$student['parent_fname']?>"
                 name="parent_fname">
        </div>
		<div class="mb-3">
          <label class="form-label">Parent last name</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$student['parent_lname']?>"
                 name="parent_lname">
        </div>
		<div class="mb-3">
          <label class="form-label">Parent phone number</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$student['parent_phone_number']?>"
                 name="parent_phone_number">
        </div>
      <button type="submit" 
              class="btn btn-primary">
              Update</button>
     </form>

     <form method="post"
              class="shadow p-3 my-5 form-w" 
              action="req/student-change.php"
              id="change_password">
        <h3>Change Password</h3><hr>
          <?php if (isset($_GET['perror'])) { ?>
            <div class="alert alert-danger" role="alert">
             <?=$_GET['perror']?>
            </div>
          <?php } ?>
          <?php if (isset($_GET['psuccess'])) { ?>
            <div class="alert alert-success" role="alert">
             <?=$_GET['psuccess']?>
            </div>
          <?php } ?>

       <div class="mb-3">
            <div class="mb-3">
            <label class="form-label">Admin password</label>
                <input type="password" 
                       class="form-control"
                       name="admin_pass"> 
          </div>

            <label class="form-label">New password </label>
            <div class="input-group mb-3">
                <input type="text" 
                       class="form-control"
                       name="new_pass"
                       id="passInput">
                <button class="btn btn-secondary"
                        id="gBtn">
                        Random</button>
            </div>
            
          </div>
          <input type="text"
                value="<?=$student['student_id']?>"
                name="student_id"
                hidden>

          <div class="mb-3">
            <label class="form-label">Confirm new password  </label>
                <input type="text" 
                       class="form-control"
                       name="c_new_pass"
                       id="passInput2"> 
          </div>
          <button type="submit" 
              class="btn btn-primary">
              Change</button>
        </form>
     </div>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(3) a").addClass('active');
        });

        function makePass(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
              result += characters.charAt(Math.floor(Math.random() * 
         charactersLength));

           }
           var passInput = document.getElementById('passInput');
           var passInput2 = document.getElementById('passInput2');
           passInput.value = result;
           passInput2.value = result;
        }

        var gBtn = document.getElementById('gBtn');
        gBtn.addEventListener('click', function(e){
          e.preventDefault();
          makePass(4);
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
	header("Location: student.php");
	exit;
} 

?>