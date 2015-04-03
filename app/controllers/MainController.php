<?php

class MainController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getIndex()
	{
		//echo Hash::make( 'admin' );
		if(Auth::user()){
			return Redirect::to('course');
		}

		return View::make('login');
	}

	public function postIndex(){
		
		$username = Input::get('username');
		$password = Input::get('password');

		if (Auth::attempt(array('username'=>$username, 'password'=>$password))) {
	    	return Redirect::to('course')->with('message', 'You are now logged in!');
		} else {
	    	return Redirect::to('/')
	        ->with('message', 'Your username/password combination was incorrect')
	        ->withInput();
		}

		// if( $username == 'admin'){
		// 	return Redirect::to('dashboard');
		// }else{
		// 	return Redirect::to('/');
		// }
		// echo $username;
	}

	public function getLogout()
	{
		Auth::logout();
    	return Redirect::to('/')->with('message', 'Your are now logged out!');
	}

}
