<?php
	include 'dbHelper.php';
	$db= new Database();
    $data=$db->fetchPrediction();    
	echo json_encode($data);
	//hello checking
?>