<?php  

// Get Lecturer by ID
function getLecturerById($lecturer_id, $conn){
   $sql = "SELECT * FROM lecturers
           WHERE lecturer_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$lecturer_id]);

   if ($stmt->rowCount() == 1) {
     $lecturer = $stmt->fetch();
     return $lecturer;
   }else {
    return 0;
   }
}

