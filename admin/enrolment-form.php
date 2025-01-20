<?php
session_start();
if (isset($_SESSION['Admin_ID']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        require '../DB_connection.php';
        include "data/lecturer.php"; // Contains getAllLecturers function
        include "data/course.php";  // Contains getAllCourses function
        include "data/unit.php";  // Contains getAllCourses function
        include "data/semester.php";
        include "data/year.php";

        if (isset($_GET['unit_id'])) {
            $unit_id = intval($_GET['unit_id']);
            $stmt = $conn->prepare("SELECT * FROM units WHERE unit_id = :unit_id");
            $stmt->bindParam(':unit_id', $unit_id, PDO::PARAM_INT);
            $stmt->execute();
            $unit = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($unit) {
                $lecturers = getAllLecturers(conn: $conn); // Fetch all lecturers
                $courses = getAllCourses($conn); // Fetch all courses
                $semesters = getAllsemesters($conn);
                $years = getAllyears($conn);
            } else {
                echo "Invalid unit.";
                exit;
            }
        } else {
            echo "No unit selected.";
            exit;
        }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Enroll for <?php echo htmlspecialchars($unit['unit_name']); ?></title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" href="../logo.png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body class="body-login">
        <?php include "inc/navbar.php"; ?>

        <div class="container shadow p-4 bg-white">
        <a href="unit-enrolment.php" class="btn btn-dark">Go Back</a>
            <h1 class="text-center">Enroll for <?php echo htmlspecialchars($unit['unit_name']); ?></h1>

            <?php
            // Display success or error messages
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
            }
            if (isset($_GET['success'])) {
                echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($_GET['success']) . '</div>';
            }
            ?>

            <form action="req/unit-enrolment.php" method="POST">
                <!-- Hidden field for unit_id -->
                <input type="hidden" name="unit_id" value="<?php echo $unit['unit_id']; ?>">

                <!-- Lecturer Dropdown -->
                <div class="mb-4">
                    <label for="lecturer" class="form-label">Select Lecturer</label>
                    <select name="lecturer_id" id="lecturer" class="form-select">
                        <option value="" disabled selected>-- Select Lecturer --</option>
                        <?php
                        if ($lecturers) {
                            foreach ($lecturers as $lecturer) {
                                echo '<option value="' . $lecturer['lecturer_id'] . '">' 
                                . htmlspecialchars(trim($lecturer['fname'] . ' ' . $lecturer['mname'] . ' ' . $lecturer['lname'])) . '</option>';                       
                            }
                        } else {
                            echo '<option value="">No lecturers available</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Courses Dropdown -->
                <div class="mb-4">
                    <label for="course" class="form-label">Select Course</label>
                    <select name="course_id" id="course" class="form-select">
                        <option value="" disabled selected>-- Select Course --</option>
                        <?php
                        if ($courses) {
                            foreach ($courses as $course) {
                                echo '<option value="' . $course['course_id'] . '">' . htmlspecialchars($course['course_name']) . '</option>';
                            }
                        } else {
                            echo '<option value="">No courses available</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="semester" class="form-label">Select Semester</label>
                    <select name="semester_id" id="semester" class="form-select">
                        <option value="" disabled selected>-- Select Semester --</option>
                        <?php
                         if ($semesters) {
                            foreach ($semesters as $semester) {
                                echo '<option value="' . $semester['semester_id'] . '">' . htmlspecialchars($semester['semester_name']) . '</option>';
                            }
                        } else {
                            echo '<option value="">No Semesters available</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="year" class="form-label">Select Year</label>
                    <select name="year_id" id="year" class="form-select">
                        <option value="" disabled selected>-- Select Year --</option>
                        <?php
                        if ($years) {
                            foreach ($years as $year) {
                                echo '<option value="' . $year['year_id'] . '">' . htmlspecialchars($year['year_name']) . '</option>';
                            }
                        } else {
                            echo '<option value="">No Years available</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Enroll</button>
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
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
