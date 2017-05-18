@foreach($staff_status as  $staff)
	<?php $each_staff = $staff->user_dayoff()->where('check','1')->orderBy('date_start')->get(); ?>
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
						<th> 因素 </th>
					</tr>
				@foreach($each_staff as $key => $item)
					
					<tr>
						<td>{{$item->date_start}} </td>
						<td>{{$item->date_end}}</td>
						<td>{{$item->days}} 日 {{$item->hours}} 小時 {{$item->minutes}} 分鐘 </td>
						<td>{{$item->agent_name}}</td>
						<td>{{$item->provision->first()->name}} </td>
						<td>{{$item->provision_way->first()->name}} </td>
					</tr>

				@endforeach
				</table>
			</div>
		@endif
@endforeach