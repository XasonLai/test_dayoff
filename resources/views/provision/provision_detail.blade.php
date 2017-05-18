@foreach($provision_detail as $detail)
	<div>
		<div class="text-left size_t4">
			天數：{{$detail->limit_hours / 8 }} 天
		</div>
		@if($detail->name != null)
			<div class="text-left size_t4">
				{{$detail->name}}
			</div>	
		@endif
		@if($detail->suggest != null)
		<div class="text-left size_t4">
			請假方式及證明文件：{!!$detail->suggest!!}
		</div>
		@else
		<div>
			<p>員工在同一事業單位繼續工作滿一定期間者，應給予特別休假</p>
		</div>
		@endif

	</div>
	
	<div class="spacer_30"></div>
@endforeach