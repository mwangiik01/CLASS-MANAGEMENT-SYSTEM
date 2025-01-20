<?php 
session_start();

if (isset($_SESSION['student_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Student') {
        include "../DB_connection.php";
        include "data/student.php";
        include "data/unit.php";
        include "data/grade.php";
        include "data/transcript.php";
        
        $student_id = $_SESSION['student_id'];
        
        // Get the student's grades along with the corresponding units and years
        $query = "
            SELECT fr.unit_id, u.unit_name, fr.final_cat, fr.final_assignment, fr.final_lab, fr.main_exam, fr.total_score, u.year_id
            FROM final_results fr
            JOIN units u ON fr.unit_id = u.unit_id
            WHERE fr.student_id = ?
            ORDER BY u.year_id DESC
        ";
        $stmt = $conn->prepare($query);
        $stmt->execute([$student_id]);
        $results = $stmt->fetchAll();
        
        // Group the results by year
        $grades_by_year = [];
        foreach ($results as $result) {
            $grades_by_year[$result['year_id']][] = $result;
        }
    ?>
<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Students Enrolled in <?php echo htmlspecialchars($student['fname']); ?></title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.webp">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
        .container {
            max-width: 1200px;
            margin: 20px auto;
            border: 2px solid red;
            border-radius: 10px;
            margin-top: 5px;
        }
    </style>

</head>
<body class="body-login">
    <?php include "inc/navbar.php"; ?>

    <div class="container shadow p-4 bg-white">
        <h2>Your Grades</h2>

        <?php
        // Check if there are grades available for each year
        foreach ($grades_by_year as $year_id => $grades) {
            // Fetch the year name
            $year_query = "SELECT year_name FROM years WHERE year_id = ?";
            $year_stmt = $conn->prepare($year_query);
            $year_stmt->execute([$year_id]);
            $year = $year_stmt->fetch();
            $year_name = $year['year_name'];
            
            // Display the year as the heading
            echo "<h3>$year_name</h3>";
            
            // Check if there are units for this year
            if (count($grades) > 0) {
                echo "<table class='table table-bordered'>";
                echo "<thead><tr><th>Unit Name</th><th>CAT</th><th>Assignment</th><th>Lab</th><th>Exam</th><th>Total Marks</th></tr></thead><tbody>";
                
                // Loop through each unit and display grades
                foreach ($grades as $grade) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($grade['unit_name']) . "</td>";
                    echo "<td>" . $grade['final_cat'] . "</td>";
                    echo "<td>" . $grade['final_assignment'] . "</td>";
                    echo "<td>" . $grade['final_lab'] . "</td>";
                    echo "<td>" . $grade['main_exam'] . "</td>";
                    echo "<td>" . $grade['total_score'] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>No Units done for this year.</p>";
            }
        }
        ?>

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
