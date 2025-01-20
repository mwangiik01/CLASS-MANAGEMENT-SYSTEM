<?php  

// All courses
function getAllCourses($conn, $unit_id = null) {
    if ($unit_id !== null) {
      // Fetch courses linked to a specific unit
      $sql = "
          SELECT c.course_id, c.course_name
          FROM courses c
          JOIN unit_course uc ON c.course_id = uc.course_id
          WHERE uc.unit_id = :unit_id
      ";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':unit_id', $unit_id, PDO::PARAM_INT);
  } else {
      // Fetch all courses if no unit_id is provided
      $sql = "SELECT * FROM courses";
      $stmt = $conn->prepare($sql);
  }
  $stmt->execute();

  if ($stmt->rowCount() >= 1) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
      return [];
  }
}


// Get course by ID
function getCourseById($course_id, $conn){
   $sql = "SELECT * FROM courses
           WHERE course_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$course_id]);

   if ($stmt->rowCount() == 1) {
     $course = $stmt->fetch();
     return $course;
   }else {
    return 0;
   }
}

// DELETE course
function removeCourse($id, $conn){
   $sql  = "DELETE FROM courses
           WHERE course_id=?";
   $stmt = $conn->prepare($sql);
   $re   = $stmt->execute([$id]);
   if ($re) {
     return 1;
   }else {
    return 0;
   }
}