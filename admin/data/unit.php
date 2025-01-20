<?php

//All Units
function getAllUnits($conn) {
    $sql = "SELECT 
                units.unit_id,
                units.unit_code,
                units.unit_name,
                units.semester_id,   -- Ensure semester_id is included for grouping
                units.year_id,       -- Ensure year_id is included for grouping
                semester.semester_name,
                years.year_name
            FROM 
                units
            JOIN 
                semester ON units.semester_id = semester.semester_id
            JOIN 
                years ON units.year_id = years.year_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Use associative array for easier access
    } else {
        return []; // Return an empty array instead of 0 for consistency
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

// DELETE
function removeUnit($id, $conn){
   $sql  = "DELETE FROM units
           WHERE unit_id=?";
   $stmt = $conn->prepare($sql);
   $re   = $stmt->execute([$id]);
   if ($re) {
     return 1;
   }else {
    return 0;
   }
}

?>
