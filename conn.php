<?php
 
//MySQLi Procedural
$conn = mysqli_connect("localhost","root","","sample");
if (!$conn) {
	// imap_alerts("error");
	die("Connection failed: " . mysqli_connect_error());
}
 
?>