@extends('welcome')

@section('a_herf')
	@if($personal->staff_id != 0)
		<li><a href="{{ url('/staffs/staff') }}">員工請假核准</a></li>
		<li><a href="{{ url('/staffs/compensatory') }}">員工加班核准</a></li>
		<li><a href="{{ url('/staffs/search') }}">員工近期狀態</a></li>
	@endif
@endsection

@section('welcome_css')
@endsection

@section('content')
<div class="container">
	<div>
		<form action="/staffs/provision" method="GET">
			<select name="reason" style="width:200px; margin-right:10px;" >
				<option value=''>請選擇假別</option>
				@foreach($provision as $key => $name)
					<option value="{{$name->id}}" >{{$name->name}}</option>
				@endforeach
				<input type="submit" value="送出" class="btn btn-warning">
			</select>
		</form>
	</div>
	@if( count($provision_title) != 0 && count($provision_detail) != 0 )
		<h4 class="text-left size_t2">{{$provision_title->name}}</h4>
		@include('provision.provision_detail',array('provision_detail' => $provision_detail))

		@if($provision_title->id == 7)
			<div>
				相關規定可參考：
				<a href="http://tcgwww.taipei.gov.tw/public/Data/3111472871.htm">
					臺北市政府勞動局 特別休假試算系統
				</a>
			</div>
		@else
			<div>
				相關規定可參考：
				<a href="http://www.mol.gov.tw/topic/3067/14530/19538/">
					勞動部 -- 勞動基準法相關假別
				</a>
			</div>
		@endif
	@endif
</div>
@endsection