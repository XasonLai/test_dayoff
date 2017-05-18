@foreach($staff_status as  $staff)
	<?php $each_staff = $staff->compensatory()->where('check','1')->orderBy('date')->get(); ?>
		@if(count($each_staff) != 0 )
			<div class="form-group">
				加班人: <span style="font-size:20px;">{{ $staff ->name }}</span><br>
			</div>
			<div class="form-group">
				<table class="table table-hover">
					<tr>
						<th> 日期 </th>
						<th> 加班時間 </th>
						<th> 結束時間 </th>
					</tr>
				@foreach($each_staff as $key => $item)
					<tr>
						<td>{{$item->date}} </td>
						<td>{{$item->time_start}}</td>
						<td>{{$item->time_end}}</td>
						
					</tr>

				@endforeach
				</table>
			</div>
		@endif
@endforeach