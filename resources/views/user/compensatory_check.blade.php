@extends('welcome')

@section('a_herf')
	@if($personal->staff_id != 0)
		<li><a href="{{ url('/staffs/staff') }}">員工請假核准</a></li>
		<li><a href="{{ url('/staffs/compensatory') }}">員工加班核准</a></li>
		<li><a href="{{ url('/staffs/search') }}">員工近期狀態</a></li>
	@endif
@endsection

@section('welcome_css')
<style>
input[type=checkbox], input[type=radio] {
    margin: 4px 5px 0;
    margin-top: 1px\9;
    line-height: normal;
}
</style>

@endsection

@section('content')
<div class="container">
	
	<!-- <form method="GET" action="/staffs/compensatory/update"> -->
		@foreach($staffs as $key_id => $staff)
			<?php $each_staff = $staff->compensatory()->where('check','<>','1')->orderBy('date')->get(); ?>
				@if(count($each_staff) != 0 )
					<div class="form-group">
						加班人: <span style="font-size:20px;">{{ $staff ->name }}</span><br>
					</div>
					<div class="form-group">
						<table class="table table-hover">
							<tr>
								<th> 加班日期 </th>
								<th> 加班時間 </th>
								<th> 時間計算 </th>
								<th></th>
							</tr>
						@foreach($each_staff as $key => $item)
							@if( $item->check == 0 )
								<tr>
									<td> {{$item->date}} </td>
									<td>{{$item->time_start}} 至 {{$item->time_end}}</td>
									<td>  {{$item->hours}} 小時 {{$item->minutes}} 分鐘 </td>
									<td>
										<a href="/staffs/compensatory/update/{{$item->id}}" class="btn btn-info">同意</a>
										<a href="/staffs/compensatory/{{$item->id}}" class="btn btn-warning">不同意</a>

									</td>
								</tr>
							@endif
						@endforeach
						</table>
					</div>

				@endif
		@endforeach
	<!-- </form> -->
	
</div>

@endsection