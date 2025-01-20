<?php
include '../DB_connection.php';

if (isset($_GET['lecturer_id'])) {
    $lecturer_id = $_GET['lecturer_id'];

    // Fetch the lecturer's data from the database
    $sql = "SELECT * FROM lecturers WHERE lecturer_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$lecturer_id]);
    
    if ($stmt->rowCount() > 0) {
        $lecturers = $stmt->fetch();
    } else {
        $em = "Lecturer not found!";
        header("Location: ../lecturer.php?error=$em");
        exit;
    }
} else {
    $em = "No lecturer ID provided!";
    header("Location: ../lecturer.php?error=$em");
    exit;
}
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
            border: 2px solid red;
            border-radius: 10px;
            border-color: green coral cornflowerblue;
        }
    </style>
</head>
<body class="body-home">
    <?php include "inc/navbar.php"; ?>
    <div class="container shadow p-4 bg-white">
        <a href="lecturer.php" class="btn btn-dark">Go Back</a>
        <h2>Edit Lecturer</h2>
        <form action="lecturer-edit.php" method="POST">

            <!-- Hidden Input to Pass Lecturer ID -->
            <input type="hidden" name="lecturer_id" value="<?=$lecturers['lecturer_id']?>">

            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" 
                       class="form-control"
                       value="<?=$lecturers['fname']?>"
                       name="fname">
            </div>

            <div class="mb-3">
                <label class="form-label">Middle Name</label>
                <input type="text" 
                       class="form-control"
                       value="<?=$lecturers['mname']?>"
                       name="mname">
            </div>

            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" 
                       class="form-control"
                       value="<?=$lecturers['lname']?>"
                       name="lname">
            </div>s

            <div class="mb-3">
                <label class="form-label">School Email</label>
                <input type="email" 
                       class="form-control"
                       value="<?=$lecturers['email']?>"
                       name="email">
            </div>

            <div class="mb-3">
                <label class="form-label">Personal Email</label>
                <input type="email" 
                       class="form-control"
                       value="<?=$lecturers['email']?>"
                       name="email">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" 
                       class="form-control"
                       value="<?=$lecturers['phone_number']?>"
                       name="phone_number">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" 
                       class="form-control"
                       value="<?=$lecturers['address']?>"
                       name="address">
            </div>

            <div class="mb-3">
                <label class="form-label">Employee Number</label>
                <input type="text" 
                       class="form-control"
                       value="<?=$lecturers['employee_number']?>"
                       name="employee_number">
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
                       <?php if($lecturers['gender'] == 'Male') echo 'checked'; ?>
                       name="gender"> Male
                       &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio"
                       value="Female"
                       <?php if($lecturers['gender'] == 'Female') echo 'checked'; ?>
                       name="gender"> Female
            </div>

            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" 
                       class="form-control"
                       value="<?=$lecturers['date_of_birth']?>"
                       name="date_of_birth">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
