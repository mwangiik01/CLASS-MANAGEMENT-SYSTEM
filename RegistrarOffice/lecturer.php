<?php 
session_start();
if (isset($_SESSION['r_user_id']) && 
    isset($_SESSION['role'])) {
        
        if ($_SESSION['role'] == 'Registrar Office') {
            include "../DB_connection.php";
            include "data/lecturer.php";
            $lecturers = getAllLecturers($conn);            
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Lecturers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.webp">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    .container{
        max-width: 1500px;
    }
</style>

</head>
<body class="body-login">
    <?php
       include "inc/navbar.php";
       if ($lecturers != 0) {
    ?>
     <div class="container shadow p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <a href="lecturer-add.php" class="btn btn-dark">Add New Lecturer</a>
            <form action="lecturer-search.php" class="d-flex" method="get">
                <input type="text" class="form-control me-2" name="searchKey" placeholder="Search...">
                <button class="btn btn-primary">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </form>
        </div>

        <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?= $_GET['error'] ?>
        </div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-info mt-3" role="alert">
            <?= $_GET['success'] ?>
        </div>
        <?php } ?>

        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Lecturer Email</th>
                        <th scope="col">Department</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; foreach ($lecturers as $lecturer) { $i++; ?>
                    <tr>
                        <th scope="row"><?= $i ?></th>
                        <td><?= $lecturer['lecturer_id'] ?></td>
                        <td>
                            <a href="lecturer-view.php?lecturer_id=<?= $lecturer['lecturer_id'] ?>" class="text-decoration-none">
                                <?= $lecturer['fname'] ?>
                            </a>
                        </td>
                        <td><?= $lecturer['lname'] ?></td>
                        <td><?= $lecturer['email'] ?></td>
                        <td><?= $lecturer['department'] ?></td>
                        <td>
                            <a href="lecturer-edit.php?lecturer_id=<?= $lecturer['lecturer_id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="lecturer-delete.php?lecturer_id=<?= $lecturer['lecturer_id'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } else { ?>
        <div class="alert alert-info mt-5" role="alert">
            No data available.
        </div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#navLinks li:nth-child(2) a").addClass('active');
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
