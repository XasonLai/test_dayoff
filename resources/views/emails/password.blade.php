@extends('welcome')
@section('content')
點擊此處重置你的密碼：{{ url('password/reset/'.$token) }}
@endsection