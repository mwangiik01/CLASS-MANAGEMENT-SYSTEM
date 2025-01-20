<?php 

// All Students 
// data/student-add.php
function getAllstudentregistration($conn) {
  $sql = "SELECT * FROM studentregistration";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
      return false; // Return false if no students are found
  }
}



// Get Student By Id 
function getStudentById($id, $conn){
   $sql = "SELECT * FROM studentregistration
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
   $sql = "SELECT student_id FROM studentregistration
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
function searchstudentregistration($key, $conn){
   $key = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$key);
   $sql = "SELECT * FROM studentregistration
           WHERE student_id LIKE ? 
           OR fname LIKE ?
           OR address LIKE ?
           OR email LIKE ?
           OR parent_fname LIKE ?
           OR parent_lname LIKE ?
           OR parent_phone_number LIKE ?
           OR lname LIKE ?
           OR username LIKE ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$key, $key, $key, $key, $key, $key, $key, $key, $key]);

   if ($stmt->rowCount() == 1) {
     $studentregistration = $stmt->fetchAll();
     return $studentregistration;
   }else {
    return 0;
   }
}