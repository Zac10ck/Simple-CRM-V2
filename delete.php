<?php
	include('conn.php');
	$id=$_GET['id'];
	mysqli_query($conn,"delete from client where userid='$id'");
	header('location:dash.php');

?>