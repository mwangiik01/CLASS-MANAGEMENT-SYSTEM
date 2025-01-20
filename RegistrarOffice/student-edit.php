<?php 
session_start();

if (isset($_SESSION['r_user_id']) && isset($_SESSION['role']) && isset($_GET['newstudent_id'])) {
    if ($_SESSION['role'] == 'Registrar Office') {

        include "../DB_connection.php";

        if (!isset($conn)) {
            die("Database connection error.");
        }

        $newstudent_id = intval($_GET['newstudent_id']);

        try {
            // Fetch the student's data
            $stmt = $conn->prepare("SELECT * FROM studentregistration WHERE newstudent_id = ?");
            $stmt->execute([$newstudent_id]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$student) {
                header("Location: student.php?error=Student not found");
                exit;
            }

            // Fetch all courses
            $stmt_courses = $conn->query("SELECT course_id, course_name FROM courses");
            $courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching data: " . $e->getMessage());
            header("Location: student.php?error=An error occurred while fetching data");
            exit;
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Info</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container shadow p-4 bg-white">
        <a href="student-add.php" class="btn btn-dark">Go Back</a>
        <form method="post" action="req/student-edit.php" class="mt-4">
            <h3>Edit Student Info</h3><hr>

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
            <?php } ?>

            <input type="hidden" name="newstudent_id" value="<?= htmlspecialchars($student['newstudent_id']) ?>">

            <?php 
            $fields = [
                "registration_number" => "Registration Number",
                "fname" => "First Name",
                "mname" => "Middle Name",
                "lname" => "Last Name",
                "email" => "Student Email",
                "National_ID_Number" => "National ID Number",
                "KCSE_Index_Number" => "KCSE Index Number",
                "Passport_Number" => "Passport Number",
                "gender" => "Gender",
                "date_of_birth" => "Date of Birth",
                "phone_number" => "Phone Number",
                "postal_code" => "Postal Code",
                "personal_email" => "Personal Email",
                "town" => "Town",
                "postal_address" => "Postal Address",
            ];

            foreach ($fields as $field => $label) { ?>
                <div class="mb-3">
                    <label class="form-label"><?= $label ?></label>
                    <?php if ($field === 'gender') { ?>
                        <select class="form-control" name="gender">
                            <option value="Male" <?= $student['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= $student['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                        </select>
                    <?php } elseif ($field === 'date_of_birth') { ?>
                        <input type="date" class="form-control" name="<?= $field ?>" value="<?= htmlspecialchars($student[$field]) ?>">
                    <?php } else { ?>
                        <input type="text" class="form-control" name="<?= $field ?>" value="<?= htmlspecialchars($student[$field]) ?>">
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="mb-3">
                <label class="form-label">Course</label>
                <select class="form-control" name="course_id">
                    <?php if (!empty($courses)) { ?>
                        <?php foreach ($courses as $course) { ?>
                            <option value="<?= htmlspecialchars($course['course_id']) ?>" 
                                <?= $student['course_id'] === $course['course_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($course['course_name']) ?>
                            </option>
                        <?php } ?>
                    <?php } else { ?>
                        <option value="" disabled>No courses available</option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    } else {
        header("Location: login.php?error=Unauthorized access");
        exit;
    }
} else {
    header("Location: login.php?error=Unauthorized access");
    exit;
}
?>
