@extends('welcome')

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
@endsection

@section('a_herf')
	@if($personal->staff_id != 0)
		<li><a href="{{ url('/staffs/staff') }}">員工請假核准</a></li>
		<li><a href="{{ url('/staffs/compensatory') }}">員工加班核准</a></li>
		<li><a href="{{ url('/staffs/search') }}">員工近期狀態</a></li>
	@endif
@endsection

@section('content')
	<div class="container">
		<table class="table table-hover">

			<br>
			<span>
				到職日：<?php echo $first_day ?>
			</span>
			<br>
			<span>年資：
				<?php echo "$interval->y"."年" ?>
				<?php echo "$interval->m"."個月又" ?>
				<?php echo "$interval->d"."天" ?>
			</span>
			<br>
			
			<div>
				<form action="/staffs/personal" method="GET">
					<select name="select_dayoff" style="width:200px; margin-right:10px;" >
						<option value=''>請選擇假別</option>
						@foreach($provision as $key => $name)
							<option value="{{$name->id}}" >{{$name->name}}</option>
						@endforeach
						<input type="submit" value="送出" class="btn btn-warning">
					</select>
				</form>
			</div>  
 
		</table>
		
		<div class="content">
			<table class="table table-hover">
				<tr>
					<th>已核准的日期</th>
					<th>總共時間</th>
					<th>假別</th>
				</tr>
				@foreach( $check_dayoff as $key => $item )
					<tr>
						<td>{{ $item->date_start }} 至 {{ $item->date_end }}</td>
						<td>共 {{$item->days}} 日 {{$item->hours}} 小時 {{$item->minutes}} 分鐘</td>
						<td> {{$provision_reason[$item->provision_id]}} </td>
					</tr>
				@endforeach
			</table>
			@if($leftover)
				<div class="form-group">
					<div class="size_t3 s_red">{{$title}}</div>
					<span>剩餘時間 {{$leftover}} 小時</span>
					@if($message)
						<div class="alert alert-danger">                
							<strong>提醒！</strong>  {{  $message  }}   
						</div>  
					@endif
				</div>
			@endif
		</div> <!-- end content -->


	</div>

@endsection


@section('welcome_js')
	<script type="text/javascript">
		jQuery('#datetimepicker').datetimepicker({
			timepicker:false,
			mask:true,
			minDate:'2014/07/24',
			value:'2016/01/01'
			// 預設值

		});
	</script>
@endsection