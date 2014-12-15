@extends('layouts.base')

@section('title')
Mijn Account
@stop

@section('content')
<h1>Mijn gegevens</h1>
<label>E-mail: </label><p> {{$user->email}}</p>
<label>Status: </label><p>
	@if(Auth::User()->admin)
		<p>Beheerder.</p>
	@else
		<p>Gebruiker.</p>
	@endif
</p>

<a href="{{URL::to('account/edit')}}">Wachtwoord wijzigen</a><br>
@if($user->admin)

@endif
@stop