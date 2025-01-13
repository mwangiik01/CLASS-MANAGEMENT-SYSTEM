<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ELECTRICAL AND ELECTRONICS DEPARTMENT</title>
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
			<a class="nav-link active" aria-current="page" href="#">Home</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="#about">About</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="#contact">Contact</a>
			</li>
		</ul>
		<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
			<li class="nav-item">
			<a href="login.php" class="btn btn-dark">Login</a>
			</li>
		</ul>
		</div>
	</div>
	</nav>


        <!-- Noticeboard Section -->
		<section id="noticeboard" class="d-flex justify-content-center align-items-center flex-column my-5">
			<div class="card text-center" style="width: 80%; max-width: 800px;">
				<div class="card-header bg-primary text-white">
					<h4>Noticeboard</h4>
				</div>
				<div class="card-body">
					<ul class="list-group">
						<li class="list-group-item">
							<strong>Important Update:</strong> The semester exams are scheduled from 15th December 2024.
						</li>
						<li class="list-group-item">
							<strong>Workshop:</strong> A workshop on AI and Robotics will be held on 20th December 2024.
						</li>
						<li class="list-group-item">
							<strong>Holiday:</strong> The department will remain closed on 25th December 2024 for Christmas.
						</li>
						<li class="list-group-item">
							<strong>Results:</strong> Mid-term results will be published on 30th November 2024.
						</li>
					</ul>
				</div>
				<div class="card-footer text-muted">
					Last updated on 10th December 2024
				</div>
			</div>
		</section>

        <!-- About Section -->
        <section id="about" class="d-flex justify-content-center align-items-center flex-column">
        	<div class="card mb-3 card-1">
			  <div class="row g-0">
			    <div class="col-md-4">
			      <img src="logo.webp" class="img-fluid rounded-start" >
			    </div>
			    <div class="col-md-8">
			      <div class="card-body">
			        <h5 class="card-title">About Us</h5>
			        <p class="card-text">This is the departmental management system for the Electrical and Electronics Engineering department of Dedan Kimathi University of Technology. Our department offers a variety of undergraduate and postgraduate programs in Electrical and Electronics Engineering with a focus on modern technologies.</p>
			        <p class="card-text"><small class="text-muted">ELECTRICAL AND ELECTRONICS DEPARTMENT</small></p>
			      </div>
			    </div>
			  </div>
			</div>
        </section>

        <!-- school Section -->
        <section id="school" class="d-flex justify-content-center align-items-center flex-column my-5">
            <h3>Our school</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img src="school1.jpg" class="card-img-top" alt="school Member">
                        <div class="card-body">
                            <h5 class="card-title">Dr. John Doe</h5>
                            <p class="card-text">Head of Department</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img src="school2.jpg" class="card-img-top" alt="school Member">
                        <div class="card-body">
                            <h5 class="card-title">Prof. Jane Smith</h5>
                            <p class="card-text">Associate Professor</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img src="school3.jpg" class="card-img-top" alt="school Member">
                        <div class="card-body">
                            <h5 class="card-title">Dr. Alex Brown</h5>
                            <p class="card-text">Lecturer</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Contact Section -->
        <section id="contact" class="d-flex justify-content-center align-items-center flex-column">
        	<form>
        		<h3>Contact Us</h3>
				<div class="mb-3">
					<label for="exampleInputEmail1" class="form-label">Email address</label>
					<input type="email" 
							class="form-control" 
							id="exampleInputEmail1" 
							name="email" 
							aria-describedby="emailHelp" 
							required>
					<div id="emailHelp" class="form-text">Use your school email address (e.g., username@dkut.ac.ke)</div>
					<div id="error" style="color: red; display: none;">Email must end with @dkut.ac.ke</div>
					</div>

			  <div class="mb-3">
			    <label class="form-label">Registration Number</label>
			    <input type="text" class="form-control">
			  </div>
			  <div class="mb-3">
			    <label class="form-label">Message</label>
			    <textarea class="form-control" rows="4"></textarea>
			  </div>
			  <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>

					<script>
					document.getElementById('submitBtn').addEventListener('click', function (e) {
						const emailInput = document.getElementById('exampleInputEmail1');
						const errorDiv = document.getElementById('error');
						const emailPattern = /^[a-zA-Z0-9._%+-]+@dkut\.ac\.ke$/;

						if (!emailPattern.test(emailInput.value)) {
						e.preventDefault();
						errorDiv.style.display = 'block';
						} else {
						errorDiv.style.display = 'none';
						}
					});
					</script>
			</form>
        </section>

        <div class="text-center text-light">
        	  Copyright &copy; 2024 EEE DEPARTMENT. All rights reserved.
        </div>
    	
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
</body>
</html>
