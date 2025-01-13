<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>LOGIN</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="logo.webp">

	<style>
	#homeNav {
	background: rgba(255,255,255,0.5) !important;
	position: sticky;
	top: 0;
	z-index: 1020; /* Ensures it appears above other content */
	box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
}
	/* Dark navbar */
.navbar-dark {
    background-color:rgb(23, 93, 163); /* Dark background color */
}

/* Navbar links glowing effect on hover */
.navbar-nav .nav-link {
    transition: all 0.3s ease;
}

.navbar-nav .nav-link:hover {
    color:rgb(101, 59, 255) !important; /* Yellow glow */
    text-shadow: 0 0 10px #ffeb3b, 0 0 20px #ffeb3b, 0 0 30px #ffeb3b, 0 0 40px #ffeb3b;
}

/* Navbar links normal state */
.navbar-nav .nav-link {
    color: black !important; /* Make links white */
}

/* Navbar active link */
.navbar-nav .nav-link.active {
    color: #ffeb3b !important; /* Highlight active link with yellow */
    text-shadow: 0 0 10px #ffeb3b, 0 0 20px #ffeb3b;
}
	
</style>

</head>
<body class="body-home">
    <div>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="homeNav">
	<div class="container-fluid">
		<a class="navbar-brand" href="#">
		<img src="logo.webp" width="40" alt="Logo">
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav me-auto mb-2 mb-lg-0">
			<li class="nav-item">
			<a class="nav-link active" aria-current="page" href="index.php">Home</a>
			</li>
	</div>
	</nav>
    <div class="black-fill"><br /> <br />
    	<div class="d-flex justify-content-center align-items-center flex-column">
    	<form class="login" 
    	      method="post"
    	      action="req/login.php">

    		<div class="text-center">
    			<img src="logo.webp"
    			     width="100">
    		</div>
    		<h3>LOGIN</h3>
    		<?php if (isset($_GET['error'])) { ?>
    		<div class="alert alert-danger" role="alert">
			  <?=$_GET['error']?>
			</div>
			<?php } ?>
		  <div class="mb-3">
		    <label class="form-label">Email</label>
		    <input type="email" 
		           class="form-control"
		           name="email">
		  </div>
		  
		  <div class="mb-3">
		    <label class="form-label">Password</label>
		    <input type="password" 
		           class="form-control"
		           name="pass">
		  </div>

		  <div class="mb-3">
		    <label class="form-label">Login As</label>
		    <select class="form-control"
		            name="role">
		    	<option value="1">Admin</option>
		    	<option value="2">Lecturer</option>
		    	<option value="3">New Student</option>
				<option value="4">Student</option>
				<option value="5">Registrar Office</option>
		    </select>
		  </div>

		  <button type="submit" class="btn btn-primary">Login</button>
		  <a href="index.php" class="text-decoration-none">Home</a>
		</form>
        
        <br /><br />
        <div class="text-center text-light">
        	Copyright &copy; 2024 EEE DEPARTMENT. All rights reserved. 
        </div>

    	</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
</body>
</html>