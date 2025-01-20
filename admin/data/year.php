<?php

function getAllyears($conn) {
    $stmt = $conn->prepare("SELECT * FROM years");  // Adjust the query as per your database structure
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Return all years
}



function getyearById($year_id, $conn){
    $sql = "SELECT * FROM year
            WHERE year_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$year_id]);
 
    if ($stmt->rowCount() == 1) {
      $year = $stmt->fetch();
      return $year;
    }else {
     return 0;
    }
 }

 