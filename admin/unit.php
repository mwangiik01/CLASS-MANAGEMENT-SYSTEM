<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/unit.php";
       $units = getAllunits($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - unit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="body-login">
    <?php 
        include "inc/navbar.php";
    ?>
    <div class="container shadow p-4 bg-white">
        <a href="unit-add.php" class="btn btn-dark">Add New Unit</a>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger mt-3 n-table" role="alert">
                <?=$_GET['error']?>
            </div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-info mt-3 n-table" role="alert">
                <?=$_GET['success']?>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Unit Code</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Year</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
    <?php if ($units != 0) { 
        $i = 0; 
        foreach ($units as $unit ) { 
            $i++; ?>
        <tr>
            <th scope="row"><?=$i?></th>
            <td><?=$unit['unit_code']?></td>
            <td><?=$unit['unit_name']?></td>
            <td><?=$unit['semester_name']?></td>
            <td><?=$unit['year_name']?></td> 
            <td>
                <?php if (isset($unit['unit_id'])): ?>
                    <a href="unit-edit.php?unit_id=<?php echo $unit['unit_id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="unit-delete.php?unit_id=<?php echo $unit['unit_id']; ?>" class="btn btn-danger">Delete</a>
                <?php else: ?>
                    <span class="text-danger">Unit ID not found</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php } } else { ?>
        <tr>
            <td colspan="6" class="text-center">No units available.</td>
        </tr>
    <?php } ?>
</tbody>

                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(7) a").addClass('active');
        });
    </script>
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
