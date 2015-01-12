<?php

class UserController extends BaseController {


	/**
	 * Gets the view of the register page
	 *
	 * @return Response
	 */
	public function getRegister()
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
	 * Register the user
	 *
	 * @return Response
	 */
	public function postRegister()
	{
		$rules = array(
			'username' => 'required|unique:users,username|min:4',
			'email'    => 'required|unique:users,email|email',
			'pass1'    => 'required|min:6',
			'pass2'	   => 'required|same:pass1'
		);

		$messages = array(
			'username.required' => "You didn't enter your username.",
			'email.required' 	=> "You didn't enter your email address.",
			'pass1.required' 	=> "You didn't enter your password.",
			'pass2.required' 	=> "You need to confirm your password.",
			'unique' 			=> "Somebody already registered with that :attribute.",
			'email'				=> "You didn't enter a valid email address.",
			'username.min' 		=> "Your username is to short, make it longer than :min characters.",
			'pass1.min' 		=> "Your password is to short, make it longer than :min characters."
		);

		$validate = Validator::make(Input::all(), $rules, $messages);
		if($validate->fails())
		{
			return Redirect::route('user.register')->withErrors($validate)->withInput();
		}
		
		//Validation succeed continue with the progress
	    $user = Sentry::createUser(array(
	        'username' 	=> Input::get('username'),
	        'email'    	=> Input::get('email'),
	        'password' 	=> Input::get('pass1'),
	        'activated' => true
	    ), true);
		
		//We registed the user successfully
		if($user)
		{
			$redirect = Session::get('loginRedirect', '/');
			// Unset the page we were before from the session
	    	Session::forget('loginRedirect');

			return Redirect::to($redirect)
			->with('message', true)
			->with('msg.type', 'success')
			->with('msg.header', "Your registration was successful.")
			->with('msg.message', "You may now log-in with the username you have chosen.");
		}
		//Something went wrong while registering DURP!!
		else
			return Redirect::route('user.register')
			->with('message', true)
			->with('msg.type', 'negative')
			->with('msg.header', "An error occured!")
			->with('msg.message', "Something went wrong while creating your account.");
	}


	/**
	 * Log-in the user
	 *
	 * @return Response
	 */
	public function postLogin()
	{

		$rules = array(
			'email' => 'required|email',
			'pass1' => 'required',
		);

		$messages = array(
			'email.required' => "You didn't enter your email address.",
			'pass1.required' => "You didn't enter your password.",
			'email'			 => "You didn't enter a valid email address."
		);

		$validate = Validator::make(Input::all(), $rules, $messages);
		if($validate->fails())
		{
			return Redirect::route('user.login')->withErrors($validate)->withInput();
		}

		//Validation succeed continue
		try
		{
			$remember = (Input::has('remember')) ? true : false;

		    $credentials = array(
		        'email'    => Input::get('email'),
		        'password' => Input::get('pass1'),
		    );

		    // Authenticate the user
		    $user = Sentry::authenticate($credentials, $remember);
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
		    return Redirect::route('user.login')
		    ->withErrors(array('pass1' =>  "It looks like you entered the wrong password."))
		    ->withInput();
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    return Redirect::route('user.login')
		    ->withErrors(array('email' =>  "It looks like there's no user with this email address."))
		    ->withInput();
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
		    return Redirect::route('user.login')
		    ->with('message', true)
		    ->with('msg.type', 'info')
		    ->with('msg.header', "Account isn't activated yet!")
		    ->with('msg.message', "Please check your email and activate your account.");
		}
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
		    return Redirect::route('user.login')
		    ->with('message', true)
		    ->with('msg.type', 'info')
		    ->with('msg.header', "Account Suspended.")
		    ->with('msg.message', "It looks like your account has been suspended.");
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
		    return Redirect::route('user.login')
		    ->with('message', true)->with('msg.type', 'negative')
		    ->with('msg.header', "You entered the wrong login credentials.")
		    ->with('msg.message', "It looks like your account has been banned.");
		}

		//We are now logged-in!!!
		if($user)
		{
			$redirect = Session::get('loginRedirect', '/');
			// Unset the page we were before from the session
    		Session::forget('loginRedirect');
    	
			return Redirect::to($redirect)
			->with('message', true)
			->with('msg.type', 'success')
			->with('msg.header', "You have logged-in successfully.")
			->with('msg.message', "You can now post replies and make new topics if you want.");
		}
		//Something went wrong while authenticating, looks like database is down! WE FAILED!!!!!!
		else
			return Redirect::route('user.login')
			->with('message', true)
			->with('msg.type', 'negative')
			->with('msg.header', "An error occured!")
			->with('msg.message', "Something went wrong while loggin-in, please try it again.")
			->withInput();
	}


	/**
	 * Simply log-out the user and send them a log-out message :D
	 *
	 * @return Response
	 */
	public function getLogout()
	{
		Sentry::logout();
		$redirect = Session::get('loginRedirect', '/');
		// Unset the page we were before from the session
    	Session::forget('loginRedirect');

		return Redirect::to($redirect)
		->with('message', true)
		->with('msg.type', 'warning')
		->with('msg.header', "You have logged-out successfully.")
		->with('msg.message', "You can no longer post replies or topics, but you will still be able to browse on the forum.");
	}

}
