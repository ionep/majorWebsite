<?php
	include 'dbHelper.php';
	$db= new Database();
	$data=$db->fetchByMonth(8);
	$monthData=[];
    $monthLabel=[];
    $i=0;
    foreach($data as $m)
    {
        $monthData[$i]=$data[$i][0];
        $monthLabel[$i]=$data[$i][1];
        $i++;
    }
    $finalData[0]=$monthData;
    $finalData[1]=$monthData;
    echo json_encode($finalData);
?>