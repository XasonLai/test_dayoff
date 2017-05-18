@extends('welcome')

@section('a_herf')
	@if($personal->staff_id != 0)
		<li><a href="{{ url('/staffs/staff') }}">員工請假核准</a></li>
		<li><a href="{{ url('/staffs/compensatory') }}">員工加班核准</a></li>
		<li><a href="{{ url('/staffs/search') }}">員工近期狀態</a></li>
	@endif
@endsection

@section('content')
<div class="container">
	@if(session('errors'))   
		<div class="alert alert-danger">                
			<strong>錯誤！</strong>  {{  session('errors')  }}   
		</div>   
	@endif
	<table class="table table-hover">
		
		{!! Form::open(['route'=>"staffs.compensatory.store","class"=>"form-horizontal form-row-seperated"]) !!}
			<div class="form-group">
				加班日期: <input type="text" id="date_start" name="compensatory_date" required="required" placeholder="請輸入加班日期">
				起始時間: <input type="text" id="timepicker_start" name="time_start" required="required" placeholder="請輸入開始時間">
				結束時間: <input type="text" id="timepicker_end" name="time_end" required="required" placeholder="請輸入結束時間">
			</div>
			<div class="form-group">
				<input type="submit" value="提交" class="btn btn-primary">
			</div>
		
		{!! Form::close() !!}
	</table>
</div>
@endsection


@section('welcome_js')
<script>
	jQuery(function(){
		$.datetimepicker.setLocale('zh-TW');
		$('#date_start').datetimepicker({
			timepicker:false,
			format:'Y-m-d',
		});

		jQuery('#timepicker_start').datetimepicker({
			format:'H:i',
			datepicker:false,
			step:'30'
		});
		jQuery('#timepicker_end').datetimepicker({
			format:'H:i',
			datepicker:false,
			// onShow:function( ct ){
			// 	this.setOptions({
			// 		allowTimes:[
			// 		  '20:30',
			// 		  '21:00',
			// 		  '21:30',
			// 		  '22:00',
			// 		  '22:30',
			// 		  '23:00',
			// 		  '23:30',
					  
			// 		],

			// 	})
			// },
			step:'30'
		});

		$('#timepicker_start , #timepicker_end' ).on( 'change' , function(){
			var st = $('#timepicker_start');
			var ed = $('#timepicker_end');
			// console.log(ed.val());
			if( this.id == 'timepicker_start' ){
				if( this.value > ed.val() ){
					ed.val(this.value);
				}
			}else if(this.id == 'timepicker_end'){
		        if(this.value < st.val()) {
		          st.val(this.value);
		        }
		     }
		});
	});

</script>


@endsection