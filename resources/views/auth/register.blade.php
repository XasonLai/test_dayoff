@extends('welcome')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Register</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						{!! csrf_field() !!}
						<div class="form-group">
							<label class="col-md-4 control-label">Id</label>
							<div class="col-md-6">
								<input type="radio" name="staff_id" value="0" required> 一般人<br>
								<input type="radio" name="staff_id" value="1"> 主管<br>
								<input type="radio" name="staff_id" value="2"> 超級主管<br>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">English_Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="english_name" value="{{ old('english_name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">到職日</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="first_day" name="first_day" value="{{ old('first_day') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Register
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('welcome_js')
	<script type="text/javascript">
		jQuery('#first_day').datetimepicker({
			timepicker:false,
			mask:true,
			format:'Y-m-d',
			minDate:'2014-07-24',
			// value:new Date()
			// 預設值
		});
	</script>
@endsection
