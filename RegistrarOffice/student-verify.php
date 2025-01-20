<?php
session_start();

if (isset($_SESSION['r_user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Registrar Office') {
    include "../DB_connection.php";
    include "data/student-add.php"; // Include the file containing the getAllstudentregistration function

    if (isset($_POST['update'])) {
        try {
            // Start transaction
            $conn->beginTransaction();

            // Fetch all students from the `studentregistration` table using the function
            $students = getAllstudentregistration($conn); // Assuming this function returns an array of students

            if (!$students) {
                header("Location: student-add.php?error=No students found in the registration table");
                exit;
            }

            foreach ($students as $student) {
                $registration_number = $student['registration_number'];
                $student_email = $student['student_email'];

                // Check for uniqueness in both `registration_number` and `student_email`
                $stmt_check = $conn->prepare("
                    SELECT * FROM students 
                    WHERE registration_number = ? OR student_email = ?
                ");
                $stmt_check->execute([$registration_number, $student_email]);

                if ($stmt_check->rowCount() === 0) {
                    // Move the student to the `students` table
                    $stmt_insert = $conn->prepare("
                        INSERT INTO students (
                            registration_number, fname, mname, lname, National_ID_Number,
                            KCSE_Index_Number, Passport_Number, gender, date_of_birth,
                            phone_number, postal_code, personal_email, town,
                            postal_address, course_id, student_email
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmt_insert->execute([
                        $student['registration_number'], $student['fname'], $student['mname'], 
                        $student['lname'], $student['National_ID_Number'], $student['KCSE_Index_Number'], 
                        $student['Passport_Number'], $student['gender'], $student['date_of_birth'], 
                        $student['phone_number'], $student['postal_code'], $student['personal_email'], 
                        $student['town'], $student['postal_address'], $student['course_id'], $student['student_email'],
                    ]);

                    // Delete the student from `studentregistration`
                    $stmt_delete = $conn->prepare("DELETE FROM studentregistration WHERE student_id = ?");
                    $stmt_delete->execute([$student['student_id']]);
                }
            }

            // Commit transaction
            $conn->commit();
            header("Location: student-add.php?success=Students verified and moved successfully");
            exit;

        } catch (PDOException $e) {
            // Roll back the transaction if anything goes wrong
            $conn->rollBack();
            header("Location: student-add.php?error=" . $e->getMessage());
            exit;
        }
    } else {
        header("Location: student-add.php?error=Invalid request");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
