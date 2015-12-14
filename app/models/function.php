<?php

error_reporting(E_ALL);
//print_r($data);
CreateAccount("michel@michel.com", "123", 0);

function SignOut()
{
    session_unset();

    header("location: ../index.php");
}

function Connect($email, $pw)
{
    try {
        $pdo = new PDO('sqlite:bd.Account');
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    try {
        $sel = "SELECT * FROM Account WHERE AccountEmail= :Email AND AccountPW= :PW";
        $req = $pdo->prepare($sel);
        var_dump($req);
        $req->bindValue(":Email", $email);
        $req->bindValue(":PW", md5($pw));
        $req->execute();

        $val = $req->fetchAll(PDO::FETCH_NUM);
        $pdo = null;

        $_SESSION["email"] = $email;

        if ($val[0][2] == 1)
            AdminHome();
        else if ($val[0][2] == 0)
            ClientHome();

    } catch (PDOException $ex) {
        echo "Connection failed: " . $ex->getMessage();
    }
}

function CreateAccount($email, $pw, $isAdmin)
{

// Connexion
    try {
        $pdo = new PDO('sqlite:NFL.db');
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    /**************************************
     * Cr�ation des tables                       *
     **************************************/
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS Account (
                    AccountEmail TEXT PRIMARY KEY NOT NULL UNIQUE,
                  	AccountPW TEXT NOT NULL,
						AccountisAdmin INTEGER NOT NULL)");

        $insert = "INSERT INTO Account (AccountEmail, AccountPW, AccountisAdmin) VALUES (:email, :pw, :isAdmin)";
        $requete = $pdo->prepare($insert);
        $requete->bindValue(':email', $email);
        $requete->bindValue(':pw', md5($pw));
        if ($isAdmin == "on")
            $requete->bindValue(':isAdmin', $isAdmin);
        else
            $requete->bindValue(':isAdmin', $isAdmin);

        // Execute la requ�te
        $requete->execute();

        print_r("top kek");
        //AdminHome();

    } catch (PDOException $e) {
        echo 'Insertion failed: ' . $e->getMessage();
    }

// ferme la requ�te
    $pdo = null;
}

function ModifyAccount($newEmail, $oldEmail, $isAdmin)
{
    try {
        $pdo = new PDO('sqlite:bd.Account');
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    $update = "UPDATE Account SET AccountEmail= :newEmail, AccountisAdmin= :isAdmin WHERE AccountEmail = :oldEmail";
    $req = $pdo->prepare($update);
    $req->bindValue(":newEmail", $newEmail);
    $req->bindValue(":isAdmin", $isAdmin);
    $req->bindValue(":oldEmail", $oldEmail);

    $req->execute();

    AdminHome();

    $pdo = null;
}

function DeleteAccount($email)
{
    try {
        $pdo = new PDO('sqlite:bd.Account');
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    try {
        $del = "DELETE FROM Account WHERE (AccountEmail= :email)";
        $req = $pdo->prepare($del);
        $req->bindValue(':email', $email);
        $req->execute();

        AdminHome();

    } catch (PDOException $e) {
        echo 'delete failed: ' . $e->getMessage();
    }

    $pdo = null;
}

?>