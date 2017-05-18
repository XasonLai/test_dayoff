@extends('welcome')

@section('a_herf')
	@if($personal->staff_id != 0)
		<li><a href="{{ url('/staffs/staff') }}">員工請假核准</a></li>
		<li><a href="{{ url('/staffs/compensatory') }}">員工加班核准</a></li>
		<li><a href="{{ url('/staffs/search') }}">員工近期狀態</a></li>
	@endif
@endsection

@section('welcome_css')
	<style type="text/css">
		.form-group a{

		}
	</style>
@endsection

@section('content')
	<div class="container">
		{{--@include('user.search_bar' , ['url' => $url ]) --}}
		<div class="form-group size_t2">
			<a style="<?php echo ($id == '1') ? '' : 'color:#ADADAE;font-size:15px;' ?>" href="/staffs/search/1">請假</a>
			<a style="<?php echo ($id == '2') ? '' : 'color:#ADADAE;font-size:15px;' ?>" href="/staffs/search/2">加班</a>
		</div>
		<div class="form-group size_t4">
			@if($id == '1')
				@include('partial.dayoff', ['staff_status' => $staff_status])
			@else
				@include('partial.compensatory', ['staff_status' => $staff_status])
			@endif
		</div>
	</div>
@endsection

