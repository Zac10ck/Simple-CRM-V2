<?php
	include('conn.php');
	
	$date=$_POST['date'];
	$client=$_POST['client'];
	$person=$_POST['person'];

	$desig=$_POST['desig'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];
	$activity=$_POST['activity'];

	$remark=$_POST['remark'];
	$followup=$_POST['followup'];
	// $address=$_POST['address'];
	
	mysqli_query($conn,"insert into dar (date, client, person, desig, phone, email,activity,remark,followup) values ('$date', '$client', '$person', '$desig', '$phone','$email','$activity', '$remark','$followup')");
	header('location:search.php');



?>