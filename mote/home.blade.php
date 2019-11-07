@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-2">
        @include('inc.sidenav')
    </div>
    <div class="col-md-10" id="main">
        <div class="row">
            <div class="col-md-1"></div>
            <span class="col-md-7">
                <p>Total Water Consumption(L.) - 
                <?php 
                    if(isset($house_id)){
                        echo "House no ".$house_id;
                    }
                    else if(isset($city_name))
                    {
                        echo $city_name;
                    }
                    else {
                        echo "Overall";
                    } 
                ?>
                ({{date('Y')}})
                </p>
            </span>
            <span class="search-bar pull-right col-md-3">
                {!! Form::open(['action' => 'SearchController@search', 'method' => 'POST']) !!}
                    <div class="form-group has-feedback">
                        {{Form::text('house_id', '', ['class' => 'form-control', 'placeholder' => 'Enter Home Id', 'autofocus'=>'true'])}}
                        @if($errors->any())
                            <span class="help-block">
                                <strong style="color:red">{{ $errors->first() }}</strong>
                            </span>
                        @endif
                        <i class="glyphicon glyphicon-search form-control-feedback"></i>
                    </div>
                    {{-- {{Form::submit('Submit', ['class' => 'btn btn-primary col-md-6'])}} --}}
                {!! Form::close() !!}
            </span>
            <span class="col-md-1"></span>
        </div>
        {{-- Format Data for displaying --}}
        <?php
            $noDay=false;
            $noMonth=false;
            $noYear=false;
            if (isset($daily[0]['day'])){
                $day=[];
                $dayData=[];
                $i=0;
                foreach ($daily as $d){
                    $day[$i]=$d['day'];
                    $dayData[$i]=$d['consumption'];
                    $i++;
                }
            }
            else{
                $noDay=true;
            }

            if (isset($monthly[0]['month'])){
                $month=[];
                $monthData=[];
                $i=0;
                foreach ($monthly as $m){
                    $month[$i]=$m['month'];
                    $monthData[$i]=$m['consumption'];
                    $i++;
                }
            }
            else{
                $noMonth=true;
            }

            if (isset($yearly[0]['year'])){
                $year=[];
                $yearData=[];
                $i=0;
                foreach ($yearly as $y){
                    $year[$i]=$y['year'];
                    $yearData[$i]=$y['consumption'];
                    $i++;
                }
            }
            else{
                $noYear=true;
            }
        ?>
        
        {{-- All the charts section --}}
        
        <div class="row">
            <div class="col-md-3 card" style="margin-right:40px;margin-left:40px">
                <p>Daily Consumption ({{date("F")}})</p>
                <canvas id="smallLineChart" style="height:40px;width:40px"></canvas> 
            </div>
            <div class="col-md-3 card" style="margin-right:40px;margin-left:60px">
                <p>Monthly Consumption ({{date("Y")}})</p>
                <canvas id="radarChart" style="height:40px;width:40px;"></canvas>
            </div>
            <div class="col-md-3 card" style="margin-right:40px;margin-left:40px">
                <p>Yearly Consumption</p>
                <canvas id="barChart" style="height:40px;width:40px"></canvas>
            </div>    
        </div>

        {{-- City wise separation --}}
        <?php
            if(!isset($house_id) && !isset($city_name))
            {
        ?>
            <div class="table-responsive">
                <div class="row">
                    <div class="col-md-8"><h2>City Consumption Data</h2></div>
                    <span class="search-bar pull-right col-md-3">
                        {!! Form::open(['action' => 'SearchController@search', 'method' => 'POST']) !!}
                            <div class="form-group has-feedback">
                                {{Form::text('city', '', ['class' => 'form-control', 'placeholder' => 'Enter City Name', 'autofocus'=>'true'])}}
                                @if($errors->any())
                                    <span class="help-block">
                                        <strong style="color:red">{{ $errors->first() }}</strong>
                                    </span>
                                @endif
                                <i class="glyphicon glyphicon-search form-control-feedback"></i>
                            </div>
                            {{-- {{Form::submit('Submit', ['class' => 'btn btn-primary col-md-6'])}} --}}
                        {!! Form::close() !!}
                    </span>
                </div>
                <table class="table table-bordered text-center">
                    <thead>
                        <th class="text-center">SN</th>
                        <th class="text-center">Name of city</th>
                        <th class="text-center">Consumption (litres)</th>
                    </thead>
                    <tbody>
                        {{-- city data for top 5 --}}
                        <?php
                            if(isset($city))
                            {
                                $i=1;
                                foreach($city as $c)
                                {
                                    echo "<tr>
                                            <td>$i</td>
                                            <td>".$c['city']."</td>
                                            <td>".$c['consumption']."</td>
                                        </tr>";
                                    $i++;
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
            }
        ?>
    </div>
</div>
@endsection
