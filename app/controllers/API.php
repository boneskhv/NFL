<?php

session_start();

//controller d'API
class API extends Controller
{
    public static function index()
    {
        parent::view("index");
    }

    //Appel l'API team
    public static function Team()
    {
        parent::model("BD");
        $team = BD::TeamAPI();
        echo json_encode($team);
    }

    //appel les api de games
    public static function Games($id = -1)
    {
        parent::model("BD");
        if($id <= 0)
            $result = BD::GamesAPI();
        else
            $result = BD::BetAPI($id);
        echo json_encode($result);
    }

}