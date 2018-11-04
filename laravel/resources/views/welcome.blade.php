@extends('layouts.app')
@section('title') Welcome to Widoo @endsection
@section('content')
<div class="container" style="padding-bottom: 30px;">

  <p style=" padding-top: 20px; font-family: 'Raleway', Sans-Serif; font-size: 32px; font-weight: bold;" class="text-center">
    It is easier to do good when we are doing good together
  </p>
  <hr style="padding-bottom: 20px;">

  <div class="row">
    @foreach($challenges as $challenge)
      @if($challenge->type == "wellness")
        <?php $opacity = 0.5; ?>
      @else
        <?php $opacity = 1; ?>
      @endif
      <div class="col-md-6" style="opacity: {{$opacity}}">
        <div class="panel panel-default" style="border-radius: 0px;">
          <div class="panel-heading" style="padding: 0px;">
            <img src="{{$challenge->img}}" class="img-responsive" style="width: 100%; height: 270px; display: block;">
          </div><!-- panel-header -->
          <div class="panel-body" style="margin-top">
            <h1 style="font-size: 18px; margin-top: 0px; font-family: 'Raleway', Sans-Serif;">{{$challenge->name}}</h1>
            <span style="border-radius: 0px; background-color: #3498db;" class="badge">{{$challenge->type}} challenge</span>
            <a style="color: #000; font-size: 11px; font-family: arial;" class="pull-right" href="{{route('get.challenge', $challenge->id)}}">KNOW MORE <i class="fas fa-long-arrow-alt-right"></i></a>
          </div><!-- panel-body -->
        </div><!-- panel-primary -->
      </div><!-- col-md-3 -->
    @endforeach

    <style>
      .create:hover {
        opacity: 1 !important;
        cursor: pointer;
      }
    </style>

    <div class="col-md-6 create" style="opacity: 0.7;">
      <div class="panel panel-default" style="border-radius: 0px;">
        <div class="panel-heading" style="padding: 0px;">
          <a href="{{route('get.create')}}">
            <img src="https://i.imgur.com/gkeP43s.png" class="img-responsive" style="width: 100%; height: 350px; display: block;">
          </a>
        </div><!-- panel-header -->
      </div><!-- panel-primary -->
    </div><!-- col-md-3 -->

  </div><!-- row -->


</div><!-- container -->
@endsection
