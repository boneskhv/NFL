<?php

session_start();

//controller des admins
class Admin extends Controller
{
    public static function index()
    {
        parent::view("index");
    }

    //appel LoadAccount
    public static function LoadAccountList()
    {
        if($_POST["Action"] == "LoadAccount")
        {
            parent::model("BD");
            $accounts = BD::LoadAccount();
            echo json_encode($accounts);
        }
        else
            parent::view("index");
    }

    //appel AddAccount
    public static function AddAccount()
    {
        if(isset($_POST["data"]))
        {
            parent::model("BD");
            $data = explode(';', $_POST["data"]);
            BD::AddAccount($data[0], $data[1], $data[2]);
            echo($data[0] . " was added");
        }
        else
            parent::view("index");
    }

    //appel ModifyAccount
    public static function ModifyAccount()
    {
        if(isset($_POST["data"]))
        {
            parent::model("BD");
            $data = explode(';', $_POST["data"]);
            BD::ModifyAccount($data[0], $data[1], $data[2]);
            echo($data[0] . " was modified");
        }
        else
            parent::view("index");
    }

    //appel DeleteAccount
    public static function DeleteAccount()
    {
        if(isset($_POST["data"]))
        {
            parent::model("BD");
            BD::DeleteAccount($_POST["data"]);
            echo($_POST["data"] . " account was terminated");
        }
        else
            parent::view("index");
    }

}