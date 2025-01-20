<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/unit.php";
        
       
        $units = getAllUnits($conn); // Fetch units with all required fields

        // Initialize grouped units by year and semester
        $grouped_units = [];
        
        if ($units) {
            foreach ($units as $unit) {
                $semester_id = $unit['semester_id'] ?? null;
                $year_id = $unit['year_id'] ?? null;
        
                if ($semester_id && $year_id) {
                    $semester_name = ($semester_id == '1') ? 'Sem 1' : (($semester_id == '2') ? 'Sem 2' : 'Unknown Semester');
                    
                    // Initialize year grouping if not set
                    if (!isset($grouped_units[$year_id])) {
                        $grouped_units[$year_id] = [
                            'Sem 1' => [],
                            'Sem 2' => []
                        ];
                    }
        
                    // Add the unit to the respective semester list
                    $grouped_units[$year_id][$semester_name][] = $unit;
                }
            }
        } else {
            $error_message = "No units found in the database.";
        }
        

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Office - Enroll</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .year-section {
            margin: 20px auto;
        }
        .table-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .table-container .table {
            width: 48%; /* Adjust for equal spacing */
            margin: 0 1%;
        }
        h2 {
            text-align: center;
        }
        .unit-section {
            cursor: pointer;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 5px 0;
        }
        .unit-section:hover {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body class="body-login">
    <?php include "inc/navbar.php"; ?>

    <div class="container shadow p-4 bg-white">
        <h1 class="text-center mb-4">Unit Enrolment</h1>

        <?php if (!empty($grouped_units)): ?>
            <?php foreach ($grouped_units as $year_id => $semesters): ?>
                
                <!-- Display Year Name -->
                <?php 
                // Fetch the year name once from the array instead of querying
                $year_name = $semesters['Sem 1'][0]['year_name'] ?? 
                             $semesters['Sem 2'][0]['year_name'] ?? 
                             "Unknown Year";
                ?>
                
                <div class="year-section">
                    <h2 class="text-primary"><?php echo htmlspecialchars($year_name); ?></h2>
                    <div class="table-container">
                        
                        <!-- Semester 1 Table -->
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Semester 1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php if (!empty($semesters['Sem 1'])): ?>
                                            <ul>
                                                <?php foreach ($semesters['Sem 1'] as $unit): ?>
                                                    <li class="unit-section" onclick="window.location.href='enrolment-form.php?unit_id=<?php echo $unit['unit_id']; ?>'">
                                                        <strong><?php echo htmlspecialchars($unit['unit_name']); ?></strong>
                                                        <span class="text-muted">(<?php echo htmlspecialchars($unit['unit_code']); ?>)</span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p>No units available for Semester 1.</p>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Semester 2 Table -->
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Semester 2</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php if (!empty($semesters['Sem 2'])): ?>
                                            <ul>
                                                <?php foreach ($semesters['Sem 2'] as $unit): ?>
                                                    <li class="unit-section" onclick="window.location.href='enrolment-form.php?unit_id=<?php echo $unit['unit_id']; ?>'">
                                                        <strong><?php echo htmlspecialchars($unit['unit_name']); ?></strong>
                                                        <span class="text-muted">(<?php echo htmlspecialchars($unit['unit_code']); ?>)</span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p>No units available for Semester 2.</p>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                No units found. Please add units to display here.
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
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
