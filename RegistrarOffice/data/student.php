<?php 

// All Students 
function getAllstudents($conn){
  $sql = "
      SELECT s.*, c.course_name 
      FROM students s
      LEFT JOIN courses c ON s.course_id = c.course_id
  ";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  if ($stmt->rowCount() >= 1) {
      $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $students;
  } else {
      return 0;
  }
}




// Get Student By Id 
function getStudentById($id, $conn){
   $sql = "SELECT * FROM students
           WHERE student_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() == 1) {
     $student = $stmt->fetch();
     return $student;
   }else {
    return 0;
   }
}


// Check if the username Unique
function unameIsUnique($conn, $student_id=0){
   $sql = "SELECT student_id FROM students
           WHERE student_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$student_id]);
   
   if ($student_id == 0) {
     if ($stmt->rowCount() >= 1) {
       return 0;
     }else {
      return 1;
     }
   }else {
    if ($stmt->rowCount() >= 1) {
       $student = $stmt->fetch();
       if ($student['student_id'] == $student_id) {
         return 1;
       }else {
        return 0;
      }
     }else {
      return 1;
     }
   }
   
}


// Search 
function searchstudents($key, $conn){
   $key = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$key);
   $sql = "SELECT * FROM students
           WHERE student_id LIKE ? 
           OR fname LIKE ?
           OR lname LIKE ?
           OR registration_number LIKE ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$key, $key, $key, $key]);

   if ($stmt->rowCount() == 1) {
     $students = $stmt->fetchAll();
     return $students;
   }else {
    return 0;
   }
}

function removestudent($id, $conn) {
	$sql  = "DELETE FROM studentregistration
	         WHERE newstudent_id=?";
	$stmt = $conn->prepare($sql);
    $re   = $stmt->execute([$id]);
	if($re) {
	   return 1;
	}else {
		return 0;
	}
}