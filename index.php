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
    <link rel="stylesheet" href="css/main.css">
    <title>Flood monitoring system</title>
</head>

<body>
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
        $yearLabel[0]='July';
        if($yearData==false)
        {
            $yearData=['0'];
        }

        $monthDataAll=$db->fetchByMonth(7);
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
    <!-- navigation-bar -->

    <div class="nav-styled">
        <nav class="navbar navbar-expand-lg navbar-light navbar-fixed-top">
            <a class="navbar-brand" href="#">Flood Management</a>
            <div class="btn btn-outline-primary places">
                Places
            </div>
        </nav>
    </div>
    <!-- main-content -->
    <div class="container">
        <div class="main-content">
            <div class="row">
                <div class="data-cards col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="container" id="card-graph-title">
                                <div class="row location-head">
                                    <div class="card-title">
                                        <span id="location">Balkumari,Lalitpur</span>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline">
                                <div id="chart">
                                    <div id="timeline-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="container main-location-container">
            <div class="data-cards col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="container" id="card-graph-title">
                            <div class="row location-head">
                                    <span id="location">Koshi Barrack,Koshi</span>
                            </div>
                        </div>
                        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                    </div>
                </div>
            </div>

            <div class="row location-address">
                <div id="location" class="address-box col-md-8 col-lg-8"><h5 id="real-location">
                    Koshi
                </h5>
                </div>
                <div class="water-level col-md-4 col-lg-4">
                    <div id="changeable" class="indicator-level <?php 
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
                    ?>"></div>
                </div>
            </div>
            <div class="row location-address">
                <div id="location" class="address-box col-md-8 col-lg-8"><h5 id="real-location">
                    Madi
                </h5>
                </div>
                <div class="water-level col-md-4 col-lg-4">
                    <div class="indicator-level ind-grey"></div>
                </div>
            </div>
            <div class="row location-address">
                <div id="location3" class="address-box col-md-8 col-lg-8"><h5 id="real-location">
                    Marsyangdi
                </h5>
                </div>
                <div class="water-level col-md-4 col-lg-4">
                    <div class="indicator-level ind-grey"></div>
                </div>
            </div>
        </div>
    
    </div>
        
    </div>


    <script src="lib/jquery-3.4.1.min.js"></script>
    <script src="lib/bootstrap.bundle.min.js"></script>
    <script src="lib/list.min.js"></script>
    <script src="lib/apexcharts.min.js"></script>
    <script src="lib/d3.v3.min.js"></script>
    <script src="lib/epoch.min.js"></script>
    <script src="lib/canvasjs.min.js"></script>
    <!-- <script src="js/main.js"></script> -->
    <script>
        var yearData=<?php echo json_encode($yearData); ?>;
        var yearLabel=<?php echo json_encode($yearLabel); ?>;
        var monthData=<?php echo json_encode($monthData); ?>;
        for(var i=0;i<monthData.length;i++)
        {
            monthData[i]=parseInt(Math.abs(300-parseFloat(monthData[i])));
        }

        var monthLabel=<?php echo json_encode($monthLabel); ?>;
        var options = {
        chart: {
            type: "bar",
            height: 300,
            foreColor: "#999",
            scroller: {
                enabled: true,
                track: {
                    height: 7,
                    background: '#e0e0e0'
                },
                thumb: {
                    height: 10,
                    background: '#94E3FF'
                },
                scrollButtons: {
                    enabled: true,
                    size: 9,
                    borderWidth: 2,
                    borderColor: '#008FFB',
                    fillColor: '#008FFB'
                },
                padding: {
                    left: 20,
                    right: 10
                }
                },
                stacked: true,
                dropShadow: {
                enabled: true,
                enabledSeries: [0],
                top: -2,
                left: 2,
                blur: 5,
                opacity: 0.06
                }
            },
            colors: ['#00E396', '#0090FF'],
            stroke: {
                curve: "smooth",
                width: 3
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: 'Total Views',
                data: yearData
            }],
            markers: {
                size: 0,
                strokeColor: "#fff",
                strokeWidth: 3,
                strokeOpacity: 1,
                fillOpacity: 1,
                hover: {
                size: 6
                }
            },
            xaxis: {
                categories:yearLabel
            },
            yaxis: {
                labels: {
                offsetX: 24,
                offsetY: -5
                },
                tooltip: {
                enabled: true
                }
            },
            grid: {
                padding: {
                left: -5,
                right: 5
                }
            },
            tooltip: {
                x: {
                format: "dd MMM yyyy"
                },
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left'
            },
            fill: {
                type: "solid",
                fillOpacity: 0.7
            }
        };

        var chart = new ApexCharts(document.querySelector("#timeline-chart"), options);
        chart.render();

        // var chart = new ApexCharts(document.querySelector("#timeline-chart-2"), options);
        // chart.render();

        //second real time chart

        window.onload = function () {
            var dps = []; // dataPoints
            var chart = new CanvasJS.Chart("chartContainer", {
                title :{
                    text: "Real Time Data"
                },
                axisY: {
                    includeZero: false
                },      
                data: [{
                    type: "line",
                    dataPoints: dps
                }]
            });

            var xVal = 0;
            var yVal = 100; 
            var updateInterval = 1000;
            var dataLength = 20; // number of dataPoints visible at any point
            var initialLength=0;

            var updateChart = function (count) {
                ajaxRealTime();
                count = count || 1;

                for (var j = initialLength; j < monthData.length; j++) {
                    // yVal = parseFloat(monthData[j]);
                    yVal=Math.abs(300-parseFloat(monthData[j]));
                    // yVal=yVal = yVal +  Math.round(5 + Math.random() *(-5-5));
                    dps.push({
                        x: xVal,
                        y: yVal
                    });
                    xVal++;
                    initialLength=monthData.length;
                }

                if (dps.length > dataLength) {
                    dps.shift();
                }

                chart.render();
            };

            updateChart(dataLength);
            setInterval(function(){updateChart()}, updateInterval);

            }

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

        function ajaxRealTime(){
            $.ajax({
                    url: 'realTimeInterface.php',
                    success: function(response)
                    {
                        var jsonData=JSON.parse(response);
                        console.log(jsonData[0]);
                        monthData=jsonData[0];
                    }
                });
        }

        $('document').ready(function()
        {
            $('.main-location-container').hide();

            $('.places').click(function(){
                $('.main-location-container').show();
                $('.main-content').hide();
            });
        });
        setInterval("ajaxAlert();", 1000);
        
    </script>
</body>

</html>