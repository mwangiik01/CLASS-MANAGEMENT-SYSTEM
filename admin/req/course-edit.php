<?php 
session_start();
if (isset($_SESSION['Admin_ID']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
    	

if (isset($_POST['course_name']) &&
    isset($_POST['course_code']) &&
    isset($_POST['course_id'])) {
    
    include '../../DB_connection.php';

    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $course_id = $_POST['course_id'];

    $data = 'course_id='.$course_id;

    if (empty($course_id)) {
        $em  = "course id is required";
        header("Location: ../course-edit.php?error=$em&$data");
        exit;
    }else if (empty($course_name)) {
        $em  = "Course name is required";
        header("Location: ../course-edit.php?error=$em&$data");
        exit;
    }else if (empty($course_code)) {
        $em  = "Course code is required";
        header("Location: ../course-edit.php?error=$em&$data");
        exit;
    }else {
        // check if the class already exists
        $sql_check = "SELECT * FROM courses 
                      WHERE course_code=?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute([$course_code]);
        if ($stmt_check->rowCount() > 0) {
              $courses = $stmt_check->fetch();
             if ($courses['course_id'] == $course_id) {
                $sql  = "UPDATE courses SET course_name=?, course_code=?
                     WHERE course_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$course_name, $course_code, $course_id]);
                $sm = "Course updated successfully";
                header("Location: ../course-edit.php?success=$sm&$data");
                exit;

             }else {
                 $em  = "The course is already exists";
                 header("Location: ../course-edit.php?error=$em&$data");
                 exit;
            }
           
        }else {

            $sql  = "UPDATE courses SET course_name=?, course_code=?
                     WHERE course_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$course_name, $course_code, $course_id]);
            $sm = "Course updated successfully";
            header("Location: ../course-edit.php?success=$sm&$data");
            exit;
       }
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../course.php?error=$em");
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