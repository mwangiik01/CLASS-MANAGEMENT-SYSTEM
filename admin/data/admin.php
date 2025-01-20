<?php

function adminPasswordVerify($admin_pass, $conn, $Admin_ID) {
	$sql = "SELECT * FROM admin
	        WHERE Admin_ID=?";
	$stmt = $conn->prepare($sql);
    $stmt->execute([$Admin_ID]);
	
	if($stmt->rowCount() == 1) {
	   $admin = $stmt->fetch();
	   $pass  = $admin['password'];
	   
	if (password_verify($admin_pass, $pass)) {
     	return 1;
     }else {
		return 0;
	}
	}else {
		return 0;
	}
}