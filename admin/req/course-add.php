<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
    	

if (isset($_POST['course_name']) &&
    isset($_POST['course_code'])) {
    
    include '../../DB_connection.php';

    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];

  if (empty($course_name)) {
		$em  = "course name is required";
		header("Location: ../course-add.php?error=$em");
		exit;
	}else if(empty($course_code)) {
    $em  = "course code is required";
    header("Location: ../course-add.php?error=$em");
    exit;
  }else {
        // check if the class already exists
        $sql_check = "SELECT * FROM courses 
                      WHERE course_code=?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute([$course_code]);
        if ($stmt_check->rowCount() > 0) {
           $em  = "The course is already exists";
           header("Location: ../course-add.php?error=$em");
           exit;
        }else {
          $sql  = "INSERT INTO
                 courses(course_name, course_code)
                 VALUES(?,?)";
          $stmt = $conn->prepare($sql);
          $stmt->execute([$course_name, $course_code]);
          $sm = "New course created successfully";
          header("Location: ../course-add.php?success=$sm");
          exit;
        } 
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../course-add.php?error=$em");
    exit;
  }

  }else {
    header("Location: ../../logout.php");
    exit;
  } 
}else {
	header("Location: ../../logout.php");
	exit;
} 