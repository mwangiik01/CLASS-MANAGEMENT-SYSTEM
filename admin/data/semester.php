<?php

function getAllsemesters($conn) {
	$sql = "SELECT * FROM semester";
	$stmt = $conn->prepare($sql);
    $stmt->execute();
	
	if($stmt->rowCount() >= 1) {
	   $semesters = $stmt->fetchAll();
	   return $semesters;
	}else {
		return 0;
	}
}


function getsemesterById($semester_id, $conn){
    $sql = "SELECT * FROM semester
            WHERE semester_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$semester_id]);
 
    if ($stmt->rowCount() == 1) {
      $semesters = $stmt->fetch();
      return $semesters;
    }else {
     return 0;
    }
 }