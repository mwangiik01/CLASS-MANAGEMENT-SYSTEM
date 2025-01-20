<?php
session_start();

if (isset($_SESSION['newstudents_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'newstudent') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include '../../DB_connection.php';

            // Retrieve and sanitize inputs
            $fname = htmlspecialchars(trim($_POST['fname']));
            $mname = htmlspecialchars(trim($_POST['mname']));
            $lname = htmlspecialchars(trim($_POST['lname']));
            $national_id_number = htmlspecialchars(trim($_POST['national_id_number']));
            $registration_number = htmlspecialchars(trim($_POST['registration_number']));
            $kcse_index_number = htmlspecialchars(trim($_POST['kcse_index_number']));
            $passport_number = htmlspecialchars(trim($_POST['passport_number']));
            $gender = htmlspecialchars(trim($_POST['gender']));
            $date_of_birth = htmlspecialchars(trim($_POST['date_of_birth']));
            $phone_number = htmlspecialchars(trim($_POST['phone_number']));
            $postal_code = htmlspecialchars(trim($_POST['postal_code']));
            $personal_email = htmlspecialchars(trim($_POST['personal_email']));
            $town = htmlspecialchars(trim($_POST['town']));
            $postal_address = htmlspecialchars(trim($_POST['postal_address']));
            $course_id = htmlspecialchars(trim($_POST['course_id']));

            // Auto-generate registration date
            $registration_date = date('Y-m-d'); // Current date in YYYY-MM-DD format

            // Generate student email (This is now done on the frontend, but we need to handle it here for consistency.)
            $email = htmlspecialchars(trim($_POST['email'])); // Retrieved from the form

            // Insert into database
            $sql = "INSERT INTO studentregistration (
                        fname, mname, lname, National_ID_Number, KCSE_Index_Number, 
                        Passport_Number, gender, date_of_birth, phone_number, 
                        postal_code, personal_email, town, postal_address, 
                        course_id, email, registration_date,registration_number
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

            $stmt = $conn->prepare($sql);
            if ($stmt->execute([
                $fname, $mname, $lname, $national_id_number, $kcse_index_number, 
                $passport_number, $gender, $date_of_birth, $phone_number, 
                $postal_code, $personal_email, $town, $postal_address, 
                $course_id, $email, $registration_date, $registration_number
            ])) {
                $sm = "New student registered successfully.";
                header("Location: ../student-add.php?success=$sm");
                exit;
            } else {
                $em = "Failed to add student.";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            }
        } else {
            header("Location: ../student-add.php?error=Please fill in all required fields.");
            exit;
        }
    } else {
        header("Location: ../../logout.php");
        exit;
    }
} else {
    header("Location: ../../logout.php");
    exit;
}
?>
