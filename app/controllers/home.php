<?php
session_start();

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
        parent::model('BD');

		$val = BD::Connect($_POST["email"], $_POST["pw"]);
		print_r($val);

		if ($val == 1) {
			$_SESSION["Admin"] = $_POST["email"];
			parent::view('home/AdminHome');
		}
		else if ($val == 0)
		{
			$_SESSION["Client"] = $_POST["email"];
			parent::view('ClientHome');
		}
	}
}