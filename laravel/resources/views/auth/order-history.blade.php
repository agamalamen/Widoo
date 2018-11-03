@extends('layouts.app')
@section('title') {{Auth::User()->name}} order history @endsection
@section('content')

	<div class="row">
		<div class="col-md-12">
			
			<h1 style="font-size: 24px;">{{Auth::User()->name}} orders</h1>
			<table class="table">
				<tr style="font-weight: bold;">
					<td>#</td>
					<td>Business</td>
					<td>Service</td>
					<td>Cost</td>
					<td>When</td>
					<td>Status</td>
					<td>More</td>
				</tr>
			@foreach(Auth::User()->orders as $order)
				<tr>
					<td>{{$order->id}}</td>
					<td><a target="_blank" href="{{route('get.business', [$order->business->location->name, $order->business->industry->name, $order->business->username,])}}">{{$order->business->name}}</a></td>
					<td>{{$order->service->name}}</td>
					<td>${{$order->service->price}}</td>
					<td>{{date('d, M h:i a', strtotime($order->date))}}</td>
					<td>{{$order->status}}</td>
					<td><a href="{{route('get.track.order', $order->id)}}">See details</a></td>
				</tr>
			@endforeach
			</table>
		</div><!-- col-md-8 -->
		
	</div><!-- row -->
@endsection