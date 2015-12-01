<?php


print_r($data);

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


function AdminHome()
{
    try {
        $pdo = new PDO('sqlite:bd.Account');
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    try {
        $req = $pdo->prepare("SELECT * FROM Account");
        $req->execute();

        $values_from_db = $req->fetchAll();
        //print_r($values_from_db);

        $doc = new DOMDocument();
        $doc->loadHTMLFile("../app/views/home/AdminHome.php");

        $i = 1;
        foreach ($values_from_db as $single_data) {
            appendAccount($doc, $single_data['AccountEmail'], $single_data['AccountisAdmin'], $i);
            $i = $i + 1;
        }

        echo $doc->saveHTML();
        $pdo = null;

    } catch (PDOException $ex) {
        echo "Connection failed: " . $ex->getMessage();
    }

    //$index = JSON_ENCODE($table);
}

function appendAccount($doc, $name, $isAdmin, $i)
{
    $ele = $doc->getElementById('lstAccount');
    $liste = $doc->createElement("li");
    $form = $doc->createElement("form");
    $form->setAttribute("action", "CreateAccount.php");
    $form->setAttribute("method", "post");
    $form->setAttribute("id", "form" . $i);

    $divNorm = $doc->createElement("div");
    $divNorm->setAttribute("id", "normal" . $i);
    $divMod = $doc->createElement("div");
    $divMod->setAttribute("id", "modify" . $i);
    $divMod->setAttribute("style", "display: none");

    //mon div normal
    $lblNorm = $doc->createElement("label");
    $lblNorm->appendChild($doc->createTextNode($name));
    $lblNorm->setAttribute("name", $name);
    $pencil = $doc->createElement("a");
    $pencilSpan = $doc->createElement("span");
    $pencilSpan->setAttribute("class", "glyphicon glyphicon-pencil");
    $pencilSpan->setAttribute("aria-hidden", "true");
    $pencil->appendChild($pencilSpan);
    $pencil->setAttribute("class", "Account-Management");
    $pencil->setAttribute("href", "javascript:Pencil(" . "'" . $i . "')");
    $trash = $doc->createElement("a");
    $trashSpan = $doc->createElement("span");
    $trashSpan->setAttribute("class", "glyphicon glyphicon-trash");
    $trashSpan->setAttribute("aria-hidden", "true");
    $trash->appendChild($trashSpan);
    $trash->setAttribute("class", "Account-Management");
    $trash->setAttribute("href", "javascript:Submit(" . $i . ",'Del')");
    $trash->setAttribute("name", "Delete");

    //mon div de modifier
    $oldName = $doc->createElement("input");
    $oldName->setAttribute("type", "hidden");
    $oldName->setAttribute("name", "oldName");
    $oldName->setAttribute("value", $name);
    $input = $doc->createElement("input");
    $input->setAttribute("type", "email");
    $input->setAttribute("placeholder", $name);
    $input->setAttribute("name", "input");
    $input->setAttribute("value", $name);
    $lblMod = $doc->createElement("label");
    $lblMod->appendChild($doc->createTextNode("isAdmin"));
    $checkbox = $doc->createElement("input");
    $checkbox->setAttribute("type", "checkbox");
    $checkbox->setAttribute("name", "check");
    if ($isAdmin == 1)
        $checkbox->setAttribute("checked", "");
    $check = $doc->createElement("a");
    $checkSpan = $doc->createElement("span");
    $checkSpan->setAttribute("class", "glyphicon glyphicon-ok");
    $checkSpan->setAttribute("aria-hidden", "true");
    $check->appendChild($checkSpan);
    $check->setAttribute("class", "Account-Management");
    $check->setAttribute("href", "javascript:Submit(" . $i . ",'Mod')");
    $check->setAttribute("name", "Modify");
    $cross = $doc->createElement("a");
    $crossSpan = $doc->createElement("span");
    $crossSpan->setAttribute("class", "glyphicon glyphicon-remove");
    $crossSpan->setAttribute("aria-hidden", "true");
    $cross->appendChild($crossSpan);
    $cross->setAttribute("class", "Account-Management");
    $cross->setAttribute("href", "javascript:Cross(" . "'" . $i . "')");


    //append au doc
    $divNorm->appendChild($lblNorm);
    $divNorm->appendChild($pencil);
    $divNorm->appendChild($trash);
    $divMod->appendChild($oldName);
    $divMod->appendChild($input);
    $divMod->appendChild($lblMod);
    $divMod->appendChild($checkbox);
    $divMod->appendChild($check);
    $divMod->appendChild($cross);
    $form->appendChild($divNorm);
    $form->appendChild($divMod);
    $liste->appendChild($form);
    $ele->appendChild($liste);
}

function ClientHome()
{
    $doc = new DOMDocument();
    $doc->loadHTMLFile("../app/views/home/ClientHome.php");

    echo $doc->SaveHTML();
}


function CreateAccount($email, $pw, $isAdmin)
{

// Connexion
    try {
        $pdo = new PDO('sqlite:bd.Account');
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

        AdminHome();

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

function FilledSurvey($data)
{
    $questions = $_SESSION["QuestionID"];
    try {
        $pdo = new PDO('sqlite:bd.Account');
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    for ($i = 0; $i < count($data); $i++) {
        $insert = "INSERT INTO Answer(AnswerQuestionID, AnswerAnswer) VALUES(:QuestionID,:Answer)";
        $requete = $pdo->prepare($insert);
        $requete->bindValue(':QuestionID', $questions[$i][2]);
        $requete->bindValue(':Answer', $data["r" . $i]);
        $requete->execute();
    }
    $pdo = null;

    $doc = new DOMDocument();
    $doc->loadHTMLFile("Survey.php");
    $Questions = $doc->getElementById('Question');
    $title = $doc->getElementById("SurveyTitle");
    $title->appendChild($doc->createTextNode("Thank you"));
    $button = $doc->getElementById("button");
    $button->appendChild($doc->createTextNode("Home"));
    $button->setAttribute("type", "");
    $button->setAttribute("href", "ClientHome.php");
    $form = $doc->getElementById("form");
    $form->setAttribute("action", "");
    echo $doc->saveHTML();
}


function CreateSurvey($nbQ)
{
    $doc = new DOMDocument();
    $doc->loadHTMLFile("Creation.php");

    for ($i = 1; $i <= $nbQ; $i++) {
        $ele = $doc->getElementById('Question');
        $liste = $doc->createElement("li");

        $div = $doc->createElement("div");
        $lab = $doc->createElement("label");
        $input = $doc->createElement("input");
        $labType = $doc->createElement("label");
        $radio1 = $doc->createElement("input");
        $radio1->setAttribute("type", "radio");
        $radio2 = $doc->createElement("input");
        $radio2->setAttribute("type", "radio");

        $div->setAttribute("id", "Q" . $i);
        $lab->appendChild($doc->createTextNode("Question " . $i));
        $input->setAttribute("name", "input" . $i);
        $input->setAttribute("class", "BlackText");
        $radio1->setAttribute("id", "app" . $i);
        $radio1->setAttribute("checked", "checked");
        $radio1->setAttribute("name", "r" . $i);
        $radio1->setAttribute("value", "1");
        $radio2->setAttribute("id", "dev" . $i);
        $radio2->setAttribute("name", "r" . $i);
        $radio2->setAttribute("value", "0");

        $labType->appendChild($doc->createTextNode("Appreciation: "));
        $labType->appendChild($radio1);
        $labType->appendChild($doc->createTextNode(" Developpement: "));
        $labType->appendChild($radio2);

        $div->appendChild($lab);
        $div->appendChild($input);
        $div->appendChild($labType);
        $liste->appendChild($div);

        $ele->appendChild($liste);
    }

    $button = $doc->getElementById("button");
    $button->appendChild($doc->createTextNode("Complete Survey"));

    echo $doc->SaveHTML();
}


function CompleteSurvey($pw)
{
    $doc = new DOMDocument();
    $doc->loadHTMLFile("../html/CompleteSurvey.html");
    $Questions = $doc->getElementById('Question');
    $input = $doc->createElement("input");
    $input->setAttribute("class", "BlackText");
    $button = $doc->getElementById("button");
    //$button->appendChild($doc->createTextNode("Complete Survey"));
    $button->setAttribute("type", "submit");
    $Questions->appendChild($input);
    echo $doc->saveHTML();


}

function OpenSurvey()
{
    try {
        $pdo = new PDO('sqlite:bd.Account');
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    $insert = "INSERT INTO Sondage(PW, Account) VALUES(:SondagePW,:SondageAccount)";
    $requete = $pdo->prepare($insert);
    $pw = substr(str_shuffle("qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789"), 0, 13);
    $requete->bindValue(':SondagePW', $pw);
    $requete->bindValue(':SondageAccount', $_COOKIE['email']);

    // Execute la requ�te
    $requete->execute();

    $pdo = null;
}

function AddSurvey($data)
{
    try {
        $pdo = new PDO('sqlite:bd.Account');
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    $insert = "INSERT INTO Sondage(PW, Account) VALUES(:SondagePW,:SondageAccount)";
    $requete = $pdo->prepare($insert);
    $pw = substr(str_shuffle("qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789"), 0, 13);
    $requete->bindValue(':SondagePW', $pw);
    $requete->bindValue(':SondageAccount', $_SESSION["email"]);

    // Execute la requ�te
    $requete->execute();

    $pdo = null;

    $doc = new DOMDocument();
    $doc->loadHTMLFile("Survey.php");
    $Questions = $doc->getElementById('Question');
    $title = $doc->getElementById("SurveyTitle");
    $title->appendChild($doc->createTextNode("Survey Created"));
    $input = $doc->createElement("input");
    $input->setAttribute("value", $pw);
    $input->setAttribute("class", "BlackText");
    $input->setAttribute("ReadOnly", "");
    $input->setAttribute("name", "pw");
    $button = $doc->getElementById("button");
    $button->appendChild($doc->createTextNode("Complete Survey"));
    $button->setAttribute("type", "submit");
    $form = $doc->getElementById("form");
    $form->setAttribute("action", "AnswerSurvey.php");
    $Questions->appendChild($input);
    echo $doc->saveHTML();

    for ($i = 1; $i <= count($data) - (count($data) / 2); $i++) {
        $Question = $data['input' . $i];
        $type = $data['r' . $i];
        AddQuestions($Question, $type);
    }

}

function AddQuestions($Question, $Type)//ajoute les questions au sondage
{
    try {
        $pdo = new PDO('sqlite:bd.Account');
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    $str = "SELECT SondageID FROM Sondage ORDER BY SondageID DESC";
    $Select = $pdo->prepare($str);
    $Select->execute();

    $value = $Select->fetchAll();

    $insert = "INSERT INTO Question(QuestQuestion, QuestReponse, QuestType, QuestSondageID) VALUES(:QuestQuestion,:QuestReponse,:QuestType,:QuestSondageID)";
    $req = $pdo->prepare($insert);
    $req->bindValue(':QuestQuestion', $Question);
    $req->bindValue(':QuestReponse', '');
    if ($Type == 1)
        $req->bindValue(':QuestType', 1);
    else
        $req->bindValue(':QuestType', 0);
    $req->bindValue(':QuestSondageID', $value[0][0]);


    // Execute la requ�te
    $req->execute();

    $pdo = null;
}


function FillSurvey($pw)
{
    try {
        $pdo = new PDO('sqlite:bd.Account');
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    try {
        $sel = "SELECT SondageID FROM Sondage WHERE PW = :PWSondage";
        $req = $pdo->prepare($sel);
        $req->bindValue(':PWSondage', $pw);
        $req->execute();

        $val = $req->fetchAll(PDO::FETCH_NUM);

        $sel = "SELECT QuestQuestion, QuestType, QuestionID FROM Question WHERE QuestSondageID = :SondageID";
        $req = $pdo->prepare($sel);
        $req->bindValue(':SondageID', $val[0][0]);
        $req->execute();

        $val = $req->fetchAll(PDO::FETCH_NUM);
        $pdo = null;
        $_SESSION["QuestionID"] = $val;

        $doc = new DOMDocument();
        $doc->loadHTMLFile("Survey.php");

        $title = $doc->getElementById("SurveyTitle");
        $title->appendChild($doc->createTextNode("Answer Survey"));

        $form = $doc->getElementById("form");
        $form->setAttribute("action", "FilledSurvey.php");

        $button = $doc->getElementById("button");
        $button->appendChild($doc->createTextNode("Complete Survey"));
        $button->setAttribute("type", "submit");

        for ($i = 0; $i < count($val); $i++) {
            $question = $val[$i][0];
            $type = $val[$i][1];

            AppendQuestion($doc, $i, $question, $type);
        }

        echo $doc->saveHTML();


    } catch (PDOException $ex) {
        echo "Connection failed: " . $ex->getMessage();
    }
}

function AppendQuestion($doc, $i, $question, $type)
{
    $ele = $doc->getElementById('Question');
    $liste = $doc->createElement("li");

    $div = $doc->createElement("div");
    $div->setAttribute("id", "Q" . $i);
    $QuestHead = $doc->createElement("h3");
    $QuestHead->setAttribute("class", "WhiteText");

    $QuestHead->appendChild($doc->createTextNode(($i + 1) . ". " . $question));
    $div->appendChild($QuestHead);
    $br = $doc->createElement("br");
    $div->appendChild($br);

    //si appreciation
    if ($type == 1) {
        for ($ii = 1; $ii <= 10; $ii++) {
            $labNum = $doc->createElement("label");
            $labNum->appendChild($doc->createTextNode($ii));
            $radio = $doc->createElement("input");
            $radio->setAttribute("type", "radio");
            $radio->setAttribute("id", $i . "app" . $ii);
            $radio->setAttribute("name", "r" . $i);
            $radio->setAttribute("value", $ii);
            $radio->setAttribute("required", "");

            $div->appendChild($labNum);
            $div->appendChild($radio);
        }

        $liste->appendChild($div);
        $ele->appendChild($liste);
    } else {
        $text = $doc->createElement("textarea");
        $text->setAttribute("class", "Developpement");
        $text->setAttribute("name", "r" . $i);
        $text->setAttribute("required", "");
        $div->appendChild($text);

        $liste->appendChild($div);
        $ele->appendChild($liste);
    }
}

?>