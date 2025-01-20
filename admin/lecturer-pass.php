<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Password Reset</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.webp">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .container {
            max-width: 900px;
            margin: 20px auto;
            border: 2px solid red;
            border-radius: 10px;
            border-color: green coral cornflowerblue;
        }
    </style>
    <script>
        // Function to validate the password strength and confirm passwords
        function validateForm() {
            var newPassword = document.getElementById('new_password').value;
            var confirmPassword = document.getElementById('confirm_new_password').value;
            var errorMessage = '';

            // Check if passwords match
            if (newPassword !== confirmPassword) {
                errorMessage = 'Passwords do not match!';
            } else if (!isValidPassword(newPassword)) {
                // Check password strength (minimum 8 characters, at least one number, one uppercase letter)
                errorMessage = 'Password must be at least 8 characters, including one uppercase letter and one number.';
            }

            // Display error message if any validation fails
            if (errorMessage !== '') {
                document.getElementById('error-message').innerText = errorMessage;
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }

        // Function to check password strength
        function isValidPassword(password) {
            // Minimum 8 characters, at least one number, and one uppercase letter
            var regex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
            return regex.test(password);
        }
    </script>
</head>
<body class="body-home">
    <?php include "inc/navbar.php"; ?>
    <div class="container shadow p-4 bg-white">
        <a href="lecturer.php" class="btn btn-dark">Go Back</a>
        <h1>Reset Password</h1>
        <!-- Display error/success messages -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>

        <form action="./req/lecturer-pass.php" method="POST" onsubmit="return validateForm()">
            <input type="hidden" name="lecturer_id" value="<?php echo htmlspecialchars($_GET['lecturer_id']); ?>"> <!-- Pass lecturer ID -->
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
            </div>
            <div id="error-message" class="alert alert-danger" style="display:none;"></div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>

    </div>
</body>
</html>
