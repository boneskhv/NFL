<?php


class LoadView
{

    public static function AdminHome()
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

    public static function ClientHome()
    {
        $doc = new DOMDocument();
        $doc->loadHTMLFile("../app/views/home/ClientHome.php");

        echo $doc->SaveHTML();
    }
}