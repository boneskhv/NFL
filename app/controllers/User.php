<?php

session_start();

class User extends Controller
{
    public static function index()
    {
        parent::view("index");
    }

    public static function login()
    {
        parent::model("BD");

        $value = BD::Connect($_POST["email"], $_POST["password"]);

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
        elseif($value == -1)
        {
            parent::view("index");
        }
    }


    public static function LoadScore()
    {
        if($_POST["Action"] == "LoadHome")
        {
            parent::model("BD");
            $Score = BD::LoadScore();
            echo json_encode($Score);
        }
    }

    public static function LoadFuture()
    {
        if($_POST["Action"] == "LoadHome")
        {
            parent::model("BD");
            $Future = BD::LoadFuture();
            echo json_encode($Future);
        }
    }

}
