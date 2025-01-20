<?php
session_start();
if (isset($_SESSION['r_user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Registrar Office') {
    include "../../DB_connection.php";

    if (isset($_POST['update'])) {
        try {
            // Validate required fields
            if (
                empty($_POST['newstudent_id']) ||
                empty($_POST['registration_number']) ||
                empty($_POST['course_id']) ||
                empty($_POST['email'])) {
                header("Location: ../student-edit.php?newstudent_id=" . $_POST['newstudent_id'] . "&error=Required fields are missing");
                exit;
            }

            $newstudent_id = $_POST['newstudent_id'];
            $data = [
                'registration_number' => $_POST['registration_number'],
                'fname' => $_POST['fname'] ?? null,
                'mname' => $_POST['mname'] ?? null,
                'lname' => $_POST['lname'] ?? null,
                'National_ID_Number' => $_POST['National_ID_Number'] ?? null,
                'KCSE_Index_Number' => $_POST['KCSE_Index_Number'] ?? null,
                'Passport_Number' => $_POST['Passport_Number'] ?? null,
                'gender' => $_POST['gender'] ?? null,
                'date_of_birth' => $_POST['date_of_birth'] ?? null,
                'phone_number' => $_POST['phone_number'] ?? null,
                'postal_code' => $_POST['postal_code'] ?? null,
                'personal_email' => $_POST['personal_email'] ?? null,
                'town' => $_POST['town'] ?? null,
                'postal_address' => $_POST['postal_address'] ?? null,
                'course_id' => $_POST['course_id'],
                'email' => $_POST['email'] ?? null,
                // Use registration_number as password and hash it
                'password' => password_hash($_POST['registration_number'], PASSWORD_DEFAULT),
            ];

            // Start a transaction to ensure data integrity
            $conn->beginTransaction();

            // Check if the student already exists in the `students` table (to avoid duplicates)
            $stmt_check = $conn->prepare("SELECT * FROM students WHERE registration_number = ?");
            $stmt_check->execute([$data['registration_number']]);
            if ($stmt_check->rowCount() > 0) {
                $conn->rollBack();
                header("Location: ../student-edit.php?newstudent_id=$newstudent_id&error=Student already exists in the main records");
                exit;
            }

            // Insert the student into the `students` table
            $stmt_insert = $conn->prepare("
                INSERT INTO students (
                    registration_number, fname, mname, lname, National_ID_Number,
                    KCSE_Index_Number, Passport_Number, gender, date_of_birth,
                    phone_number, postal_code, personal_email, town,
                    postal_address, course_id, email, password
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt_insert->execute([
                $data['registration_number'], $data['fname'], $data['mname'],
                $data['lname'], $data['National_ID_Number'], $data['KCSE_Index_Number'],
                $data['Passport_Number'], $data['gender'], $data['date_of_birth'],
                $data['phone_number'], $data['postal_code'], $data['personal_email'],
                $data['town'], $data['postal_address'], $data['course_id'],
                $data['email'], $data['password']
            ]);

            // Delete the student from the `studentregistration` table (since they are now in `students`)
            $stmt_delete = $conn->prepare("DELETE FROM studentregistration WHERE newstudent_id = ?");
            $stmt_delete->execute([$newstudent_id]);

            // Commit the transaction
            $conn->commit();

            // Redirect with a success message
            header("Location: ../student-add.php?success=Student moved successfully");
            exit;

        } catch (PDOException $e) {
            // Rollback the transaction if an error occurs
            $conn->rollBack();
            header("Location: ../student-edit.php?newstudent_id=$newstudent_id&error=" . $e->getMessage());
            exit;
        }
    } else {
        // If the form is not submitted correctly
        header("Location: ../student-edit.php?error=Invalid request");
        exit;
    }
} else {
    // Redirect if the user is not logged in as the Registrar Office
    header("Location: ../login.php");
    exit;
}
