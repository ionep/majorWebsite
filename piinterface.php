<?php

	include 'dbHelper.php';

	$d=new Database();
	if(isset($_GET['data']) || isset($_GET['delay']))
	{
		//print_r($_GET);
		if($d->addData($_GET))
		{
			echo 'true';
		}
		else{
			echo 'false';
		}
	}
	else{
		echo 'false';
	}

?>