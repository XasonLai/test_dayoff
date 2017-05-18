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
		<form method="GET" action="/staffs/staff">
			@foreach($staffs as $key_id => $staff)
				<?php $each_staff = $staff->user_dayoff()->where('check','0')->orderBy('date_start')->get(); ?>
					@if(count($each_staff) != 0 )
						<div class="form-group">
							請假人: <span style="font-size:20px;">{{ $staff ->name }}</span><br>
						</div>
						<div class="form-group">
							<table class="table table-hover">
								<tr>
									<th> 開始時間 </th>
									<th> 結束時間 </th>
									<th> 總共時間 </th>
									<th> 職務代理人 </th>
									<th> 事由 </th>
								</tr>
							@foreach($each_staff as $key => $item)
								
								<tr>
									<td><input type="checkbox" name="check[]" value="{{$item->id}}" >{{$item->date_start}} </td>
									<td>{{$item->date_end}}</td>
									<td> {{$item->day}} 日 {{$item->hour}} 小時 {{$item->minute}} 分鐘 </td>
									<td>{{$item->agent_name}}</td>
									<td> {{$provision_reason[$item->provision_id]}} </td>
								</tr>

							@endforeach
							</table>
						</div>
						<div class="form-group">
							<input type="submit" value="同意" class="btn btn-info">
						</div>
					@endif
			@endforeach
		</form>
	</div>
@endsection