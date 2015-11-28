<?php
/**
 * Created by PhpStorm.
 * User: Baker
 * Date: 2015-11-28
 * Time: 15:25
 */

class Test extends Controller
{
    public static function i( $name = '')
    {
        //echo "allo " . $name;
        //$user = $this -> model ('User');
        //$user->name = $name;
        parent::view('home/index', ['name' => $name]);
    }

    public function pat ()
    {
        echo "J'aime les patates";
    }

}