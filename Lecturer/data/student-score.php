<?php  

// All student_score
function getAllScores($conn){
   $sql = "SELECT * FROM student_score";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $students_score = $stmt->fetchAll();
     return $students_score;
   }else {
    return 0;
   }
}

// Get student_score by ID
function getScoreById($student_id, $Lecturer_ID, $Unit_ID, $semester, $year, $conn){
   $sql = "SELECT * FROM student_score
           WHERE student_id=? AND Lecturer_ID=? AND Unit_ID=? AND semester=? AND year=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$student_id, $Lecturer_ID, $Unit_ID, $semester, $year]);

   if ($stmt->rowCount() == 1) {
     $student_score = $stmt->fetch();
     return $student_score;
   }else {
    return 0;
   }
}