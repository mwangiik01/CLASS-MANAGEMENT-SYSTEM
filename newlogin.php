<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="logo.webp">
</head>

<body class="body-login">

    <div class="black-fill">
        <div class="d-flex justify-content-center align-items-center flex-column">
            <form class="login" method="post" action="req/newstudents.php">
                <div class="text-center">
                    <img src="logo.webp" width="100" alt="Logo">
                </div>
                <h3>Login</h3>

                <!-- Error Message -->
                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php } ?>

                <!-- Role Selection -->
                <div class="mb-3">
                    <label for="role" class="form-label">Login As</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="newstudent">New Student</option>
                        <option value="newlecturer">New Lecturer</option>
                    </select>
                </div>

                <!-- Email Field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <!-- Password Field -->
                <div class="mb-3">
                    <label for="pass" class="form-label">Password</label>
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Enter your password" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="index.php" class="text-decoration-none">Home</a>
            </form>

            <br><br>
            <div class="text-center text-light">
                Copyright &copy; 2024 EEE DEPARTMENT. All rights reserved.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
