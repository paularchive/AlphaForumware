<?php

class InstallController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('install.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function database()
	{
		if(Request::isMethod('get'))
			return View::make('install.database');

		elseif(Request::isMethod('post'))
		{
			$rules = array(
				'host' => 'required',
				'database' => 'required',
				'user' => 'required'
			);

			$messages = array(
				'required' => "You didn't enter your database :attribute."
			);

			$validate = Validator::make(Input::all(), $rules, $messages);

			if($validate->fails())
				return Redirect::route('install.database')->withErrors($validate);
			else
			{
				$fp = fopen(base_path()."/.env.development.php", 'w');
	    		fwrite($fp, "<?php\n");
	    		fwrite($fp, "return array(\n");
	    		fwrite($fp, "	'DATABASE_HOST'		=> '".Input::get('host')."',\n");
	    		fwrite($fp, "	'DATABASE_NAME' 	=> '".Input::get('database')."',\n");
	    		fwrite($fp, "	'DATABASE_USER' 	=> '".Input::get('user')."',\n");
	    		fwrite($fp, "	'DATABASE_PASSWORD' => '".Input::get('password')."'\n");
	    		fwrite($fp, ");");
	    		fclose($fp);

	    		return Redirect::route('install.connection');
	    	}


		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function connection()
	{
		if(Request::isMethod('get'))
		{
			return View::make('install.connection');
		}
		elseif(Request::ajax())
		{
			
			/*try {
		    	return $this->sendMessage('10%', '[INIT] migrate:install');
		      
		    	return $this->sendMessage('50%', '[INIT] migrating...');
		    	return $this->sendMessage('80%', '[INIT] seeding data...');
		    	
		    } catch (Exception $e) {
		    	return Response::make($e->getMessage(), 500);
		    }*/

		    try {
			    $this->migrateInstall();
			    $this->migrate();
			    $this->seed();
			} 
			catch (Exception $e) {
		    	return Response::make($e->getMessage(), 500);
		    }
		}
	}

	public function migrateInstall()
	{
		if(Request::ajax())
		{
			try {
				Artisan::call('migrate:install');
			}
			catch (Exception $e) {
				return $this->sendMessage('error', $e->getMessage());
			}
			return $this->sendMessage('40%', '[DONE] migrate:install');
		}
		else
		{
			App::abort(404);
		}
	}

	public function migrate()
	{
		if(Request::ajax())
		{
			try {
				Artisan::call('migrate', ['--path' => "app/database/migrations"]);
			}
			catch (Exception $e) {
				return $this->sendMessage('error', $e->getMessage());
			}
			return $this->sendMessage('70%', '[DONE] migrating.');
		}
		else
		{
			App::abort(404);
		}
	}

	public function seed()
	{
		if(Request::ajax())
		{
			try{
				Artisan::call('db:seed');
			}
			catch (Exception $e) {
				return $this->sendMessage('error', $e->getMessage());
			}
			return $this->sendMessage('100%', '[DONE] seeding data.');
		}
		else
		{
			App::abort(404);
		}
	}

	private static function sendMessage($progress, $message)
	{
		return Response::json(array('progress' => $progress, 'message' => $message));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
