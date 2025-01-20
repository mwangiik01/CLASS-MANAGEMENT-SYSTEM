<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to enroll fingerprint
function enrollFingerprint($userId, $fingerprintTemplate) {
    global $conn;

    // Check if user already has a fingerprint registered
    $query = "SELECT * FROM fingerprint_templates WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Fingerprint already registered for this user.";
        return;
    }

    // Insert fingerprint template into the database
    $query = "INSERT INTO fingerprint_templates (user_id, fingerprint_data) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $userId, $fingerprintTemplate);

    if ($stmt->execute()) {
        echo "Fingerprint enrolled successfully.";
    } else {
        echo "Error enrolling fingerprint: " . $conn->error;
    }
}

// Function to verify fingerprint
function verifyFingerprint($scannedTemplate) {
    global $conn;

    // Fetch all fingerprint templates from the database
    $query = "SELECT user_id, fingerprint_data FROM fingerprint_templates";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $storedTemplate = $row['fingerprint_data'];
        $userId = $row['user_id'];

        // Match scanned template with stored template (use SDK/API for actual matching)
        if (matchFingerprint($scannedTemplate, $storedTemplate)) {
            echo "Fingerprint matched! User ID: " . $userId;
            return $userId;
        }
    }

    echo "No matching fingerprint found.";
    return null;
}

// Simulated fingerprint matching function (replace with SDK/API logic)
function matchFingerprint($scannedTemplate, $storedTemplate) {
    return $scannedTemplate === $storedTemplate; // Simplified matching for demo
}

// Example usage:
// Enroll fingerprint
if (isset($_POST['enroll'])) {
    $userId = $_POST['user_id'];
    $fingerprintTemplate = $_POST['fingerprint_data']; // This should be fetched from the scanner SDK/API
    enrollFingerprint($userId, $fingerprintTemplate);
}

// Verify fingerprint
if (isset($_POST['verify'])) {
    $scannedTemplate = $_POST['scanned_data']; // This should be fetched from the scanner SDK/API
    verifyFingerprint($scannedTemplate);
}

$conn->close();
?>
