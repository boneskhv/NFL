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
        parent::model('BD');

		$val = BD::Connect($_POST["Email"], $_POST["PW"]);

		parent::model('LoadView');
		if ($val == 1)
			LoadView::AdminHome();
		else if ($val == 0)
			LoadView::ClientHome();
	}


}