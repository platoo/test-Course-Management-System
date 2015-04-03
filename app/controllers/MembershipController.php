<?php

class MembershipController extends BaseController {

	protected $layout = "layouts.main";

	public function __construct() {

		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
		View::share('active_nav', 'membership');
		
	}

	public function getIndex() {
		if( Auth::user()->role->name == 'Admin' ){
		$data['memberships'] = User::paginate(10);
		$this->layout->content = View::make('memberships.index', $data);
		}else{
			return Redirect::to('course')->with('message', 'Can\'t Access');
		}
	}

	public function getCreate() {

		if( Auth::user()->role->name == 'Admin' ){
			$data['method'] = 'Create';
			$data['roles'] = Role::all();

			$this->layout->content = View::make('memberships.create_edit', $data);
		}else{
			return Redirect::to('membership')->with('message', 'Can\'t Access');
		}
	}

	public function postCreate() {
		if( Auth::user()->role->name == 'Admin' ){

			$rules = array(
				'firstname'=>'required|alpha',
				'lastname'=>'required|alpha',
				'nickname'=>'required|alpha',
				'username'=>'required|unique:users',
				'password'=>'required|alpha_num|between:6,12|confirmed',
				'password_confirmation'=>'required|alpha_num|between:6,12',
				'role'=>'required',
				);

			$validator = Validator::make(Input::all(), $rules );

			if ($validator->passes()) {
    		// validation has passed, save user in DB
				$username = Input::get('username');
				$password = Input::get('password');
				$firstname = Input::get('firstname');
				$lastname = Input::get('lastname');
				$nickname = Input::get('nickname');
				$birthdate = Input::get('birthdate');
				$role = Input::get('role');

		//dd(date("Y-m-d", strtotime($birthdate)));

				$membership = new User;
				$membership->username 			= $username;
				if( trim($password) != '' )
					$membership->password 		= Hash::make( $password );
				$membership->firstname 		= $firstname;
				$membership->lastname 		= $lastname;
				$membership->nickname 		= $nickname;
				$membership->birthdate 			= date("Y-m-d", strtotime($birthdate));
				$membership->role_id 	= $role;
				$membership->save();

				return Redirect::to('membership')->with('message', 'Create complete');
			}else{
			// validation has failed, display error messages 
				return Redirect::to('membership/create')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
			}
		}else{
			return Redirect::to('membership')->with('message', 'Can\'t Access');
		}
	}

	public function getProfile($id) {

		if( Auth::user()->id != $id ){
			return Redirect::to('membership')->with('message', 'Can\'t Access');
		}
		$data['method'] = 'Profile';
		$data['membership'] = User::find($id);
		$data['roles'] = Role::all();
		View::share('active_nav', 'profile');
		$this->layout->content = View::make('memberships.create_edit', $data);
	}

	public function postProfile($id) {
		
		if( Auth::user()->id != $id ){
			return Redirect::to('membership')->with('message', 'Can\'t Access');
		}
		
		$rules = array(
			'firstname'=>'required|alpha',
			'lastname'=>'required|alpha',
			'nickname'=>'required|alpha',
			);

		$validator = Validator::make(Input::all(), $rules );

		if ($validator->passes()) {

			$firstname = Input::get('firstname');
			$lastname = Input::get('lastname');
			$nickname = Input::get('nickname');
			$birthdate = Input::get('birthdate');

		//dd(date("Y-m-d", strtotime($birthdate)));

			$membership = User::find($id);
		// $membership->username 			= $username;
		// if( trim($password) != '' )
			// $membership->password 		= Hash::make( $password );
			$membership->firstname 		= $firstname;
			$membership->lastname 		= $lastname;
			$membership->nickname 		= $nickname;
			$membership->birthdate 			= date("Y-m-d", strtotime($birthdate));
			$membership->save();

			return Redirect::to('membership')->with('message', 'update complete');
		}else{
			// validation has failed, display error messages 
			return Redirect::to('membership/profile/'.$id)->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
		}
	}

	public function getEdit($id) {
		if( Auth::user()->role->name == 'Admin' ){
			$data['method'] = 'Edit';
			$data['membership'] = User::find($id);
			$data['roles'] = Role::all();

			$this->layout->content = View::make('memberships.create_edit', $data);
		}else{
			return Redirect::to('membership')->with('message', 'Can\'t Access');
		}
	}

	public function postEdit($id) {
		if( Auth::user()->role->name == 'Admin' ){

			$rules = array(
				'firstname'=>'required|alpha',
				'lastname'=>'required|alpha',
				'nickname'=>'required|alpha',
				//'username'=>'required|unique:users',
				'password'=>'alpha_num|between:6,12|confirmed',
				'password_confirmation'=>'alpha_num|between:6,12',
				'role'=>'required',
				);

			$validator = Validator::make(Input::all(), $rules );
			if ($validator->passes()) {
			// $username = Input::get('username');
			$password = Input::get('password');
			$firstname = Input::get('firstname');
			$lastname = Input::get('lastname');
			$nickname = Input::get('nickname');
			$birthdate = Input::get('birthdate');
			$role = Input::get('role');

		//dd(date("Y-m-d", strtotime($birthdate)));

			$membership = User::find($id);
			// $membership->username 			= $username;
			if( trim($password) != '' )
				$membership->password 		= Hash::make( $password );
			$membership->firstname 		= $firstname;
			$membership->lastname 		= $lastname;
			$membership->nickname 		= $nickname;
			$membership->birthdate 			= date("Y-m-d", strtotime($birthdate));
			$membership->role_id 	= $role;
			$membership->save();

			return Redirect::to('membership')->with('message', 'update complete');
			}else{
				return Redirect::to('membership/edit/'.$id)->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
			}
		}else{
			return Redirect::to('membership')->with('message', 'Can\'t Access');
		}
	}

	public function getDelete($id) {
		if( Auth::user()->role->name == 'Admin' ){
			$data['method'] = 'Delete';
			$data['roles'] = Role::all();
			$data['membership'] = User::find($id);
			$this->layout->content = View::make('memberships.create_edit', $data);
		}else{
			return Redirect::to('membership')->with('message', 'Can\'t Access');
		}
	}

	public function postDelete($id) {
		if( Auth::user()->role->name == 'Admin' ){
			$membership = User::find($id);
			if(count($membership->courses)){
				return Redirect::to('membership')->with('message', 'Can\'t delete this member');
			}else{
				$membership->delete();
				return Redirect::to('membership')->with('message', 'Delete complete');
			}

		}else{
			return Redirect::to('membership')->with('message', 'Can\'t Access');
		}
		
	}
}
