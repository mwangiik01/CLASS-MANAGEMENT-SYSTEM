<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.webp">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
	/* Dark navbar */
.navbar-dark {
    background-color:rgb(23, 93, 163); /* Dark background color */
}

/* Navbar links glowing effect on hover */
.navbar-nav .nav-link {
    transition: all 0.3s ease;
}

.navbar-nav .nav-link:hover {
    color:rgb(116, 255, 97) !important; /* Yellow glow */
    text-shadow: 0 0 10px #ffeb3b, 0 0 20px #ffeb3b, 0 0 30px #ffeb3b, 0 0 40px #ffeb3b;
}

/* Navbar links normal state */
.navbar-nav .nav-link {
    color: white !important; /* Make links white */
}

/* Navbar active link */
.navbar-nav .nav-link.active {
    color: #ffeb3b !important; /* Highlight active link with yellow */
    text-shadow: 0 0 10px #ffeb3b, 0 0 20px #ffeb3b;
}
.container {
	max-width: 1200px;
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
<body class="body-home">
	<?php
	   include "inc/navbar.php";
	?>
    <div class="container shadow p-4 bg-white">
        <form method="post" action="req/student-add.php">
            <h3><b>Add Personal Details</b></h3>
            <hr>
            
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

            <div class="mb-3">
                <label class="form-label">Registration Number </label>
                <input type="text" class="form-control" name="registration_number" required>
            </div>

            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" name="fname" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Middle Name</label>
                <input type="text" class="form-control" name="mname">
            </div>

            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lname" required>
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
                <label class="form-label">National ID Number</label>
                <input type="text" class="form-control" name="national_id_number" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Personal Email</label>
                <input type="email" class="form-control" name="personal_email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">School Email</label>
                <input type="email" class="form-control" id="email" name="email" readonly>
            </div>

            <!-- Hidden field to hold registration date -->
            <input type="hidden" id="registration_date" name="registration_date" value="<?= date('Y-m-d') ?>">

            <div class="mb-3">
                <label class="form-label">KCSE Index Number</label>
                <input type="text" class="form-control" name="kcse_index_number" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Passport Number</label>
                <input type="text" class="form-control" name="passport_number">
            </div>

            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" name="date_of_birth" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone_number" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Postal Address</label>
                <input type="text" class="form-control" name="postal_address">
            </div>

            <div class="mb-3">
                <label class="form-label">Postal Code</label>
                <input type="text" class="form-control" name="postal_code">
            </div>

            <div class="mb-3">
                <label class="form-label">Town</label>
                <input type="text" class="form-control" name="town">
            </div>

            <div class="mb-3">
                <label class="form-label">Course</label>
                <select class="form-control" name="course_id" required>
                    <?php
                    include '../DB_connection.php';
                    $stmt = $conn->query("SELECT course_id, course_name FROM courses");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['course_id']}'>{$row['course_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <br><hr>
            <button type="submit" class="btn btn-primary">SUBMIT</button>
        </form>
    </div>

    <!-- JavaScript for School Email Generation -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fnameInput = document.querySelector("input[name='fname']");
            const lnameInput = document.querySelector("input[name='lname']");
            const emailInput = document.getElementById("email");

            // Get the current year
            const currentYear = new Date().getFullYear();
            const yearSuffix = currentYear.toString().slice(2); // '24' for 2024

            // Function to generate school email
            function generateEmail() {
                const fname = fnameInput.value.trim().toLowerCase();
                const lname = lnameInput.value.trim().toLowerCase();

                if (fname && lname) {
                    emailInput.value = `${lname}.${fname}${yearSuffix}@students.dkut.ac.ke`;
                } else {
                    emailInput.value = ""; // Clear email if inputs are empty
                }
            }

            // Attach event listeners to first name and last name inputs
            fnameInput.addEventListener("input", generateEmail);
            lnameInput.addEventListener("input", generateEmail);
        });
    </script>
</body>
</html>
