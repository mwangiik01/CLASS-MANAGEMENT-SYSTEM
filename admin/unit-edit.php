<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {

        if (isset($_GET['unit_id'])) {
            include '../DB_connection.php';
            $unit_id = $_GET['unit_id'];
            
            // Fetch the unit details
            $sql = "SELECT * FROM units WHERE unit_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$unit_id]);
            $unit = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($unit) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Unit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="body-login">
    <?php include "inc/navbar.php"; ?>

    <div class="container shadow p-4 bg-white">
        <a href="unit.php" class="btn btn-dark">Go Back</a>

        <form method="post" action="req/unit-edit.php">
            <h3>Edit Unit</h3><hr>

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_GET['error'] ?>
                </div>
            <?php } ?>
            
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?= $_GET['success'] ?>
                </div>
            <?php } ?>

            <input type="hidden" name="unit_id" value="<?= $unit['unit_id'] ?>">

            <div class="mb-3">
                <label class="form-label">Unit Name</label>
                <input type="text" name="unit_name" class="form-control" value="<?= $unit['unit_name'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Unit Code</label>
                <input type="text" name="unit_code" class="form-control" value="<?= $unit['unit_code'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Semester</label>
                <select name="semester_id" class="form-control" required>
                    <option value="">Select Semester</option>
                    <?php
                    $semesters = $conn->query("SELECT * FROM semester")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($semesters as $semester) {
                        $selected = $semester['semester_id'] == $unit['semester_id'] ? 'selected' : '';
                        echo "<option value='{$semester['semester_id']}' $selected>{$semester['semester_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Year</label>
                <select name="year_id" class="form-control" required>
                    <option value="">Select Year</option>
                    <?php
                    $years = $conn->query("SELECT * FROM years")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($years as $year) {
                        $selected = $year['year_id'] == $unit['year_id'] ? 'selected' : '';
                        echo "<option value='{$year['year_id']}' $selected>{$year['year_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 
            } else {
                $em = "Unit not found";
                header("Location: unit.php?error=$em");
                exit;
            }
        } else {
            $em = "Unit ID is required";
            header("Location: unit.php?error=$em");
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
