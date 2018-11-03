@extends('layouts.app')
@section('title') {{$challenge->name}} @endsection
@section('content')

  <div class="row">

    <div class="col-md-6">
      <img src="{{$challenge->img}}" class="img-responsive">
    </div><!-- col-md-6 -->
    <div class="col-md-6">
      <h1 style="font-family: 'Raleway', Sans-Serif;">{{$challenge->name}}</h1>
      <p>{{$challenge->description}}</p>
    </div><!-- col-md-6 -->

  </div><!-- row -->

  <div class="progress" style="margin-top: 20px;">
    <div class="progress-bar" role="progressbar" style="width: {{$challenge->contributions->count()/$challenge->goal*100}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
  </div><!-- .progress -->

  <div class="row">
    <div class="col-md-6">
      <h2 style="padding-bottom: 20px;">Leaderboard</h2>
      <ul class="list-unstyled">
        @foreach($users as $user)
          @if($user->contributions($challenge->id)->count() != 0)
            <li><img class="img-responsive" style="margin-right: 10px; width: 50px; height: 45px; display: inline;" src="{{$user->avatar}}" > <span style="text-transform: uppercase;">{{$user->name}}</span> <span class="pull-right" style="font-family: arial; font-size: 24px; font-weight: bold;">{{$user->contributions($challenge->id)->count()}}</span></li>
            <hr>
          @endif
        @endforeach
        @if($challenge->contributions->count() == 0)
          <p class="text-muted" style="font-style: italic;">No contributions yet.</p>
        @endif
      </ul>
    </div><!-- col-md-6 -->

    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <?php
            if($challenge->contributions->count()/$challenge->goal*100 < 100) {
              $success = "text-muted";
            } else {
              $success = "";
            }
           ?>
          <h3 class="text-center {{$success}}" style="text-transform: uppercase;">Achievement Unlocked</h3>
          <p class="{{$success}}">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div><!-- panel-body -->
      </div><!-- .panel -->
      @if($challenge->type == "community")
      <div class="panel panel-default">
        <div class="panel-body">
          <form class="form-inline" action="{{route('post.qr')}}" method="post" enctype="multipart/form-data">
            <p>Upload QR code</p>
            <input type="file" name="qr_code" class="form-control" id="qr_code">
            <input type="hidden" name="challenge_id" value="{{$challenge->id}}">
            <button type="submit" class="btn btn-primary">upload</button>
            {{csrf_field()}}
          </form>
        </div><!-- .panel-body -->
      </div><!-- .panel -->

      @endif
    </div><!-- col-md-6 -->

  </div><!-- row -->


@endsection
