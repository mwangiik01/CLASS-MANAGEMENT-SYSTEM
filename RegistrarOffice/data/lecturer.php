<?php

//Get Lecturers By ID
function getLecturerById($lecturer_id, $conn) {
	$sql = "SELECT * FROM lecturers
	        WHERE lecturer_id=?";
	$stmt = $conn->prepare($sql);
    $stmt->execute([$lecturer_id]);
	
	if($stmt->rowCount() == 1) {
	   $lecturers = $stmt->fetch();
	   return $lecturers;
	}else {
		return 0;
	}
}

//All Lecturers
function getAllLecturers($conn) {
	$sql = "SELECT * FROM lecturers";
	$stmt = $conn->prepare($sql);
    $stmt->execute();
	
	if($stmt->rowCount() >= 1) {
	   $lecturers = $stmt->fetchAll();
	   return $lecturers;
	}else {
		return 0;
	}
}

//Check if email is unique
function emailIsUnique($email, $conn, $lecturer_id=0) {
	$sql = "SELECT email, lecturer_id FROM lecturers
	        WHERE email=?";
	$stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
	
	if ($lecturer_id == 0) {
	   if($stmt->rowCount() >= 1) {
	   return 0;
	   }else {
		return 1;
	   }	
	}else {
		if($stmt->rowCount() >= 1) {
	   $lecturers = $stmt->fetch();
	   if ($lecturers['lecturer_id'] == $lecturer_id) {
		   return 1;
	   }else {
		   return 0;
	   }
	   }else {
		return 1;
	   }
	}
}

//DELETE

function removeLecturer($id, $conn) {
	$sql  = "DELETE FROM lecturers
	         WHERE lecturer_id=?";
	$stmt = $conn->prepare($sql);
    $re   = $stmt->execute([$id]);
	if($re) {
	   return 1;
	}else {
		return 0;
	}
}

// Search 
function searchLecturers($key, $conn){
   $key = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$key);
 
   $sql = "SELECT * FROM lecturers
           WHERE lecturer_id LIKE ? 
           OR fname LIKE ?
		   OR mname LIKE ?
           OR lname LIKE ?
		   OR email LIKE ?
		   OR address LIKE ?
           OR phone_number LIKE ?
		   OR employee_number LIKE ?
		   OR qualification LIKE ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$key, $key, $key, $key, $key, $key, $key, $key, $key]);

   if ($stmt->rowCount() >= 1) {
     $lecturers = $stmt->fetchAll();
     return $lecturers;
   }else {
    return 0;
   }
}