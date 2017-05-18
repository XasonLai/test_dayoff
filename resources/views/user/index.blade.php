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

	<form method="get" action="/staffs/user" id='myform'>
		<input type="radio" name="check" value="2" CHECKED ><span>全部資訊</span>
		<input type="radio" name="check" value="1" {{ ($check_id == '1')? 'checked' : '' }}><span>已核對</span>
		<input type="radio" name="check" value="0" {{ ($check_id == '0')? 'checked' : '' }}><span>未核對</span>
		<input type="submit" value="送出" class="btn btn-success">

	</form>
	<br>
	
	<div class="portlet-body">
        <div class="table-container">
		    <table class="table table-hover" id="datatable_ajax2">
                <thead>
                    <tr class="heading">
                    	<th> id </th>
						<th> 開始日期 </th>
						<th> 結束日期 </th>
						<th> 總共時間 </th>
						<th> 職務代理人 </th>
						<th> 狀態 </th>
						
	                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
	
</div>

@endsection

@section('welcome_js')
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
<script src="/js/data-tables/jquery.dataTables.js"></script>
<script src="/js/data-tables/bootbox.min.js"></script>
<script src="/js/data-tables/DT_bootstrap.js"></script>

<script type="text/javascript">
	$(document).ready( function() {
		$('#datatable_ajax2').dataTable({
			'sAjaxSource' : "{{URL::to('staffs/user/data/index')}}",
			"bProcessing" : true,
            "bServerSide" : true,
            fnServerParams : function(aoData){
				$.merge(aoData, $("#myform").serializeArray());
			}
		});

	});

</script>

@endsection