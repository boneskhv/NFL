<?php

class Home extends Controller
{
	public static function index( $name = '')
	{
		//echo "allo " . $name;
		//$user = $this -> model ('User');
		//$user->name = $name;
		parent::view('home/index');#, ['name' => $name]);
	}

	public function patate ()
	{
		echo "J'aime les patates";
	}

	public function  HomeTP()
	{
        //include_once "C:/wamp/www/NFL/MVC2/app/models/function.php";
        parent::model('/function');
		//parent::view('home/index');#, ['name' => 'lol']);
		//echo "J'aime les patates";
	}


}