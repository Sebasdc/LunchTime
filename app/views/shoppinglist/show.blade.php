@extends('layouts.base')
@section('title')
Boodschappenlijst
@stop
@section("head")
		<script type="text/javascript" src="{{URL::asset('js/Confirm.js')}}"></script>
		@if(!$shoppinglist->locked)
			<script type="text/javascript" src="{{URL::asset('js/EditTable.js')}}"></script>
			<script type="text/javascript" src="{{URL::asset('js/Shoppinglist.js')}}"></script>
		@else
			<script type="text/javascript" src="{{URL::asset('js/Check.js')}}"></script>
		@endif
		<script type="text/javascript" src="{{URL::asset('js/Errors.js')}}"></script>
@stop
@section('content')
<h1>Boodschappenlijst van: {{ date('d M Y',strtotime($shoppinglist->created_at)) }}</h1><i class="icon-signal"></i>
<label class="madeby">Aangemaakt door: {{$shoppinglist->user->email}}</label>
<a class="refresh" onClick="window.location.reload()"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Ververs</a><br><br>
<a class="alt" href="{{URL::to("boodschappenlijst/lock/{$shoppinglist->id}/{$shoppinglist->locked}")}}">
	@if($shoppinglist->locked == 0)
		<i class="fa fa-lock">   <p>Vergrendel</p></i>
	@else
		<i class="fa fa-lock">   <p>Ontgrendel</p></i>
	@endif
</a>
<table class='u-full-width shoppinglist'>
	<thead>
		<tr>
			<th>Hoeveelheid</th>
			<th>Naam</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($shoppinglist->item as $i => $item)
		<tr data-id="{{$item->id}}"

			@if($item->checked && $shoppinglist->locked)
				class="active"
			@endif
			>
			<td>{{$item->amount}}</td>
			<td>{{$item->name}}</td>
			<td>
				@if(isset($item->user['email']))
					{{$item->user['email']}}
				@else
					-
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@if(!$shoppinglist->locked)
		{{Form::text('amount', null, array('placeholder' => 'Hoeveelheid', 'class' => 'input_amount item_inp'))}}<br>
		{{Form::text('New_item', null, array('placeholder' => 'Nieuw Item', 'class' => 'input_newname item_inp'))}}<br>
		<button class="button_add submit_input sudo-button">Voeg Toe</button><br>

	@endif
	<a class="button submit_input" href="{{URL::to('/boodschappenlijsten')}}">Terug</a>
@stop