@extends('layouts.app')
@section('title') Create your own challenge @endsection
@section('content')

  <p style=" padding-top: 20px; font-family: 'Raleway', Sans-Serif; font-size: 32px; font-weight: bold;" class="text-center">
    Share your challenge with the world!
  </p>
  <hr style="padding-bottom: 20px;">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
    <form class="form-horizontal" role="form" method="#" action="#">
      <div class="form-group">
          <input type="text" class="form-control" placeholder="Challenge name">
      </div>
      <div class="form-group">
          <textarea type="text" class="form-control" placeholder="Description"></textarea>
      </div>
      <div class="form-group">
          <input type="file" class="form-control" placeholder="Description">
      </div>

      <div class="form-group">
          <select class="form-control" placeholder="Description">
            <option>Choose tool</option>
            <option>Twitter</option>
            <option>QR code</option>
            <option>Google fit</option>
          </select>
      </div>
      <div class="form-group">
          <input type="text" class="form-control" placeholder="Goal">
      </div>
      <div class="form-group pull-right">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Create</button>
      </div>
    </div>
    </form>
  </div><!-- col-md-6 -->
  </div>

@endsection
