<?php

session_start();

class User extends Controller
{
    public static function index()
    {
        parent::view("Home");
    }

    public static function login()
    {
        parent::model("BD");

        $value = BD::login($_POST["email"], $_POST["password"]);

        if($value == 1)
        {
            $_SESSION["admin"] = $_POST["email"];
            parent::view("AdminHome");
        }
        elseif($value == 0)
        {
            $_SESSION["client"] = $_POST["email"];
            parent::view("ClientHome");
        }
    }


    public static function LoadHome()
    {
        if($_POST["Action"] == "LoadHome")
        {
            parent::model("BD");
            echo BD::LoadHome();
        }
    }

}
