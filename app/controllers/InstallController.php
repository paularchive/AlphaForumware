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
	    		fwrite($fp, "	'DATABASE_HOST'		  => '".Input::get('host')."',\n");
	    		fwrite($fp, "	'DATABASE_NAME' 	  => '".Input::get('database')."',\n");
	    		fwrite($fp, "	'DATABASE_USER' 	  => '".Input::get('user')."',\n");
	    		fwrite($fp, "	'DATABASE_PASSWORD'   => '".Input::get('password')."',\n");
	    		fwrite($fp, "	'DATABASE_CONNECTION' => false\n");
	    		fwrite($fp, ");");
	    		fclose($fp);

	    		try{
	    			$pdo = new PDO("mysql:host=".Input::get('host').";dbname=".Input::get('database'), Input::get('user'), Input::get('password'));
	    		}
	    		catch(\PDOException $exception)
	    		{
	    			return Redirect::route('install.database')
	    			->with('message', true)
	    			->with('msg.type', 'negative')
	    			->with('msg.header', "Couldn't connect to database!")
	    			->with('msg.message', "Please check your database credentials.");
	    		}
	    		if($pdo)
	    		{
	    			$fp = fopen(base_path()."/.env.development.php", 'w');
	    			fwrite($fp, "<?php\n");
	    			fwrite($fp, "return array(\n");
	    			fwrite($fp, "	'DATABASE_HOST'		  => '".Input::get('host')."',\n");
	    			fwrite($fp, "	'DATABASE_NAME' 	  => '".Input::get('database')."',\n");
	    			fwrite($fp, "	'DATABASE_USER' 	  => '".Input::get('user')."',\n");
	    			fwrite($fp, "	'DATABASE_PASSWORD'   => '".Input::get('password')."',\n");
	    			fwrite($fp, "	'DATABASE_CONNECTION' => true\n");
	    			fwrite($fp, ");");
	    			fclose($fp);

    				return Redirect::route('install.connection');
    			}
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
		if($_ENV['DATABASE_CONNECTION'])
		{
			/*if(Schema::hasTable('install'))
				$setting = DB::table('install')->where('install-step', 'db-migrate')->first();
			else
				$setting = null;
			if($setting !== null && $setting->done)
				return Redirect::route('install.user');
			else*/
				return View::make('install.connection');				
		}
		else
			return Redirect::route('install.database');
	}

	public function migrateInstall()
	{
		if(Request::ajax())
		{
			if(Schema::hasTable('install'))
			{
				$setting = DB::table('install')->where('install-step', 'db-migrate')->first();
			}
			else
				$setting = null;

			try {
				if($setting !== null && $setting->done)
					return $this->sendMessage('20%', '<span style="color:lime;font-weight:bold;">[UPDATE]</span> Switching over to update mode...');
				// Else just exicute the command.
				Artisan::call('migrate:install');
			}
			catch (Exception $e) {
				return $this->sendMessage('error', $e->getMessage());
			}
			return $this->sendMessage('20%', '<span style="color:green;font-weight:bold;">[DONE]</span> Migration files initialized.');
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
			return $this->sendMessage('65%', '<span style="color:green;font-weight:bold;">[DONE]</span> Migrated database.');
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
			if(Schema::hasTable('install'))
			{
				$setting = DB::table('install')->where('install-step', 'db-migrate')->first();
			}
			else
				$setting = null;

			try{
				if($setting !== null && $setting->done)
					return $this->sendMessage('100%', '<span style="color:lime;font-weight:bold;">[UPDATE]</span> Update completed, no seeding needed');
				Artisan::call('db:seed');
			}
			catch (Exception $e) {
				return $this->sendMessage('error', $e->getMessage());
			}
			DB::table('install')->where('install-step', 'db-migrate')->update(['done' => 1]);
			return $this->sendMessage('100%', '<span style="color:green;font-weight:bold;">[DONE]</span> Data is seeded.');
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

	public function user()
	{
		return "WIP!";
	}


}
