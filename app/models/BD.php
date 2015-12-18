<?php

/**
 * Created by PhpStorm.
 * User: 1229753
 * Date: 01/12/2015
 * Time: 09:50
 */
//modele des actions effectués sur la BD
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

    //recupere la liste d'account qui ne sont pas admin
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

    //recupere les team "home" des match futures
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

    //recupere les team "visitor" des match futures
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

    //recupere la location des match futures
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

    //ajoute un compte client
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

    //supprime un compte
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

    //modifie un compte
    public static function ModifyAccount($email, $pw, $token)
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        //regarde si modifie le nombre de token ou le password ou les 2
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

    //retour de l'API/Team
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

    //retour de l'API/games
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

    //retour de l'API/games/x
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

    //ajout de token dans la BD lors de l'achat de token
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

    //recupere le nombre de token d'un client
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

    //recupere les info de future match
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

    //calcule le gain d'un bet selon le PCT des equipe et le nombre de token gager
    public static function CalculateGains($team, $opponent, $amount)
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        //recuperation des PCTs
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

        //calcule de gain
        $difference = abs($teamPCT - $opponentPCT);
        if($teamPCT > $opponentPCT)
            $result = 0.5 + ($difference /2);
        else
            $result = 0.5 - ($difference /2);

        return round((2 - $result) * $amount + $amount);
    }

    //ajoute une mise a la BD
    public static function PlaceBet($beter, $betAmount, $gameId, $isHome, $reward)
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        //ajoute la mise
        $insert = "INSERT INTO Bet (Beter, Amount, Game, Home, Reward, Seen, Status) VALUES (:beter, :amount, :game, :home, :reward, 0, 1)";
        $req = $pdo->prepare($insert);
        $req->bindValue(":beter", $beter);
        $req->bindValue(":amount", $betAmount);
        $req->bindValue(":game", $gameId);
        if($isHome == "true")
            $req->bindValue(":home", 1);
        else
            $req->bindValue(":home", 0);
        $req->bindValue(":reward", $reward);
        $req->execute();

        //retire les jetons au clients
        $update = "UPDATE Account SET AccountToken= AccountToken - :token WHERE AccountEmail = :email";
        $req = $pdo->prepare($update);
        $req->bindValue(":email", $beter);
        $req->bindValue(":token", $betAmount);
        $req->execute();

        $pdo = null;
    }

    //recupere les mises du client
    public static function CurrentBet($email)
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        $sel = "SELECT Bet.Amount, futures.home, futures.visitor, futures.location, Bet.Home, Bet.Reward, Bet.Status, Bet.Id FROM Bet INNER JOIN futures ON Bet.Game = futures.id WHERE Bet.Beter= :email";
        $req = $pdo->prepare($sel);
        $req->bindValue(":email", $email);
        $req->execute();

        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        $pdo = null;

        return $result;
    }

    //supprime une mise
    public static function DeleteBet($id)
    {
        try {
            $pdo = new PDO('sqlite:../app/models/NFL.db');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        //recupere les info sur le bet
        $sel = "SELECT Beter , Amount FROM Bet WHERE Id = :id";
        $req = $pdo->prepare($sel);
        $req->bindValue(":id", $id);
        $req->execute();

        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        //redonne les jetons au client
        $update = "UPDATE Account SET AccountToken= AccountToken + :token WHERE AccountEmail = :email";
        $req = $pdo->prepare($update);
        $req->bindValue(":email", $result[0]["Beter"]);
        $req->bindValue(":token", $result[0]["Amount"]);
        $req->execute();

        //supprime la mise de la BD
        $del = "DELETE FROM Bet WHERE Id= :id";
        $req = $pdo->prepare($del);
        $req->bindValue(':id', $id);
        $req->execute();

        $pdo = null;
    }
}