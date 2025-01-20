<?php
//All Grades
function getAllGrades($conn) {
	$sql = "SELECT * FROM grades";
	$stmt = $conn->prepare($sql);
    $stmt->execute();
	
	if($stmt->rowCount() >= 1) {
	   $grades = $stmt->fetchAll();
	   return $grades;
	}else {
		return 0;
	}
}

//Get Grade By ID
function getGradeById($Grade_ID, $conn) {
	$sql = "SELECT * FROM grades
	        WHERE Grade_ID=?";
	$stmt = $conn->prepare($sql);
    $stmt->execute([$Grade_ID]);
	
	if($stmt->rowCount() == 1) {
	   $grade = $stmt->fetch();
	   return $grade;
	}else {
		return 0;
	}
}

// DELETE
function removeGrade($id, $conn){
   $sql  = "DELETE FROM grades
           WHERE Grade_ID=?";
   $stmt = $conn->prepare($sql);
   $re   = $stmt->execute([$id]);
   if ($re) {
     return 1;
   }else {
    return 0;
   }
}