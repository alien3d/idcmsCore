<?php
$database="CORE";
$user="db2admin";
$password="123456";
$conn = db2_connect($database, $user, $password);
if(!$conn) { 
	echo "Error Connection";
} else {
	echo "Okay connection";
}
 
?>