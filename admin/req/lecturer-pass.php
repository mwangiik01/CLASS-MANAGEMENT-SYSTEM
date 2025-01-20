<?php
require_once '../../DB_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lecturer_id = $_POST['lecturer_id'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Validate passwords match
    if ($new_password !== $confirm_new_password) {
        header("Location: ../lecturer-pass.php?error=Passwords do not match!&lecturer_id=$lecturer_id");
        exit;
    }

    // Validate password strength
    if (!isValidPassword($new_password)) {
        header("Location: ../lecturer-pass.php?error=Password must be at least 8 characters, including one uppercase letter and one number.&lecturer_id=$lecturer_id");
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    try {
        // Update password in the database
        $sql = "UPDATE lecturers SET password = ? WHERE lecturer_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$hashed_password, $lecturer_id]);

        // Redirect back with success message
        header("Location: ../lecturer-pass.php?success=Password reset successfully&lecturer_id=$lecturer_id");
        exit;
    } catch (PDOException $e) {
        header("Location: ../lecturer-pass.php?error=An error occurred: " . $e->getMessage() . "&lecturer_id=$lecturer_id");
        exit;
    }
} else {
    header("Location: ../lecturer-pass.php?error=Invalid request");
    exit;
}

function isValidPassword($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/', $password);
}
?>
