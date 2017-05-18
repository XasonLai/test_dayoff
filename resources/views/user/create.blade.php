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
				<strong>警告！</strong>  {{  session('errors')  }}   
			</div>   
		@endif
		
		{!! Form::open(array('url' => '/staffs/store' ,"class"=>"form-horizontal form-row-seperated")) !!}
			<div class="form-body">		
				<div class="form-group">
					<p name="name">Name: <?php echo $personal->name ?></p>
				</div>

				<div class="form-group">
					
					{!! Form::label('date_timepicker_start', 'Start_Date:') !!}
					{!! Form::text('date_timepicker_start', null ,['class' => 'datetpicker form-control' , 'placeholder' => '請輸入開始日期' , 'required' => 'required' ]); !!}
					<!-- Start_Date: <input type="text" id="date_timepicker_start" name="date_start" required="required" placeholder="請輸入開始日期"> -->
					<!-- End_Date: <input type="text" id="date_timepicker_end" name="date_end" required="required" placeholder="請輸入結束日期"> -->
					<!-- 職務代理人: <input type="text" id="" name="agent_name" required="required" placeholder="請輸入同事的名稱"> -->
					
				</div>

				<div class="form-group">
					{!! Form::label('date_timepicker_end', 'End_Date:') !!}
					{!! Form::text('date_timepicker_end', null ,['class' => 'datetpicker form-control' , 'placeholder' => '請輸入結束日期' ,'required' => 'required' ]); !!}
				</div>

				<div class="form-group">
					{!! Form::label('agent_name', '職務代理人:') !!}
					{!! Form::text('agent_name', null ,['class' => 'form-control' , 'placeholder' => '請輸入同事的名稱' ,'required' => 'required' ]); !!}
				</div>

				<div class="form-group">
					{!! Form::label('reason','假別:') !!}
					{!! Form::select('reason' , $provision , null , ['class' => 'form-control' , 'placeholder' => '請選擇假別' , 'required' => 'required'] ) !!}
				</div>

				<div class="form-group">
					{!! Form::label('provision_way','相關原因:') !!}
					{!! Form::select('provision_way',[] , null , ['class' => 'form-control' , 'placeholder' => '相關細項' , 'required' => 'required']) !!}
				</div>
				<hr>
				<div class="form-group">
					<div class="row">
                    	
						<input type="submit" value="提交" class="btn btn-primary">
						
					</div>
				</div>
				
			</div>
		{!! Form::close() !!}
		
	</div>
@endsection

@section('welcome_js')
	<script>
		jQuery(function(){
			jQuery('#date_timepicker_start').datetimepicker({
				format:'Y/m/d H:i',
				onShow:function( ct ){
					this.setOptions({
						maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false,
					})
				},
				step:'30'
			});
			jQuery('#date_timepicker_end').datetimepicker({
				format:'Y/m/d H:i',
				onShow:function( ct ){
					this.setOptions({
						minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false,
					})
				},
				step:'30'
			});
			$('#date_timepicker_start , #date_timepicker_end' ).on( 'change' , function(){
				var st = $('#date_timepicker_start');
				var ed = $('#date_timepicker_end');
				// console.log(ed.val());
				if( this.id == 'date_timepicker_start' ){
					if( this.value > ed.val() ){
						ed.val(this.value);
					}
				}else if(this.id == 'date_timepicker_end'){
			        if(this.value < st.val()) {
			          st.val(this.value);
			        }
			     }
			});
		});

	</script>

	<script type="text/javascript">
		
		$('#reason').on('change',function(e){			
			//抓第一個的value
			var rea_id = e.target.value;

			$.get('/staffs/store/index?rea_id='+rea_id,function(data){
				$('#provision_way').empty();
				$.each(data, function(index,provisionwayObj ){
					$('#provision_way').append('<option value = "'+provisionwayObj.id+'">'+provisionwayObj.name+'</option>');

				});
			});
		});

	</script>

@endsection




