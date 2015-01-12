@extends('layouts.main')

@section('title')
Login
@stop

@section('head')
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/login.css')}}" >
@stop

@section('vulling')
<div class="main_page">
	<h1>LunchTime</h1><br>
{{Form::open( array('class' => 'login_form'))}}
	
{{Form::email('email', Input::old('email'), array('placeholder' => 'Email', 'class' => 'login'))}}<br>
{{Form::password('password', array('placeholder' => 'Password', 'class' => 'login'))}}<br><br><br>

	@foreach ($errors->all() as $error)
		<p class="error">{{ $error}}</p>
	@endforeach
{{Form::submit('Login', array('class' => 'color'))}}<br>


{{Form::close()}}
<a class="main_a" href='{{URL::to('account/forgot')}}'><button class="color"><p>Wachtwoord Vergeten</p></button></a>
</div>
@stop