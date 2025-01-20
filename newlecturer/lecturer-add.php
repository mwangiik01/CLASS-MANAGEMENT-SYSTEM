<?php 
session_start();
if (isset($_SESSION['newlecurer_ID']) && 
    isset($_SESSION['role'])) {
		
		if ($_SESSION['role'] == 'Admin') {
			
			include "../DB_connection.php";

            $fname = '';
            $lname = '';
            $mname = '';
            $email = '';	
            $password = '';		

            if (isset($_GET['fname'])) $fname = $_GET['fname'];
            if (isset($_GET['lname'])) $lname = $_GET['lname'];
            if (isset($_GET['mname'])) $mname = $_GET['mname'];	
            if (isset($_GET['email'])) $email = $_GET['email'];
            if (isset($_GET['password'])) $email = $_GET['password'];
			
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Add Lecturer</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.webp">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style>
		body {
			background-color: #f8f9fa;
			margin: 0;
			padding: 0;
		}
		.container {
			max-width: 600px;
			margin: 20px auto;
			border: 2px solid red;
  			border-radius: 10px;
			border-style: solid;
  			border-color: green;
			border-left-color: coral;
			border-right-color: cornflowerblue;
		}
	</style>
</head>
<body class="body-home">
    <?php
	   include "inc/navbar.php";
	?>
    <div class="container shadow p-4 bg-white">
		  
		  <form  method="post"
		         class="shadow p-3 mt-5 form-w"
    	         action="req/lecturer-add.php">

    
    		<h3><b>Add New Lecturer</b></h3><hr>
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
				   value="<?=$fname?>"
		           name="fname">
		  </div>

		  <div class="mb-3">
		    <label class="form-label">Middle Name</label>
		    <input type="text" 
		           class="form-control"
				   value="<?=$mname?>"
		           name="mname">
		  </div>

        <div class="mb-3">
		    <label class="form-label">Last name</label>
		    <input type="text" 
		           class="form-control"
				   value="<?=$lname?>"
		           name="lname">
		  </div>		  

		  <div class="mb-3">
		    <label class="form-label">Password</label>
			<div class="input-group mb-3">
		    <input type="text" 
		           class="form-control"
		           name="password"
				   id="passInput">
		    <button class="btn btn-secondary"
			        id="gBtn">
                    Random</button>
		  </div>
		  </div>
		  <div class="mb-3">
		  <label class="form-label">Email</label>
			<input type="email" 
				class="form-control"
				name="email"
				id="email">
				<small id="emailError" style="color: red; display: none;">Email must end with @dkut.ac.ke</small>
			</div>

		  <script>
					// Get form and elements
					const emailField = document.getElementById("email");
					const emailError = document.getElementById("emailError");
					const form = document.getElementById("emailForm");

					// Email validation on blur
					emailField.addEventListener("blur", function () {
						validateEmail();
					});

					// Prevent form submission if email is invalid
					form.addEventListener("submit", function (e) {
						if (!validateEmail()) {
							e.preventDefault(); // Prevent form submission
						}
					});

					// Function to validate email
					function validateEmail() {
						const emailValue = emailField.value;

						// Check if the email ends with @dkut.ac.ke
						if (emailValue && !emailValue.endsWith("@dkut.ac.ke")) {
							emailError.style.display = "block"; // Show error message
							return false; // Invalid email
						} else {
							emailError.style.display = "none"; // Hide error message
							return true; // Valid email
						}
					}
				</script>
		
		  <button type="submit" class="btn btn-primary">Add</button>
		</form>
	</div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
       $(document).ready(function(){
             $("#navLinks li:nth-child(2) a").addClass('active');
        });

        function makepassword(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
              result += characters.charAt(Math.floor(Math.random() * 
         charactersLength));

           }
           var passwordInput = document.getElementById('passwordInput');
           passwordInput.value = result;
        }

        var gBtn = document.getElementById('gBtn');
        gBtn.addEventListener('click', function(e){
          e.preventDefault();
          makepassword(4);
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