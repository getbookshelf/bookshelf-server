<?php
function authenticated($name, $password) {
	include(__DIR__ . '/mysql.php');
	include(__DIR__ . '/../config.php');
	
	$sql = "SELECT passwd_hash FROM users WHERE username='$name'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
    if(hash('sha256', $password . $SALT) == $row['passwd_hash']){
		return true;
	}
	else {
		return false;
	}
}
