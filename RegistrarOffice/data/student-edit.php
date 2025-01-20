<?php
session_start();
if (isset($_SESSION['r_user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Registrar Office') {
    include "../../DB_connection.php";

    if (isset($_POST['update'])) {
        try {
            // Validate required fields
            if (empty($_POST['student_id']) || empty($_POST['registration_number']) || empty($_POST['course_id'])) {
                header("Location: ../student-edit.php?student_id=" . $_POST['student_id'] . "&error=Required fields are missing");
                exit;
            }

            $student_id = $_POST['student_id'];
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
                // Include password field and set it to registration_number
                'password' => $_POST['registration_number'],
            ];

            // Start transaction
            $conn->beginTransaction();

            // Check if the student already exists in the `students` table
            $stmt_check = $conn->prepare("SELECT * FROM students WHERE registration_number = ?");
            $stmt_check->execute([$data['registration_number']]);
            if ($stmt_check->rowCount() > 0) {
                $conn->rollBack();
                header("Location: ../student-edit.php?student_id=$student_id&error=Student already exists in the main records");
                exit;
            }

            // Insert into `students` table
            $stmt_insert = $conn->prepare("
                INSERT INTO students (
                    registration_number, fname, mname, lname, National_ID_Number,
                    KCSE_Index_Number, Passport_Number, gender, date_of_birth,
                    phone_number, postal_code, personal_email, town,
                    postal_address, course_id, password
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt_insert->execute([
                $data['registration_number'], $data['fname'], $data['mname'],
                $data['lname'], $data['National_ID_Number'], $data['KCSE_Index_Number'],
                $data['Passport_Number'], $data['gender'], $data['date_of_birth'],
                $data['phone_number'], $data['postal_code'], $data['personal_email'],
                $data['town'], $data['postal_address'], $data['course_id'], $data['password']
            ]);

            // Delete from `studentregistration` table
            $stmt_delete = $conn->prepare("DELETE FROM studentregistration WHERE student_id = ?");
            $stmt_delete->execute([$student_id]);

            // Commit transaction
            $conn->commit();

            header("Location: ../student-add.php?success=Student moved successfully");
            exit;

        } catch (PDOException $e) {
            $conn->rollBack();
            header("Location: ../student-edit.php?student_id=$student_id&error=" . $e->getMessage());
            exit;
        }
    } else {
        header("Location: ../student-edit.php?error=Invalid request");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
