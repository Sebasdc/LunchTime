@extends('layouts.base')
@section('title')
Boodschappenlijst
@stop
@section("head")
		<script type="text/javascript" src="{{URL::asset('js/Confirm.js')}}"></script>
		<script type="text/javascript" src="{{URL::asset('js/Shoppinglist.js')}}"></script>
		<script type="text/javascript" src="{{URL::asset('js/Errors.js')}}"></script>
@stop
@section('content')
<h1>Boodschappenlijst van {{ date('d M Y',strtotime($shoppinglist->created_at)) }}</h1>
<a href="{{URL::to("boodschappenlijst/lock/{$shoppinglist->id}")}}">
	@if($shoppinglist->locked == 0)
		Vergrendel
	@else
		Ontgrendel
	@endif
</a>
<table class='shoppinglist'>
	<tr><th>Aantal</td><th>Naam</td><th>Gebruiker</td><th>Wijzigen</td><th>Verwijderen</td></tr>

	@foreach($shoppinglist->item as $i => $item)
	<tr data-id="{{$item->id}}">
		<td>{{$item->amount}}x</td>
		<td>{{$item->name}}</td>
		<td>{{$item->user->email}}</td>
		<td><i class="button_edit sudo-button fa fa-2x fa-pencil"></i></td>
		<td><i class="button_delete fa fa-2x fa-trash sudo-button"></i></td>
	</tr>
	@endforeach
	<tr>
		{{Form::open()}}
		<td>{{Form::number('amount', null, array('placeholder' => 'Aantal'))}}</td>
		<td>{{Form::text('New_item', null, array('placeholder' => 'Nieuw Item'))}}</td>
		<td>{{Form::submit('Toevoegen'); Form::close();}}</td>
		<td></td>
		<td></td>
	</tr>
</table>
@stop