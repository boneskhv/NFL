<?php

session_start();

class Client extends Controller
{
    public static function index()
    {
        parent::view("index");
    }

    public static function AddToken()
    {
        if ($_POST["Action"] > 0) {
            parent::model("BD");
            echo BD::AddTokenToUser($_SESSION["client"], $_POST["Action"]);
        }
        else
            parent::view("index");
    }

    public static function GetToken()
    {
        if($_POST["Action"] == "getToken")
        {
            parent::model("BD");
            $nbToken = BD::GetToken($_SESSION["client"]);
            echo json_encode($nbToken);
        }
        else
            parent::view("index");
    }

    public static function GetFutureHome()
    {
        if(isset($_POST["Action"]))
        {
            parent::model("BD");
            $result = BD::GetFutureHome();
            echo json_encode($result);
        }
        else
            parent::view("index");
    }

    public static function GetFutureVisitor()
    {
        if(isset($_POST["Action"]))
        {
            parent::model("BD");
            $result = BD::GetFutureVisitor();
            echo json_encode($result);
        }
        else
            parent::view("index");
    }

    public static function CalculateGains()
    {
        if(isset($_POST["Action"]))
        {
            parent::model("BD");
            $data = $_POST["Action"].explode(';');
            $result = BD::CalculateGains($data[0], $data[1]);
            echo json_encode($result);
        }
        else
            parent::view("index");
    }
}