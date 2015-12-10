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
            $pdo = new PDO('sqlite:bd.Account');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        try {
            $sel = "SELECT * FROM Account WHERE AccountEmail= :Email AND AccountPW= :PW";
            $req = $pdo->prepare($sel);
            //var_dump($req);
            $req->bindValue(":Email", $email);
            $req->bindValue(":PW", md5($pw));
            $req->execute();

            $val = $req->fetchAll(PDO::FETCH_NUM);
            $pdo = null;

            return $val[0][2];

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }
    }

    public static function LoadHome()
    {
        try {
            $pdo = new PDO('sqlite:NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        try {
            $sel = "SELECT * FROM scores";
            $req = $pdo->prepare($sel);
            $req->execute();

            $valScore = $req->fetchAll();
            for($i = 0; $i < $valScore.count(); $i++)
            {
                $valScore[$i] = $valScore[$i] . ",";
            }

            $pdo = null;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }

        try {
            $pdo = new PDO('sqlite:NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        try {
            $sel = "SELECT * FROM futures";
            $req = $pdo->prepare($sel);
            $req->execute();

            $valFuture = $req->fetchAll();
            for($i = 0; $i < $valFuture.count(); $i++)
            {
                for($j = 0; $j < $valFuture[$j].count(); $j++)
                    if($j != $valFuture[$i].count())
                        $valFuture[$i][$j]  = $valFuture[$i][$j] . ",";
                    else
                        $valFuture[$i][$j] = $valFuture[$i][$j] . ";";
            }

            $pdo = null;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }

        return $valScore.implode() + "/" + $valFuture.implode();
    }
}