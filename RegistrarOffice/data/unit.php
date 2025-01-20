<?php 

// All Units
function getAllUnits($conn){
   $sql = "SELECT * FROM units";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $units = $stmt->fetchAll();
     return $units;
   }else {
   	return 0;
   }
}

// Get Units by ID
function getSubjectById($Unit_ID, $conn){
   $sql = "SELECT * FROM units
           WHERE Unit_ID=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$Unit_ID]);

   if ($stmt->rowCount() == 1) {
     $subject = $stmt->fetch();
     return $subject;
   }else {
   	return 0;
   }
}

 ?>