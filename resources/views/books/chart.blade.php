@extends('layouts.app')

@section('title', 'Chart')
    
@section('content')
    <h1 style="margin-left:250px">Books Profit</h1>
    <!-- <div id="pop" style="width:800px;border:1px solid black"></div> -->
    <div id="pop" style="width:800px;border:1px solid black;margin:20px auto;">
        {!! $chart->container() !!}
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>

    {!! $chart->script() !!}

@endsection
