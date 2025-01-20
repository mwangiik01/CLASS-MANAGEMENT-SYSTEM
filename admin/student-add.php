<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
      
       include "../DB_connection.php";

	   $email = '';
	   $password = '';

	   if (isset($_GET['email'])) $email = $_GET['email'];
	   if (isset($_GET['password'])) $address = $_GET['password'];
	
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Add Student</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
	.container {
	max-width: 500px;
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
    ?>
    <div class="container shadow p-4 bg-white">
        <a href="student.php"
           class="btn btn-dark">Go Back</a>

        <form method="post"
              class="shadow p-3 mt-5 form-w" 
              action="req/student-add.php">
        <h3>Add New Student</h3><hr>
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
		    <label class="form-label">email</label>
		    <input type="text" 
		           class="form-control"
				   value="<?=$email?>"
		           name="email">
		  </div>
		
		
        <div class="mb-3">
          <label class="form-label">Password</label>
          <div class="input-group mb-3">
              <input type="password" 
                     class="form-control"
                     name="password"
                     id="passInput">
              <button class="btn btn-secondary"
                      id="gBtn">
                      Random</button>
          </div>
		  </div>
      <button type="submit" class="btn btn-primary">Register</button>
     </form>
    </div>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
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