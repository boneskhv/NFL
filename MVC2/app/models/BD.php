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

            $_SESSION["email"] = $email;

            return $val[0][2] ;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }
    }
}