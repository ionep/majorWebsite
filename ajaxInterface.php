<?php
	include 'dbHelper.php';
	$db= new Database();
	$data=$db->fetchByLocation(1);
	echo json_encode($data[0]);
?>