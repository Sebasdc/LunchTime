<?php

class UserController extends BaseController {

	//Show login form
	public function getLogin(){
		return View::make('account.login');
	}

	//Check if login details are legit
	public function postLogin(){
		$rules = array('email' => 'required', 'password' => 'required');
		$validator = Validator::make(Input::all(), $rules);
		//return login if inputs dont match the rules
		if ($validator->fails()){
			return Redirect::to('login')->withErrors($validator);
		}

		$auth = Auth::attempt(array(
			'email' => Input::get('email'),
			'password' => Input::get('password'),
			'blocked' => 0
		), false);
		//return login if details are not legit
		if (!$auth){
			return Redirect::to('login')->withErrors(array(
				'Verkeerde wachtwoord en/of email <br> Of je account is geblokkeerd'
		));
		}
		//redirect to home when login is legit
		return Redirect::to('/');
	}

	//logout function
	public function logout(){
		Auth::logout();
		return Redirect::intended("login");
	}

	//Show "Mijn account"
	public function show()
	{
		return View::make('account.show')->withUser(Auth::User());
	}

	//Show Wachtwoord wijzigen
	public function showEdit()
	{
		$user = Auth::User();
		return View::make('account.edit');
	}

	//Deals with password reset values.
	public function edit()
	{
		$input = Input::all();
		$user = Auth::User();
		$validator = Validator::make(
	    $input,
	    array(
	    	'old_password' => 'required',
	        'new_password' => 'required|min:8',
	        'new_password_repeat' => 'required|same:new_password'
	    ));
	    $failed = $validator->failed();
	    if ($validator->fails()){
	    	return View::make('account.edit')->withErrors($validator);
	    }
		if(Auth::validate(array('email' => $user->email, 'password' => $input['old_password']))){
			$user->password = Hash::make($input['new_password']);
			$user->save();
		}
		return Redirect::to('/account');
	}

	//Show Wachtwoord reset
	public function showForgot(){
		return View::make('account.forgot');
	}

	//Sends an email to the user with a reset link
	public function Forgot(){
		$input = Input::all();
		$input['key'] = str_random(8);
		$validator = Validator::make($input, array('key' => 'required|unique:users'));
		if($validator->Fails()){ return View::make('account.forgot')->withMessage('Something went wrong, Please try again.'); }
		//Get user and save reset key used in the email
		$user = User::where('email', $input['email'])->First();
		$user->key = $input['key'];
		$user->save();
		$sendto = $user->email;
		//send email to user with reset link
		Mail::send('emails.reset', array('key' => $input['key']), function($message) use ($sendto)
		{
		    $message->to($sendto, $sendto)->from('LunchTime@G51.nl')->subject('Wachtwoord reset LunchTime');
		});
		return "Wachtwoord reset verstuurd";
	}
	//Show password reset when forget key is legit
	public function showReset($string){
		$user = User::where('key', $string)->First();
		if(!isset($user->email)){return "Sorry deze resetlink werkt niet meer.";}
		return View::make('account.reset');
	}
	//Deals with reset password
	public function reset($string){
		$input = Input::all();
		$user = User::where('key', $string)->First();
		$validator = Validator::make(
	    $input,
	    array(
	        'new_password' => 'required|min:8',
	        'new_password_repeat' => 'required|same:new_password'
	    ));
	    $failed = $validator->failed();
	    //return samepage with errors when inputs are not matching the rules
	    if ($validator->fails()){
	    	return View::make('account.reset')->withErrors($validator);
	    }
	    //if forget key is legit and new passwords are legit we save it to the user.
		if(isset($user->email)){
			$user->password = Hash::make($input['new_password']);
			$user->save();
		}
		return Redirect::to('/login');
	}
}