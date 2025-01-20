
<?php
session_start();

if (isset($_SESSION['lecturer_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Lecturer') {
        require_once '../../DB_connection.php'; // Update the path accordingly

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Unit ID
            $unit_id = $_POST['unit_id'] ?? null;      
            $semester_id = $_POST['semester_id'] ?? null;
            $year_id = $_POST['year_id'] ?? null;

            if (!$unit_id || !$semester_id || !$year_id) {
                echo "Unit ID, Semester ID, or Year ID is missing!";
                exit;
        }


            // Process student marks if provided
            if (isset($_POST['student_marks']) && is_array($_POST['student_marks'])) {
                foreach ($_POST['student_marks'] as $student_id => $marks) {
                    $marks['student_id'] = $student_id;
                    $marks['unit_id'] = $unit_id;
                
                    // Add semester_id and year_id for each student
                    $marks['semester_id'] = $semester_id;
                    $marks['year_id'] = $year_id;
                
                    $studentQuery = "INSERT INTO final_results (
                        student_id, unit_id, final_cat, final_assignment, final_lab, main_exam, total_score, semester_id, year_id
                    ) VALUES (
                        :student_id, :unit_id, :final_cat, :final_assignment, :final_lab, :main_exam, :total_score, :semester_id, :year_id
                    ) ON DUPLICATE KEY UPDATE
                        final_cat = VALUES(final_cat),
                        final_assignment = VALUES(final_assignment),
                        final_lab = VALUES(final_lab),
                        main_exam = VALUES(main_exam),
                        total_score = VALUES(total_score),
                        semester_id = VALUES(semester_id),
                        year_id = VALUES(year_id)";
                
                    $studentStmt = $conn->prepare($studentQuery);
                
                    $studentStmt->execute([
                        'student_id' => $marks['student_id'],
                        'unit_id' => $marks['unit_id'],
                        'final_cat' => $marks['final_cat'] ?? 0,
                        'final_assignment' => $marks['final_assignment'] ?? 0,
                        'final_lab' => $marks['final_lab'] ?? 0,
                        'main_exam' => $marks['main_exam'] ?? 0,
                        'total_score' => $marks['total_score'] ?? 0,
                        'semester_id' => $marks['semester_id'], // Use semester_id from the top level
                        'year_id' => $marks['year_id'],         // Use year_id from the top level
                    ]);
                }
                
            } else {
                echo "No student marks provided!";
            }

            // Redirect to the grades.php page with the lecturer_id and unit_id in the URL
            header("Location: ../final-marks.php?lecturer_id=" . $_SESSION['lecturer_id'] . "&unit_id=" . $unit_id . "&success=Results successfully posted!");
            exit;
        } else {
            echo "Invalid request method!";
        }
    } else {
        echo "You do not have permission to perform this action!";
    }
} else {
    echo "Session not started or user not logged in!";
}
