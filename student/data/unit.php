<?php

//All Units
function getAllUnits($conn) {
	$sql = "SELECT * FROM units";
	$stmt = $conn->prepare($sql);
    $stmt->execute();
	
	if($stmt->rowCount() >= 1) {
	   $units = $stmt->fetchAll();
	   return $units;
	}else {
		return 0;
	}
}

//Get Units By ID
function getUnitById($unit_id, $conn) {
	$sql = "SELECT * FROM units
	        WHERE unit_id=?";
	$stmt = $conn->prepare($sql);
    $stmt->execute([$unit_id]);
	
	if($stmt->rowCount() == 1) {
	   $unit = $stmt->fetch();
	   return $unit;
	}else {
		return 0;
	}
}  
