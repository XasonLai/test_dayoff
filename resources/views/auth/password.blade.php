@extends('welcome')

@section('content')
<div class="container">
	<h1 class="s_main_gray txt_size_1_5">輸入註冊時的Email</h1>
	{!! Form::open(['route' => 'forgetpassword.process' , 'method' => 'post']) !!}
		<div class="form-group">
			<label for="email" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
				{!! Form::email('email' , null , ['id' => 'email' , 'class' => 'form-control', 'placeholder' => "Email"]) !!}
			</div>
		</div>
		<div class="form-group">
	    	<div class="col-sm-offset-2 col-sm-10">
				{!!  Form::submit('忘記密碼', ['class' => 'btn btn-block'])  !!}
			</div>
		</div>
	{!! Form::close() !!}
</div>
@endsection