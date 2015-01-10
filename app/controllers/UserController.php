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
			'username' => 'required|unique:users,username|min:4',
			'email' => 'required|unique:users,email|email',
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
		
		try
		{
		    // Let's register a user.
		    $user = Sentry::register(array(
		        'username' => Input::get('username'),
		        'email'    => Input::get('email'),
		        'password' => Input::get('pass1'),
		    ), true);

		    // Let's get the activation code
		    $activationCode = $user->getActivationCode();

		    // Send activation code to the user so he can activate the account
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
    		return Redirect::route('getLogin')->with('message', true)->with('msg.type', 'negative')->with('msg.header', "This email has already been registered.")->with('msg.message', "It looks like you entered the wrong password! Please try it again.");
		}
		
		$redirect = Session::get('loginRedirect', '/');
		// Unset the page we were before from the session
    	Session::forget('loginRedirect');

		return Redirect::to($redirect)->with('message', true)->with('msg.type', 'success')->with('msg.header', "Your registration was successful.")->with('msg.message', "You may now log-in with the username you have chosen.");
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

		try
		{
			$remember = (Input::has('remember')) ? true : false;

		    // Login credentials
		    $credentials = array(
		        'username'    => Input::get('username'),
		        'password' => Input::get('pass1'),
		    );

		    // Authenticate the user
		    $user = Sentry::authenticate($credentials, $remember);
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
		    return Redirect::route('getLogin')->with('message', true)->with('msg.type', 'negative')->with('msg.header', "You entered the wrong login credentials.")->with('msg.message', "It looks like you entered the wrong password! Please try it again.");
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    return Redirect::route('getLogin')->with('message', true)->with('msg.type', 'negative')->with('msg.header', "You entered the wrong login credentials.")->with('msg.message', "It looks like that user doesn't exist! Please try it again.");
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
		    return Redirect::route('getLogin')->with('message', true)->with('msg.type', 'info')->with('msg.header', "Account isn't activated yet!")->with('msg.message', "Please check your email and activate your account.");
		}
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
		    return Redirect::route('getLogin')->with('message', true)->with('msg.type', 'info')->with('msg.header', "Account Suspended.")->with('msg.message', "It looks like your account has been suspended, please contact an Administrator for more info.");
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
		    return Redirect::route('getLogin')->with('message', true)->with('msg.type', 'negative')->with('msg.header', "You entered the wrong login credentials.")->with('msg.message', "It looks like your account has been banned, please contact an Administrator for more info.");
		}
		
		$redirect = Session::get('loginRedirect', '/');
		// Unset the page we were before from the session
    	Session::forget('loginRedirect');
    	return Redirect::to($redirect)->with('message', true)->with('msg.type', 'success')->with('msg.header', "You have logged-in successfully.")->with('msg.message', "You can now post replies and make new topics if you want.");
	}

	public function getLogout()
	{
		Sentry::logout();
		$redirect = Session::get('loginRedirect', '/');
		// Unset the page we were before from the session
    	Session::forget('loginRedirect');

		return Redirect::to($redirect)->with('message', true)->with('msg.type', 'warning')->with('msg.header', "You have logged-out successfully.")->with('msg.message', "You can no longer post replies or topics, but you will still be able to browse on the forum.");
	}


	/**
	 * Load profile index
	 *
	 * @param int $user
	 * @return Response
	**/
	/*public function profile.index($user)
	{
		$user = 1;
	}*/

}
