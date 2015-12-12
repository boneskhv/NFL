//requete AJAX des scores
function LoadHome() {
    var xmlhttp = new XMLHttpRequest();

    //xmlhttp.open("POST", "../app/controllers/User.php/LoadHome", true);
    //xmlhttp.open("POST", "/NFL/User/LoadHome", true);
    xmlhttp.open("POST", "/User/LoadScore", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=LoadHome");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var tabTablesScore = xmlhttp.responseText;
            FillScore(tabTablesScore);
        }
    }

    NextAJAX();
}

//fait une liste de call AJAX
function NextAJAX() {
    LoadFutureHome();
    LoadFutureVisitor();
    LoadFutureLocation();
}

//requete AJAX pour les match future
function LoadFutureHome() {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", "/User/LoadFutureHome", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=LoadHome");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var tabTablesFuture = xmlhttp.responseText;
            FillFutureHome(tabTablesFuture);
        }
    }
}

//requete AJAX pour la liste de visiteur des match future
function LoadFutureVisitor() {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", "/User/LoadFutureVisitor", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=LoadHome");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var tabTablesFuture = xmlhttp.responseText;
            FillFutureVisitor(tabTablesFuture);
        }
    }
}

//requete AJAX pour les location des match future
function LoadFutureLocation() {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", "/User/LoadFutureLocation", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=LoadHome");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var tabTablesFuture = xmlhttp.responseText;
            FillFutureLocation(tabTablesFuture);
        }
    }
}

//rempli le tableau de score
function FillScore(data) {
    var tableScores = document.getElementById("Scores");
    var parsedData = data.split('\"');

    for (i = 1; i < parsedData.length - 1; i++) {
        if (i % 2 == 0)
            var content = parsedData[i].replace(',', '');
        else
            var content = parsedData[i];

        var tr = document.createElement("tr");
        var td = document.createElement("td");

        tr.appendChild(document.createTextNode(content));
        tr.appendChild(td);

        tableScores.appendChild(tr);
    }
}

//rempli le tableau pour les match future
function FillFutureHome(data) {
    var tableScores = document.getElementById("Future");
    var parsedData = data.split('\"');

    for (i = 1; i < parsedData.length - 1; i++) {
        var content = parsedData[i].replace(',', '');

        var tr = document.createElement("tr");
        var td = document.createElement("td");

        td.appendChild(document.createTextNode(content));
        tr.appendChild(td);
        tr.setAttribute("id", i);

        tableScores.appendChild(tr);
    }
}

//rempli le tableau de visiteur pour les match future
function FillFutureVisitor(data) {
    var parsedData = data.split('\"');

    for (i = 1; i < parsedData.length - 1; i++) {
        var content = parsedData[i].replace(',', '');

        var tr = document.getElementById(i.toString());
        var td = document.createElement("td");
        td.setAttribute("text-align", "center");

        td.appendChild(document.createTextNode(content));
        tr.appendChild(td);
    }
}

//rempli le tableau de location pour les match future
function FillFutureLocation(data) {
    var parsedData = data.split('\"');

    for (i = 1; i < parsedData.length - 1; i++) {
        var content = parsedData[i].replace(',', '');

        var tr = document.getElementById(i.toString());
        var td = document.createElement("td");

        td.appendChild(document.createTextNode(content));
        tr.appendChild(td);
    }
}

//affiche ou cache l'objet dont le nom est donne en parametre
function ShowHide(tabName) {
    var tag = document.getElementById(tabName);
    if (tag.style.display == "none")
        tag.style.display = "inline";
    else
        tag.style.display = "none";
}

///AdminHome///
function LoadAccount() {
    var xmlhttp = new XMLHttpRequest();

    //xmlhttp.open("POST", "../app/controllers/User.php/LoadHome", true);
    //xmlhttp.open("POST", "/NFL/User/LoadHome", true);
    xmlhttp.open("POST", "/Admin/LoadAccountList", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=LoadAccount");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var tabResult = xmlhttp.responseText;
            FillAccountList(tabResult);
        }
    }
}

function FillAccountList(data) {
    var tag = document.getElementById("lstAccount");
    var parsedData = data.split('\"');

    for (i = 1; i < parsedData.length - 1; i++) {
        var li = document.createElement("li");


        var divNorm = document.createElement("div");
        divNorm.setAttribute("id", "norm " + i);
        var divMod = document.createElement("div");
        divMod.setAttribute("id", "norm " + i);
        divMod.setAttribute("style", "display.none");

        //partie normal
        var lblNorm = document.createElement("label");
        lblNorm.appendChild(document.createTextNode(parsedData[i]));
        lblNorm.setAttribute("value", parsedData[i]);
        var pencil = document.createElement("a");
        var pencilSpan = document.createElement("span");
        pencilSpan.setAttribute("class", "glyphicon glyphicon-pencil");
        pencilSpan.setAttribute("aria-hidden", "true");
        pencil.appendChild(pencilSpan);
        pencil.setAttribute("class", "Account-Management");
        pencil.setAttribute("href", "javascript:Pencil(" + "'" + i + "')");

        divNorm.appendChild(lblNorm);
        divNorm.appendChild(pencil);

        //partie de modification
        var oldName = document.createElement("label");
        //oldName.setAttribute("type", "hidden");
        oldName.setAttribute("name", "oldName");
        oldName.setAttribute("value", parsedData[i]);
        oldName.appendChild(document.createTextNode(parsedData[i]));
        var inputPw = document.createElement("input");
        inputPw.setAttribute("type", "email");
        inputPw.setAttribute("placeholder", "password");
        inputPw.setAttribute("name", "inputPw");
        var inputToken = document.createElement("input");
        inputToken.setAttribute("type", "email");
        inputToken.setAttribute("placeholder", "number of Token");
        inputToken.setAttribute("name", "inputToken");
        var btnSave = document.createElement("button");
        btnSave.setAttribute("class", "btn btn-xs btn-default");
        btnSave.appendChild(document.createTextNode("Modify"));
        var btnCancel = document.createElement("button");
        btnCancel.setAttribute("class", "btn btn-xs btn-default");
        btnCancel.appendChild(document.createTextNode("Cancel"));

        divMod.appendChild(oldName);
        divMod.appendChild(inputPw);
        divMod.appendChild(inputToken);
        divMod.appendChild(btnSave);
        divMod.appendChild(btnCancel);

        tag.appendChild(divNorm);
        tag.appendChild(divMod);
    }


}


//appel AJAX pour ajouter un compte
function AdminAddAccount() {
    var data;
    var name = document.getElementById("inputEmail");
    var pw = document.getElementById("inputPassword");
    var token = document.getElementById("inputToken");

    data = name.value + ";" + pw.value + ";" + token.value;

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", "/Admin/AddAccount", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("data=" + data);

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var tabResult = xmlhttp.responseText;
            alert(tabResult);
        }
    }

}