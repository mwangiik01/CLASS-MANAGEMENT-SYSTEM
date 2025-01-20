<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/unit.php";
        include "data/course.php";

        // Initialize variables with empty values
        $fname = $mname = $lname = $email = $personal_email = $pass = $phone_number = $address = $employee_number = $qualification = '';

        // Populate variables from GET parameters if they exist
        if (isset($_GET['fname'])) $fname = $_GET['fname'];
        if (isset($_GET['mname'])) $mname = $_GET['mname'];
        if (isset($_GET['lname'])) $lname = $_GET['lname'];
        if (isset($_GET['email'])) $email = $_GET['email'];
        if (isset($_GET['personal_email'])) $personal_email = $_GET['personal_email'];
        if (isset($_GET['pass'])) $pass = $_GET['pass'];
        if (isset($_GET['phone_number'])) $phone_number = $_GET['phone_number'];
        if (isset($_GET['address'])) $address = $_GET['address'];
        if (isset($_GET['employee_number'])) $employee_number = $_GET['employee_number'];
        if (isset($_GET['qualification'])) $qualification = $_GET['qualification'];
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
        .container {
            max-width: 900px;
            margin: 20px auto;
        }
    </style>
</head>
<body class="body-home">
    <?php include "inc/navbar.php"; ?>
    <div class="container shadow p-4 bg-white">
        <a href="lecturer.php" class="btn btn-dark">Go Back</a>
        
        <form method="post" action="req/lecturer-add.php">
            <h3>Add New Lecturer</h3><hr>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php } ?>
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($fname) ?>" name="fname" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Middle Name</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($mname) ?>" name="mname">
            </div>

            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($lname) ?>" name="lname" required>
            </div>

            <div class="mb-3">
                <label class="form-label">School Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="pass" id="passInput" required>
                    <button type="button" class="btn btn-secondary" id="gBtn">Random</button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Personal Email</label>
                <input type="email" class="form-control" value="<?= htmlspecialchars($personal_email) ?>" name="personal_email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($phone_number) ?>" name="phone_number" required>
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
                <label class="form-label">Address</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($address) ?>" name="address" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Employee Number</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($employee_number) ?>" name="employee_number" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Qualification</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($qualification) ?>" name="qualification" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" name="date_of_birth" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Add Lecturer</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fnameInput = document.querySelector("input[name='fname']");
            const lnameInput = document.querySelector("input[name='lname']");
            const emailInput = document.getElementById("email");

            function generateEmail() {
                const fname = fnameInput.value.trim().toLowerCase();
                const lname = lnameInput.value.trim().toLowerCase();
                emailInput.value = fname && lname ? `${lname}.${fname}@lecturer.dkut.ac.ke` : "";
            }

            fnameInput.addEventListener("input", generateEmail);
            lnameInput.addEventListener("input", generateEmail);

            document.getElementById('gBtn').addEventListener('click', function(e) {
                const length = 8;
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                let result = '';
                for (let i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * characters.length));
                }
                document.getElementById('passInput').value = result;
            });
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
