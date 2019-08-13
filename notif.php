<!DOCTYPE html>
<html>

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- library CSSes -->
    <link rel="stylesheet" href="lib/bootstrap.min.css">
    <link rel="stylesheet" href="lib/epoch.min.css">
    <!--main css-->
    <link rel="stylesheet" href="css/app.css">
    <title>Flood monitoring system</title>
    <?php
        include 'dbHelper.php';

        $db= new Database();

        $yearDataAll=$db->fetchByYear(2019);
        $yearData=[];
        $yearLabel=[];
        $i=0;
        $addedMonth=0;
        foreach($yearDataAll as $y)
        {
            $addedMonth+=$yearDataAll[$i][1];
            // $yearData[$i]=$yearDataAll[$i][1];
            // $yearLabel[$i]=$yearDataAll[$i][3];
            $i++;
        }
        $yearData[0]=$addedMonth/count($yearDataAll[0]);
        $yearLabel[0]='June';
        if($yearData==false)
        {
            $yearData=['0'];
        }

        $monthDataAll=$db->fetchByMonth(8);
        $monthData=[];
        $monthLabel=[];
        $i=0;
        foreach($monthDataAll as $m)
        {
            $monthData[$i]=$monthDataAll[$i][0];
            $monthLabel[$i]=$monthDataAll[$i][1];
            $i++;
        }
        if($monthData==false)
        {
            $monthData=['0'];
        }
    ?>
</head>

<body id="changeable" class="indicator-level <?php 
            $locDataArr=$db->fetchByLocation(1);
            $locData=$locDataArr[0];
            if($locData!=false)
            {
                if($locData<20)
                {
                    echo "ind-red";
                } 
                else if($locData<30)
                {
                    echo "ind-yellow";
                }
                else{
                    echo "ind-blue";
                }
            }
            else{
                echo "ind-grey";
            }
        ?>">
    <div id='warning' style="color:black;margin-top:100px;" class="text-center">
        <h3>Predicted Time: <span id='predictedTime'>0</span> seconds</h3>
        <h3>Predicted Rise: <span id='predictedRise'>0</span> cm</h3>
    </div>

    <script src="lib/jquery-3.4.1.min.js"></script>
    <!-- <script src="js/main.js"></script> -->
    <script>
        // var yearData=<?php echo json_encode($yearData); ?>;
        // var yearLabel=<?php echo json_encode($yearLabel); ?>;
        // var monthData=<?php echo json_encode($monthData); ?>;
        // for(var i=0;i<monthData.length;i++)
        // {
        //     monthData[i]=parseInt(Math.abs(300-parseFloat(monthData[i])));
        // }

        // var monthLabel=<?php echo json_encode($monthLabel); ?>;
        $(document).ready(function(){
            $('#warning').hide();
        });
        
        function ajaxAlert(){
            $.ajax({
                    url: 'ajaxinterface.php',
                    success: function(response)
                    {
                        var jsonData=JSON.parse(response);
                        if(jsonData<20)
                        {
                            $("#changeable").attr("class","indicator-level ind-red");
                        }
                        else if(jsonData<30)
                        {
                            $("#changeable").attr("class","indicator-level ind-yellow");
                        }
                        else{
                            $("#changeable").attr("class","indicator-level ind-blue");
                        }
                    }
                });
        }
        setInterval("ajaxAlert();", 1000);

        function predictAjax(){
            $.ajax({
                    url: 'ajaxPredict.php',
                    success: function(response)
                    {
                        var jsonData=JSON.parse(response);
                        if(jsonData==false){
                            $('#predictedTime').text(0);
                            $('#predictedRise').text(0);
                            $('#warning').hide();
                        }
                        for(var key in jsonData)
                        {
                            if(jsonData.hasOwnProperty(key))
                            {
                                $('#predictedTime').text(jsonData[0][1]);
                                $('#predictedRise').text(jsonData[0][2]);
                                $('#warning').show();
                            }
                        }
                    }
                });
        }
        setInterval("predictAjax();", 1000);
        
    </script>
</body>

</html>