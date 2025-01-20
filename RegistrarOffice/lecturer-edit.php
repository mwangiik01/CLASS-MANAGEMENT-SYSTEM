<?php 
if (isset($_SESSION['r_user_id']) && 
isset($_SESSION['role'])) {

if ($_SESSION['role'] == 'Registrar Office') {
			
			include "../DB_connection.php";
			include "data/lecturer.php";
		    $units = getAllUnits($conn);	
            
			
            $Lecturer_ID = $_GET['Lecturer_ID'];			
            $lecturers = getLecturerById($Lecturer_ID, $conn);
			
			if ($lecturers == 0) {
				header("Location: lecturer.php");
	            exit;
			}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Edit Lecturer</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
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
		.tittle{ 
			display: center;
			align-items: center;
		}
	</style>
</head>
<body class="body-login">
    <?php
	   include "inc/navbar.php";
	?>
   <div class="container shadow p-4 bg-white">
		  
		  <form  method="post"
		         class="shadow p-3 mt-5 form-w"
    	         action="req/lecturer-edit.php">

    
    		<h3>Edit Lecturer</h3><hr>
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
				   value="<?=$lecturers['fname']?>"
		           name="fname">
		  </div>
		  <div class="mb-3">
		    <label class="form-label">Middle name</label>
		    <input type="text" 
		           class="form-control"
				   value="<?=$lecturers['mname']?>"
		           name="mname">
		  </div>	
        <div class="mb-3">
		    <label class="form-label">Last name</label>
		    <input type="text" 
		           class="form-control"
				   value="<?=$lecturers['lname']?>"
		           name="lname">
		  </div>		  

		  <div class="mb-3">
		    <label class="form-label">email</label>
		    <input type="email" 
		           class="form-control"
				   value="<?=$lecturers['email']?>"
		           name="email">
		  </div>
		   <div class="mb-3">
          <label class="form-label">address</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$lecturers['address']?>"
                 name="address">
        </div>
		  <div class="mb-3">
		    <label class="form-label">phone_number</label>
		    <input type="text" 
		           class="form-control"
				   value="<?=$lecturers['phone_number']?>"
		           name="phone_number">
		  </div>
        <div class="mb-3">
          <label class="form-label">Employee number</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$lecturers['employee_number']?>"
                 name="employee_number">
        </div>
		<div class="mb-3">
          <label class="form-label">Date of birth</label>
          <input type="date" 
                 class="form-control"
                 value="<?=$lecturers['date_of_birth']?>"
                 name="date_of_birth">
        </div>
		<div class="mb-3">
          <label class="form-label">Qualification</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$lecturers['qualification']?>"
                 name="qualification">
        </div>
		 <div class="mb-3">
          <label class="form-label">Gender</label><br>
          <input type="radio"
                 value="Male"
                 <?php if($lecturers['gender'] == 'Male') echo 'checked';  ?> 
                 name="gender"> Male
                 &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio"
                 value="Female"
                 <?php if($lecturers['gender'] == 'Female') echo 'checked';  ?> 
                 name="gender"> Female
        </div>
		<input type="text"
		         value="<?=$lecturers['Lecturer_ID']?>"
				 name="Lecturer_ID"
				 hidden>
				 <div class="mb-3">
				<label class="form-label">Unit</label>
				<select class="form-select" name="units[]" multiple>
					<optgroup label="Units">
						<?php foreach ($units as $unit) { ?>
							<option value="<?= $unit['Unit_ID'] ?>" <?= in_array($unit['Unit_ID'], str_split(trim($lecturers['units']))) ? 'selected' : '' ?>>
								<?= $unit['unit'] ?>
							</option>
						<?php } ?>
					</optgroup>
				</select>
			</div>
		
		  <button type="submit" 
		          class="btn btn-primary">
				  Update</button>
		</form>
		
		  <form  method="post"
		         class="shadow p-3 my-5 form-w"
    	         action="req/lecturer-change.php"
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
		    <label class="form-label">Admin Password</label>
		    <input type="password" 
		           class="form-control"
		           name="admin_pass">
		</div>
		    <label class="form-label">New Password</label>
			<div class="input-group mb-3">
			</div>
		    <input type="text" 
		           class="form-control"
		           name="new_pass"
				   id="passInput">
		    <button class="btn btn-secondary"
			        id="gBtn">
                    Random</button>
		  </div>
		  <input type="text"
		         value="<?=$lecturers['Lecturer_ID']?>"
				 name="Lecturer_ID"
				 hidden>
		  <div class="mb-3">
		    <label class="form-label">Confirm new Password</label>
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
             $("#navLinks li:nth-child(2) a").addClass('active');
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
	header("Location: lecturer.php");
	exit;
  }
  }else {
	header("Location: lecturer.php");
	exit;
  }

  ?>