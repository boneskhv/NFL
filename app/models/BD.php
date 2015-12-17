<?php

/**
 * Created by PhpStorm.
 * User: 1229753
 * Date: 01/12/2015
 * Time: 09:50
 */
class BD
{
    //Regarde si le compte existe dans la BD et si c'est un admin ou un client
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

            if ($val[0][2] == NULL)
                return -1;

            return $val[0][2];

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }
    }

    public static function LoadAccount()
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        try {
            $sel = "SELECT AccountEmail FROM Account WHERE AccountisAdmin= 0";
            $req = $pdo->prepare($sel);
            $req->execute();

            $val = $req->fetchAll(PDO::FETCH_COLUMN);
            $pdo = null;

            return $val;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }
    }

    //recupere les scores de la BD
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

            $valScore = $req->fetchAll(PDO::FETCH_COLUMN);

            $pdo = null;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }

        return $valScore;

    }

    public static function LoadFutureHome()
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

            $valFuture = $req->fetchAll(PDO::FETCH_COLUMN, 0);

            $pdo = null;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }

        return $valFuture;
    }

    public static function LoadFutureVisitor()
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

            $valFuture = $req->fetchAll(PDO::FETCH_COLUMN, 1);

            $pdo = null;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }

        return $valFuture;
    }

    public static function LoadFutureLocation()
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

            $valFuture = $req->fetchAll(PDO::FETCH_COLUMN, 2);

            $pdo = null;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }

        return $valFuture;
    }

    public static function AddAccount($email, $pw, $nbToken)
    {

        // Connexion
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        /**************************************
         * Création des tables                       *
         **************************************/
        try {
            $insert = "INSERT INTO Account (AccountEmail, AccountPW, AccountisAdmin, AccountToken) VALUES (:email, :pw, 0, :nbToken)";
            $req = $pdo->prepare($insert);
            $req->bindValue(':email', $email);
            $req->bindValue(':pw', md5($pw));
            $req->bindValue(':nbToken', $nbToken);

            $req->execute();

        } catch (PDOException $e) {
            echo 'Insertion failed: ' . $e->getMessage();
        }

        // ferme la requête
        $pdo = null;
    }

    public static function DeleteAccount($email)
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        try {
            $del = "DELETE FROM Account WHERE (AccountEmail= :email)";
            $req = $pdo->prepare($del);
            $req->bindValue(':email', $email);
            $req->execute();

        } catch (PDOException $e) {
            echo 'delete failed: ' . $e->getMessage();
        }

        $pdo = null;
    }

    public static function ModifyAccount($email, $pw, $token)
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        if ($pw != " " && $token != " ") {
            $update = "UPDATE Account SET AccountPW= :pw, AccountToken= :token WHERE AccountEmail = :email";
            $req = $pdo->prepare($update);
            $req->bindValue(":email", $email);
            $req->bindValue("pw", md5($pw));
            $req->bindValue(":token", $token);
        } else if ($token == " ") {
            $update = "UPDATE Account SET AccountPW= :pw WHERE AccountEmail = :email";
            $req = $pdo->prepare($update);
            $req->bindValue(":email", $email);
            $req->bindValue("pw", md5($pw));
        } else if ($pw == " ") {
            $update = "UPDATE Account SET AccountToken= :token WHERE AccountEmail = :email";
            $req = $pdo->prepare($update);
            $req->bindValue(":email", $email);
            $req->bindValue(":token", $token);
        }

        $req->execute();

        $pdo = null;
    }

    public static function UpdatePython()
    {
        exec('C:\Python34\python.exe ../app/models/parser.py 2>&1');
    }

    public static function TeamAPI()
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        try {
            $sel = "SELECT * FROM standings";
            $req = $pdo->prepare($sel);
            $req->execute();

            $result = $req->fetchAll(PDO::FETCH_ASSOC);

            $pdo = null;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }

        return $result;
    }

    public static function GamesAPI()
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

            $result = $req->fetchAll(PDO::FETCH_ASSOC);

            $pdo = null;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }

        return $result;
    }

    public static function BetAPI($id)
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        try {
            $sel = "SELECT * FROM Bet WHERE Game = :id";
            $req = $pdo->prepare($sel);
            $req->bindValue(":id", $id);
            $req->execute();

            $result = $req->fetchAll(PDO::FETCH_ASSOC);

            $pdo = null;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }

        return $result;
    }

    public static function AddTokenToUser($email, $nbToken)
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        $update = "UPDATE Account SET AccountToken= AccountToken + :token WHERE AccountEmail = :email";
        $req = $pdo->prepare($update);
        $req->bindValue(":email", $email);
        $req->bindValue(":token", $nbToken);
        $req->execute();

        $pdo = null;
    }

    public static function GetToken($email)
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        try {
            $sel = "SELECT AccountToken FROM Account WHERE AccountEmail = :id";
            $req = $pdo->prepare($sel);
            $req->bindValue(":id", $email);
            $req->execute();

            $result = $req->fetchAll(PDO::FETCH_NUM);

            $pdo = null;

        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }

        return intval($result [0][0]);
    }

    public static function GetFutureHome()
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        $sel = "SELECT home FROM futures";
        $req = $pdo->prepare($sel);
        $req->execute();

        $result = $req->fetchAll(PDO::FETCH_NUM);

        $pdo = null;

        return $result;
    }

    public static function GetFutureVisitor()
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        $sel = "SELECT visitor FROM futures";
        $req = $pdo->prepare($sel);
        $req->execute();

        $result = $req->fetchAll(PDO::FETCH_NUM);

        $pdo = null;

        return $result;
    }

    public static function CalculateGains($team, $opponent, $amount)
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        $sel = "SELECT pct FROM standings WHERE team= :team";
        $req = $pdo->prepare($sel);
        $req->bindValue(":team", $team);
        $req->execute();

        $result = $req->fetchAll();

        $teamPCT = $result[0][0];

        $sel = "SELECT pct FROM standings WHERE team= :team";
        $req = $pdo->prepare($sel);
        $req->bindValue(":team", $opponent);
        $req->execute();

        $result = $req->fetchAll();

        $opponentPCT = $result[0][0];

        $pdo = null;

        $difference = abs($teamPCT - $opponentPCT);
        if($teamPCT > $opponentPCT)
            $result = 0.5 + ($difference /2);
        else
            $result = 0.5 - ($difference /2);

        return round((2 - $result) * $amount + $amount);
    }

    public static function PlaceBet($better, $betAmount, $gameId, $isHome, $reward)
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        $insert = "INSERT INTO Bet (Beter, Amount, Game, Home, Reward, Seen) VALUES (:beter, :amount, :game, :home, :reward, 0)";
        $req = $pdo->prepare($insert);
        $req->bindValue(":beter", $better);
        $req->bindValue(":amount", $betAmount);
        $req->bindValue(":game", $gameId);
        if($isHome)
            $req->bindValue(":home", 1);
        else
            $req->bindValue(":home", 0);
        $req->bindValue(":reward", $reward);
        $req->execute();

        $update = "UPDATE Account SET AccountToken= AccountToken - :token WHERE AccountEmail = :better";
        $req = $pdo->prepare($update);
        $req->bindValue(":email", $better);
        $req->bindValue(":token", $betAmount);
        $req->execute();

        $pdo = null;
    }
}