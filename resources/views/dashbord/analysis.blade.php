<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashbord</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/dashbord.css">
    <link rel="stylesheet" href="/css/styleAnalysis.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <style>
        /* style table */
            #customers {
              font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
              border-collapse: collapse;
              width: 100%;
            }
            
            #customers td, #customers th {
              border: 1px solid #ddd;
              padding: 8px;
            }
            #customers tr:nth-child(even){background-color: #f2f2f2;}
            
            #customers tr:hover {background-color: #ddd;}
            
            #customers th {
              padding-top: 12px;
              padding-bottom: 12px;
              text-align: left;
              background-color: #343A40;
              color: white;
            }
    </style>
</head>


@extends('layouts.app')
@section('content')
<center>
    <div class="row my-4">
        <div class="col-3">
            <form action="/analysis" class="controle-form" method="post">
                {{csrf_field()}}
                    <input type="hidden" name="allResult" value="all">
                    <input type="submit"  class="btn btn-secondary" value="{{trans('language.All the result')}}" required>
            </form>
        </div>
        <div class="col-6">
            <form action="/analysis" class="controle-form" method="post">
                {{csrf_field()}}
                <div class="input-group mb-3" >
                    <div class="input-group-prepend">
                        <div class="input-group-text " style="padding:0 5px">
                            <input type="submit" class="btn " style="padding:0px;margin:0;" name="submit" value="{{trans('language.Valid')}}">
                        </div>
                    </div>
                    <input type="date" max="2030-06-25" min="2019-07-01" name="startDate" class="form-control" style="padding:5px" value="{{session('startDate')}}" required>
                    <input type="date" max="2030-06-25" min="2019-07-01" name="endDate" class="form-control" value="{{session('endDate')}}" required>
                </div>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
    
    <div class="row" >  
            <div class="col-4 mx-4">
                    <canvas id="myChart" width="400" height="400" ></canvas>
            </div>
            <div class="col-3 mt-5 pt-5">
                <h4>{{trans('language.Satisfied')}} : {{$totalSatisfied}}</h4>
                <h4>{{trans('language.A Little Satisfied')}} : {{$totalLittleSatisfied}}</h4>
                <h4>{{trans('language.Unsatisfied')}} : {{$totalUnsatisfied}}</h4>
            </div>
            <div class="col-4">
                    <canvas id="myChart2" width="400" height="400" ></canvas>
            </div>
    </div>
    <table id="customers" class="text-center mt-4">
            <tr >
              <th class="text-center">{{trans('language.Date')}}</th>
              <th class="text-center">{{trans('language.Satisfied')}}</th>
              <th class="text-center">{{trans('language.A Little Satisfied')}}</th>
              <th class="text-center">{{trans('language.Unsatisfied')}}</th>
            </tr>
            @foreach ($numbreViews as $numbreView)
            <tr> 
              <td>{{$numbreView->created_at}}</td>
              <td>{{$numbreView->Satisfied}}</td>
              <td>{{$numbreView->LittleSatisfied}}</td>
              <td>{{$numbreView->Unsatisfied}}</td>
            </tr>
            @endforeach
            <tr>
                <td>{{trans('language.Total')}}</td>
                <td>{{$Satisfieds}}</td>
                <td>{{$LittleSatisfieds}}</td>
                <td>{{$Unsatisfieds}}</td>   
            </tr>   
    </table>
    {{-- {{ $views->links() }} --}}
    {{ $numbreViews->links() }}
    {{-- script chartJs --}}
    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["{{trans('language.Unsatisfied')}}", "{{trans('language.Satisfied')}}", "{{trans('language.A Little Satisfied')}}"],
            datasets: [{
                label: '# of Votes',
                data: [{{$ValueUnsatisfied}} , {{$ValueSatisfied}}, {{$ValueLittleSatisfied}}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>
    {{-- script myChar2 --}}
    <script>
            var ctx = document.getElementById('myChart2').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["{{trans('language.Unsatisfied')}}", "{{trans('language.Satisfied')}}", "{{trans('language.A Little Satisfied')}}"],
                    datasets: [{
                        label: '# of Votes',
                        data: [{{$ValueUnsatisfied}} , {{$ValueSatisfied}}, {{$ValueLittleSatisfied}}],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
            </script>
</center>
@endsection
