<?php
session_start();

if (isset($_SESSION['lecturer_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Lecturer') {
        require_once '../../DB_connection.php'; // Update the path accordingly

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Unit ID
            $unit_id = $_POST['unit_id'] ?? null;

            // Check if unit_id exists
            if (!$unit_id) {
                echo "Unit ID is missing!";
                exit;
            }

            // Max Marks
            $maxMarks = [
                'unit_id' => $unit_id,
                'max_cat_1' => $_POST['cat_1_max'] ?? 0,
                'max_cat_2' => $_POST['cat_2_max'] ?? 0,
                'max_cat_3' => $_POST['cat_3_max'] ?? 0,
                'total_cats_max' => $_POST['total_cats_max'] ?? 0,
                'final_cats_max' => $_POST['final_cats_max'] ?? 0,
                'max_assignment_1' => $_POST['assignment_1_max'] ?? 0,
                'max_assignment_2' => $_POST['assignment_2_max'] ?? 0,
                'max_assignment_3' => $_POST['assignment_3_max'] ?? 0,
                'total_assignments_max' => $_POST['total_assignments_max'] ?? 0,
                'final_assignments_max' => $_POST['final_assignments_max'] ?? 0,
                'max_lab_1' => $_POST['lab_1_max'] ?? 0,
                'max_lab_2' => $_POST['lab_2_max'] ?? 0,
                'max_lab_3' => $_POST['lab_3_max'] ?? 0,
                'total_labs_max' => $_POST['total_labs_max'] ?? 0,
                'final_labs_max' => $_POST['final_labs_max'] ?? 0,
            ];

            // Insert or update `unit_max_marks` table
            $query = "INSERT INTO unit_max_marks (
                unit_id, max_cat_1, max_cat_2, max_cat_3, total_cats_max, final_cats_max, 
                max_assignment_1, max_assignment_2, max_assignment_3, total_assignments_max, final_assignments_max, 
                max_lab_1, max_lab_2, max_lab_3, total_labs_max, final_labs_max
            ) VALUES (
                :unit_id, :max_cat_1, :max_cat_2, :max_cat_3, :total_cats_max, :final_cats_max,
                :max_assignment_1, :max_assignment_2, :max_assignment_3, :total_assignments_max, :final_assignments_max,
                :max_lab_1, :max_lab_2, :max_lab_3, :total_labs_max, :final_labs_max
            ) ON DUPLICATE KEY UPDATE 
                max_cat_1 = VALUES(max_cat_1),
                max_cat_2 = VALUES(max_cat_2),
                max_cat_3 = VALUES(max_cat_3),
                total_cats_max = VALUES(total_cats_max),
                final_cats_max = VALUES(final_cats_max),
                max_assignment_1 = VALUES(max_assignment_1),
                max_assignment_2 = VALUES(max_assignment_2),
                max_assignment_3 = VALUES(max_assignment_3),
                total_assignments_max = VALUES(total_assignments_max),
                final_assignments_max = VALUES(final_assignments_max),
                max_lab_1 = VALUES(max_lab_1),
                max_lab_2 = VALUES(max_lab_2),
                max_lab_3 = VALUES(max_lab_3),
                total_labs_max = VALUES(total_labs_max),
                final_labs_max = VALUES(final_labs_max)";
            
            $stmt = $conn->prepare($query);
            // Execute max marks query
            $stmt->execute($maxMarks);

            // Process student marks if provided
            if (isset($_POST['student_marks']) && is_array($_POST['student_marks'])) {
                foreach ($_POST['student_marks'] as $student_id => $marks) {
                    $marks['student_id'] = $student_id;
                    $marks['unit_id'] = $unit_id;

                    $studentQuery = "INSERT INTO student_score (
                        student_id, unit_id, cat_1, cat_2, cat_3, total_cats, final_cat,
                        assignment_1, assignment_2, assignment_3, total_assignments, final_assignment,
                        lab_1, lab_2, lab_3, total_labs, final_lab, main_exam, total_score, semester_id, year_id
                    ) VALUES (
                        :student_id, :unit_id, :cat_1, :cat_2, :cat_3, :total_cats, :final_cat,
                        :assignment_1, :assignment_2, :assignment_3, :total_assignments, :final_assignment,
                        :lab_1, :lab_2, :lab_3, :total_labs, :final_lab, :main_exam, :total_score, :semester_id, :year_id
                    ) ON DUPLICATE KEY UPDATE
                        cat_1 = VALUES(cat_1),
                        cat_2 = VALUES(cat_2),
                        cat_3 = VALUES(cat_3),
                        total_cats = VALUES(total_cats),
                        final_cat = VALUES(final_cat),
                        assignment_1 = VALUES(assignment_1),
                        assignment_2 = VALUES(assignment_2),
                        assignment_3 = VALUES(assignment_3),
                        total_assignments = VALUES(total_assignments),
                        final_assignment = VALUES(final_assignment),
                        lab_1 = VALUES(lab_1),
                        lab_2 = VALUES(lab_2),
                        lab_3 = VALUES(lab_3),
                        total_labs = VALUES(total_labs),
                        final_lab = VALUES(final_lab),
                        main_exam = VALUES(main_exam),
                        total_score = VALUES(total_score),
                        semester_id = VALUES(semester_id),
                        year_id = VALUES(year_id)";
                    
                    $studentStmt = $conn->prepare($studentQuery);

                    // Bind parameters for each student
                    $studentStmt->execute([
                        'student_id' => $marks['student_id'],
                        'unit_id' => $marks['unit_id'],
                        'cat_1' => $marks['cat_1'] ?? 0,
                        'cat_2' => $marks['cat_2'] ?? 0,
                        'cat_3' => $marks['cat_3'] ?? 0,
                        'total_cats' => $marks['total_cats'] ?? 0,
                        'final_cat' => $marks['final_cat'] ?? 0,
                        'assignment_1' => $marks['assignment_1'] ?? 0,
                        'assignment_2' => $marks['assignment_2'] ?? 0,
                        'assignment_3' => $marks['assignment_3'] ?? 0,
                        'total_assignments' => $marks['total_assignments'] ?? 0,
                        'final_assignment' => $marks['final_assignment'] ?? 0,
                        'lab_1' => $marks['lab_1'] ?? 0,
                        'lab_2' => $marks['lab_2'] ?? 0,
                        'lab_3' => $marks['lab_3'] ?? 0,
                        'total_labs' => $marks['total_labs'] ?? 0,
                        'final_lab' => $marks['final_lab'] ?? 0,
                        'main_exam' => $marks['main_exam'] ?? 0,
                        'total_score' => $marks['total_score'] ?? 0,
                        'semester_id' => $marks['semester_id'] ?? 0,
                        'year_id' => $marks['year_id'] ?? 0,
                    ]);
                }
            } else {
                echo "No student marks provided!";
            }

            // Redirect to the grades.php page with the lecturer_id and unit_id in the URL
            header("Location: ../student-grade.php?lecturer_id=" . $_SESSION['lecturer_id'] . "&unit_id=" . $unit_id . "&success=Data successfully updated!");
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
