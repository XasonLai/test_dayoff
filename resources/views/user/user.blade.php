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
	.necessary{
		display: inline-block;
	    font-size: 10px;
	    background: #e40000;
	    color: #ffffff;
	    margin: 0 10px 0 0;
	    padding: 0px 5px;
	    }
	</style>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css">
@endsection


@section('content')
<div class="container">
	
	@if(session('errors'))   
		<div class="alert alert-danger">                
			<strong>錯誤！</strong>  {{  session('errors')  }}   
		</div>   
	@endif
	<form method="get" action="/staffs/user">
		<input type="radio" name="check" value="2" CHECKED ><span>全部資訊</span>
		<input type="radio" name="check" value="1" {{ ($check_id == '1')? 'checked' : '' }}><span>已核對</span>
		<input type="radio" name="check" value="0" {{ ($check_id == '0')? 'checked' : '' }}><span>未核對</span>
		<input type="submit" value="送出" class="btn btn-success">

	</form>
	<br>
	<table class="table table-hover">
		@if( count($user_dayoff) != 0 )
			<tr>
				<th> 開始日期 </th>
				<th> 結束日期 </th>
				<th> 總共時間 </th>
				<th> 假別 </th>
				<th> 職務代理人 </th>
			</tr>
			@foreach($user_dayoff as $key => $item)
				<tr>
					<td> {{$item->date_start}} </td>
					<td> {{$item->date_end}} </td>
					<td> {{$item->days}} 日 {{$item->hours}} 小時 {{$item->minutes}} 分鐘 </td>
					<td> {{$provision_reason[$item->provision_id]}} </td>
					<td> {{$item->agent_name}} </td>
				</tr>
			@endforeach
		@endif
	</table>
	<div class="spacer_30"></div>
	<hr>
	@if( count($user_compensatorys) != 0 )
		<table class="table table-hover">
			<tr>
		      	<td>加班日期</td>
		      	<td>開始時間</td>
		      	<td>結束時間</td>
		      	<td>總共時間</td>			      
		    </tr>
		      			
			@foreach($user_compensatorys  as $user_compensatory )
				<tr>
					<td>{{$user_compensatory->date}}</td>
					<td>{{$user_compensatory->time_start}}</td>
					<td>{{$user_compensatory->time_end}}</td>
					<td>{{$user_compensatory->hours}} 小時 {{$user_compensatory->minutes}} 分鐘</td>
				</tr>
			@endforeach
		
		</table>
	@endif
	
</div>

@endsection

@section('welcome_js')
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
<script src="/js/data-tables/jquery.dataTables.js"></script>
<script src="/js/data-tables/bootbox.min.js"></script>
<script src="/js/data-tables/DT_bootstrap.js"></script>
@endsection