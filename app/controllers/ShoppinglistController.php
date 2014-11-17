<?php

class ShoppinglistController extends BaseController {

public function show($id){

	$shoppinglist = Shoppinglist::find($id);
	return View::make('Shoppinglist.show')->withShoppinglist($shoppinglist);
}

public function delete($lijst_id, $item_id)
{
	Item::destroy($item_id);
	return "Ja!";
}

public function getNew()
{
	$shoppinglists = Shoppinglist::all();
	return View::make('new')->withShoppinglists($shoppinglists);
}

public function postNew(){


	$shoppinglist = new shoppinglist;
	$shoppinglist->user_id = Auth::User()->id;
	$shoppinglist->save();

	return Redirect::intended('/boodschappenlijsten');
}

public function lock($id){
	$list = Shoppinglist::find($id);
	if($list->locked == 1){ $list->locked = 0; }
	else{ $list->locked = 1; }
	$list->save();
	return Redirect::to('boodschappenlijst/'. $id);
}
 
public function newItem($shoppinglist_id){
	$input= Input::all();
	$item = new Item();
	$item->name = $input['name'];
	$item->amount = $input['amount'];
	$item->user_id = Auth::User()->id;
	$item->shoppinglist_id = $shoppinglist_id;
	$item->save();
	return "Success||" . Auth::User()->email;
}


public function editItem($lijst_id, $id)
{
	$data = Input::all();
	$item = Item::find($id);
	$item->name = $data['name'];
	$item->amount = $data['amount'];
	$item->save();
	return "Success";
}

public function editItem($lijst_id,$item_id){
	$item = Item::find($item_id);
	return View::make('shoppinglist.edit')->withItem($item);
}
public function saveItem($lijst_id,$item_id){
	$input = Input::all();
	$item = Item::find($item_id);
	$item->name = $input['name'];
	$item->amount = $input['amount'];
	$item->save();
	return Redirect::to('/boodschappenlijst/' . $lijst_id);
}
}
?>