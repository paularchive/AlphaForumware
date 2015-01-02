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

			if($user->save())
			{
				return Redirect::route('home')->with('success', 'You registered successfully. You can now log in.');
			}
			else
			{
				return Redirect::route('home')->with('fail', 'An error occured while creating the user. Please try again.');
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
			'username.required' => 'Your username is required to login',
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

			if($auth)
			{
				return Redirect::intended('/')->with('info', 'You are now logged in.');
			}
			else
			{
				return Redirect::route('getLogin')->with('fail', 'You entered the wrong login credentials. Please try again.');
			}
		}
	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::route('home')->with('info', 'You are no longer logged in.');
	}

}
