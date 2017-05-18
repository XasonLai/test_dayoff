@extends('welcome')
@section('content')
<div class="container">
	<h1 class="s_main_gray txt_size_1_5">重設密碼</h1>
	{!!  Form::open(['route'  =>  'resetpassword.process', 'method' => 'post',  'class' => "form-horizontal"])  !!}
		{!!  Form::hidden('token', $token)  !!}
		<div class="form-group">
			<label for="email" class="col-sm-2 control-label">Email</label>
	    	<div class="col-sm-10">
				{!!  Form::email('email', null, ['id'  => 'email', 'class' => 'form-control', 'placeholder' => "Email"])  !!}
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-sm-2 control-label">新密碼</label>
	    	<div class="col-sm-10">
				{!!  Form::password('password', null ,['id'  => 'password', 'class' => 'form-control', 'placeholder' => "Password"])  !!}
			</div>
		</div>
		<div class="form-group">
			<label for="password_confirmation" class="col-sm-2 control-label">確認新密碼</label>
	    	<div class="col-sm-10">
				{!!  Form::password('password_confirmation', null ,['id'  => 'password_confirmation', 'class' => 'form-control', 'placeholder' => "Password confirmation"])  !!}
			</div>
		</div>
		<div class="form-group">
	    	<div class="col-sm-offset-2 col-sm-10">
				{!!  Form::submit('重設密碼', ['class' => 'btn btn-block'])  !!}
			</div>
		</div>
	{!!  Form::close()  !!}
</div>
@endsection