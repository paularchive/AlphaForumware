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

			$fp = fopen(base_path()."/.env.development.php", 'w');
    		fwrite($fp, "<?php\n");
    		fwrite($fp, "return array(\n");
    		fwrite($fp, "	'DATABASE_HOST'		=> '".Input::get('host')."',\n");
    		fwrite($fp, "	'DATABASE_NAME' 	=> '".Input::get('database')."',\n");
    		fwrite($fp, "	'DATABASE_USER' 	=> '".Input::get('username')."',\n");
    		fwrite($fp, "	'DATABASE_PASSWORD' => '".Input::get('password')."'\n");
    		fwrite($fp, ");");
    		fclose($fp); 
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function connection()
	{
		//
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
