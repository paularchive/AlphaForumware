<?php

class UserController extends BaseController {


	/**
	 * Gets the view of the register page
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('user.register');
	}


	/**
	 * Gets the view of the login page
	 *
	 * @return Response
	 */
	public function getLogin()
	{
		return View::make('user.login');
	}

	/**
	 * Posts the data of the login page
	 *
	 * @return Response
	 */
	public function postCreate()
	{

		$rules = array(
			'username' => 'required|unique:users|min:4',
			'pass1' => 'required|min:6',
			'pass2' => 'required|same:pass1'
		);

		$messages = array(
			'username.required' => 'Please enter your username',
			'pass1.required' => 'Please enter your password',
			'pass2.required' => 'Please enter your confirmation password',
			'unique' => 'The :attribute is already registered!',
			'username.min' => 'Your username is to short, make it longer than :min characters',
			'pass1.min' => 'Your password is to short, make it longer than :min characters'
		);

		$validate = Validator::make(Input::all(), $rules, $messages);

		if($validate->fails())
		{
			return Redirect::route('getCreate')->withErrors($validate)->withInput();
		}
		else
		{
			$user = new User();
			$user->username = Input::get('username');
			$user->password = Hash::make(Input::get('pass1'));

			$redirect = Session::get('loginRedirect', 'home');

			if($user->save())
			{
				// Unset the page we were before from the session
    			Session::forget('loginRedirect');

				return Redirect::to($redirect)->with('message', true)->with('msg.type', 'success')->with('msg.header', "Your registration was successful.")->with('msg.message', "You may now log-in with the username you have chosen.");
			}
			else
			{
				return Redirect::route('getCreate')->with('message', true)->with('msg.type', 'negative')->with('msg.header', "An error occured while creating your account.")->with('msg.message', "Please contact an Administrator or try it again.");
			}
		}
	}

	/**
	 * Posts the data of the register page
	 *
	 * @return Response
	 */
	public function postLogin()
	{

		$rules = array(
			'username' => 'required',
			'pass1' => 'required',
		);

		$messages = array(
			'username.required' => 'Your username is required to login!',
			'pass1.required' => 'Your password is required to login!'
		);

		$validate = Validator::make(Input::all(), $rules, $messages);

		if($validate->fails())
		{
			return Redirect::route('getLogin')->withErrors($validate)->withInput();
		}
		else
		{
			$remember = (Input::has('remember')) ? true : false;

			$auth = Auth::attempt(array(
				'username' => Input::get('username'),
				'password' => Input::get('pass1')
			), $remember);

			$redirect = Session::get('loginRedirect', 'home');

			if($auth)
			{
    			// Unset the page we were before from the session
    			Session::forget('loginRedirect');

				return Redirect::to($redirect)->with('message', true)->with('msg.type', 'success')->with('msg.header', "You have logged-in successfully.")->with('msg.message', "You can now post replies and make new topics if you want.");
			}
			else
			{
				return Redirect::route('getLogin')->with('message', true)->with('msg.type', 'negative')->with('msg.header', "You entered the wrong login credentials.")->with('msg.message', "Please check your username and password, and then try it again.");
			}
		}
	}

	public function getLogout()
	{
		Auth::logout();
		$redirect = Session::get('loginRedirect', 'home');
		// Unset the page we were before from the session
    	Session::forget('loginRedirect');

		return Redirect::to($redirect)->with('message', true)->with('msg.type', 'warning')->with('msg.header', "You have logged-out successfully.")->with('msg.message', "You can no longer post replies or topics, but you will still be able to browse on the forum.");
	}

}
