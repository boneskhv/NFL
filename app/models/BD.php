<?php

/**
 * Created by PhpStorm.
 * User: 1229753
 * Date: 01/12/2015
 * Time: 09:50
 */
class BD
{
    public static function Connect($email, $pw)
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        try {
            $sel = "SELECT * FROM Account WHERE AccountEmail= :Email AND AccountPW= :PW";
            $req = $pdo->prepare($sel);
            $req->bindValue(":Email", $email);
            $req->bindValue(":PW", md5($pw));
            $req->execute();

            $val = $req->fetchAll();
            $pdo = null;

            if($val[0][2] == NULL)
                return -1;

            return $val[0][2];

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }
    }

    public static function LoadScore()
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        try {
            $sel = "SELECT * FROM scores";
            $req = $pdo->prepare($sel);
            $req->execute();

            $valScore = $req->fetchAll();

            $pdo = null;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }

        return $valScore;

    }

    public static function LoadFuture()
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        try {
            $sel = "SELECT * FROM futures";
            $req = $pdo->prepare($sel);
            $req->execute();

            $valFuture = $req->fetchAll();

            $pdo = null;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }
        return $valFuture;
    }
}