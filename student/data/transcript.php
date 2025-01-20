<?php
function getMarksById($student_id, $conn){
    $sql = "SELECT * FROM final_results
            WHERE student_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$student_id]);
 
    if ($stmt->rowCount() == 1) {
      $grade = $stmt->fetch();
      return $grade;
    }else {
     return 0;
    }
 }
?>