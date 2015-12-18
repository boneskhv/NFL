<?php

session_start();

//controlleer d'utilisateur
class User extends Controller
{
    public static function index()
    {
        parent::view("index");
    }

    //deconnecte un client
    public static function LogOut()
    {
        session_unset();
        session_destroy();
        parent::view("index");
    }

    //appel Connect et la vue approprier
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

    //appel LoadScore
    public static function LoadScore()
    {
        if($_POST["Action"] == "LoadHome")
        {
            parent::model("BD");
            $Score = BD::LoadScore();
            echo json_encode($Score);
        }
        else
            parent::view("index");
    }

    //appel LoadFutureHome
    public static function LoadFutureHome()
    {
        if($_POST["Action"] == "LoadHome")
        {
            parent::model("BD");
            $Future = BD::LoadFutureHome();
            echo json_encode($Future);
        }
        else
            parent::view("index");
    }

    //appel LoadFutureVisitor
    public static function LoadFutureVisitor()
    {
        if($_POST["Action"] == "LoadHome")
        {
            parent::model("BD");
            $Future = BD::LoadFutureVisitor();
            echo json_encode($Future);
        }
        else
            parent::view("index");
    }

    //appel LoadFutureLocation
    public static function LoadFutureLocation()
    {
        if($_POST["Action"] == "LoadHome")
        {
            parent::model("BD");
            $Future = BD::LoadFutureLocation();
            echo json_encode($Future);
        }
        else
            parent::view("index");
    }

    //UpdatePython
    public static function UpdatePython()
    {
        if($_POST["Action"] == "updatePython")
        {
            parent::model("BD");
            BD::UpdatePython();
        }
        else
            parent::view("index");
    }

    //appel la vue de la page API
    public static function LoadAPIPage()
    {
        parent::view("APIPage");
    }

}
