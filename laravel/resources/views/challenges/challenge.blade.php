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

  @if($challenge->type == "positivity")
    <div class="progress" style="margin-top: 20px;">
      <?php
        $progress = 0;
        foreach($tweeters as $tweeter) {
          $progress += $tweeter[1];
        }
       ?>
      <div class="progress-bar" role="progressbar" style="width: {{$progress/$challenge->goal*100}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
      {{$progress/$challenge->goal*100}}%
    </div><!-- .progress -->
  @elseif($challenge->type == "community")
    <div class="progress" style="margin-top: 20px;">
      <?php
        $progress = 0;
        foreach($tweeters as $tweeter) {
          $progress += $tweeter[2][0] + $tweeter[2][1] + $tweeter[2][2];
        }
       ?>
      <div class="progress-bar" role="progressbar" style="width: {{$progress/$challenge->goal*100}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
      {{$progress/$challenge->goal*100}}%
    </div><!-- .progress -->
  @else
    <div class="progress" style="margin-top: 20px;">
      <div class="progress-bar" role="progressbar" style="width: {{$challenge->contributions->count()/$challenge->goal*100}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
      {{$challenge->contributions->count()/$challenge->goal*100}}%
    </div><!-- .progress -->
  @endif

  <div class="row">
    <div class="col-md-6">
      @if($challenge->type == "positivity")

        <?php
          // [['name', 'pos+'], ['name', 'pos+']]
          $size = count($tweeters)-1;
          for ($i=0; $i<$size; $i++) {
            for($j=0; $j<$size-$i; $j++) {
              $k = $j+1;
              if($tweeters[$k][2] > $tweeters[$j][2]) {
                list($tweeters[$j], $tweeters[$k]) = array($tweeters[$k], $tweeters[$j]);
              }
            }
          }
         ?>
        <table class="table">
          <tr style="font-size: 18px;">
            <td>Leaderboard</td>
            <td class="text-center">#</td>
            <td class="text-center">Positivity</td>
          </tr>

        @foreach($tweeters as $tweeter)
          <tr>
            <td style="font-size: 18px;">
                <img style="border-radius: 5px;" src="{{$tweeter[3]}}"> {{$tweeter[0]}}
            </td>
            <td class="text-center" style="font-size: 18px; font-weight: bold;">{{$tweeter[1]}}</td>
            <td class="text-center" style="font-size: 18px; font-weight: bold; color: #2ecc71">+{{$tweeter[2]}}</td>
          </tr>
        @endforeach
        </table>
      @elseif($challenge->type == "community")
        <table class="table">
          <tr style="font-size: 18px;">
            <td>Leaderboard</td>
            <td class="text-center">Checkpoints</td>
          </tr>
          @foreach($tweeters as $tweeter)
            <tr style="font-size: 18px;">
              <td><img style="border-radius: 5px;" src="{{$tweeter[1]}}"> {{$tweeter[0]}}</td>
              <td>
                <div class="row text-center">
                  <div class="col-md-4">
                    {{$tweeter[2][0]}}<br>
                    @if($tweeter[2][0] > 0)
                      <i class="fas fa-circle fa-xs"></i>
                    @else
                      <i class="far fa-circle fa-xs"></i>
                    @endif
                  </div><!-- col-md-4 -->
                  <div class="col-md-4">
                    {{$tweeter[2][1]}} <br>
                    @if($tweeter[2][1] > 0)
                      <i class="fas fa-circle fa-xs"></i>
                    @else
                      <i class="far fa-circle fa-xs"></i>
                    @endif
                  </div><!-- col-md-4 -->
                  <div class="col-md-4">
                    {{$tweeter[2][2]}} <br>
                    @if($tweeter[2][2] > 0)
                      <i class="fas fa-circle fa-xs"></i>
                    @else
                      <i class="far fa-circle fa-xs"></i>
                    @endif
                  </div><!-- col-md-4 -->
                </div><!-- row -->
              </td>
            </tr>
          @endforeach
        </table>
      @else
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

      @endif
    </div><!-- col-md-6 -->

    <div class="col-md-6">
      <div class="panel panel-default text-center">
        <div class="panel-body text-center">
          <?php
            if($progress/$challenge->goal*100 < 100) {
              $success = "text-muted";
            } else {
              $success = "";
            }
           ?>
          <p class="text-center" style="text-align: center !important;">
            @if($success == "")
            <img class="img-responsive" style="width: 80px; height: 80px; margin: 0 auto;" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/29/Gold_Star.svg/1024px-Gold_Star.svg.png">
            @else
            <img class="img-responsive" style="width: 80px; height: 80px; margin: 0 auto;" src="http://purepng.com/public/uploads/large/purepng.com-grey-starstargeometricallydecagonconcavestardomclipartblackgrey-1421526502793oblca.png">
            @endif
          </p>

          <h3 class="text-center {{$success}}" style="text-transform: uppercase;">Achievement
            @if($progress/$challenge->goal*100 < 100)
              Locked
            @else
              Unlocked
            @endif
          </h3>
          <p class="{{$success}}">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div><!-- panel-body -->
      </div><!-- .panel -->
      @if($challenge->type == "community22")

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

      @if($challenge->type == "positivity22")
        <div class="panel panel-default">
          <div class="panel-body">
            @if(Auth::User()->twitter)
              {{Auth::User()->twitter}}
            @else
              <form class="form-inline" method="post" action="{{route('post.twitter')}}">
                <div class="form-group mx-sm-3 mb-2">
                  @<input type="text" class="form-control" name="handler" placeholder="Twitter handler">
                </div>
                <button type="submit" style="background-color: #009CF9;" class="btn btn-primary mb-2">Submit</button>
                {{csrf_field()}}
              </form>
            @endif
          </div><!-- panel -->
        </div><!-- panel -->
      @endif
    </div><!-- col-md-6 -->

  </div><!-- row -->


@endsection
