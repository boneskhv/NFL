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

    tableScores.innerHTML = "";

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

    tableScores.innerHTML = "";

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
    tag.innerHTML = "";
    var parsedData = data.split('\"');

    for (i = 1; i < parsedData.length - 1; i++) {
        if (parsedData[i] != ",") {
            var id = i.toString();
            var li = document.createElement("li");

            var divNorm = document.createElement("div");
            divNorm.setAttribute("id", "norm " + id);
            divNorm.setAttribute("style", "display:block");
            var divMod = document.createElement("div");
            divMod.setAttribute("id", "mod " + id);
            divMod.setAttribute("style", "display:none");

            //partie normal
            var lblName = document.createElement("label");
            lblName.appendChild(document.createTextNode(parsedData[i]));
            lblName.setAttribute("value", parsedData[i]);
            var pencil = document.createElement("a");
            var pencilSpan = document.createElement("span");
            pencilSpan.setAttribute("class", "glyphicon glyphicon-pencil");
            pencilSpan.setAttribute("aria-hidden", "true");
            pencil.appendChild(pencilSpan);
            pencil.setAttribute("class", "Account-Management");
            pencil.setAttribute("href", "javascript:Pencil('" + id + "')");

            divNorm.appendChild(lblName);
            divNorm.appendChild(pencil);

            //partie de modification
            var oldName = document.createElement("label");
            //oldName.setAttribute("type", "hidden");
            oldName.setAttribute("name", "oldName");
            oldName.setAttribute("value", parsedData[i]);
            oldName.setAttribute("id", "name " + id);
            oldName.appendChild(document.createTextNode(parsedData[i]));
            var inputPw = document.createElement("input");
            inputPw.setAttribute("type", "password");
            inputPw.setAttribute("placeholder", "password");
            inputPw.setAttribute("id", "Pw " + id);
            var inputToken = document.createElement("input");
            inputToken.setAttribute("type", "number");
            inputToken.setAttribute("class", "BlackText");
            inputToken.setAttribute("placeholder", "number of Token");
            inputToken.setAttribute("id", "Token " + id);
            inputToken.setAttribute("min", "20");
            var btnSave = document.createElement("button");
            btnSave.setAttribute("class", "btn btn-xs btn-default");
            btnSave.setAttribute("onclick", "ModifyAccount(" + i.toString() + ")");
            btnSave.appendChild(document.createTextNode("Modify"));
            var btnDel = document.createElement("button");
            btnDel.setAttribute("class", "btn btn-xs btn-default");
            btnDel.setAttribute("onclick", "Trash(" + i.toString() + ")");
            btnDel.appendChild(document.createTextNode("Delete"));
            var btnCancel = document.createElement("button");
            btnCancel.setAttribute("class", "btn btn-xs btn-default");
            btnCancel.setAttribute("onclick", "Pencil(" + i.toString() + ")");
            btnCancel.appendChild(document.createTextNode("Cancel"));

            divMod.appendChild(oldName);
            divMod.appendChild(inputPw);
            divMod.appendChild(inputToken);
            divMod.appendChild(btnSave);
            divMod.appendChild(btnDel);
            divMod.appendChild(btnCancel);

            tag.appendChild(divNorm);
            tag.appendChild(divMod);
        }
    }


}

function Pencil(index) {
    var divNorm = document.getElementById("norm " + index.toString());
    var divMod = document.getElementById("mod " + index.toString());

    if (divNorm.style.display == "none") {
        divNorm.style.display = "block";
        divMod.style.display = "none";
    }
    else {
        divNorm.style.display = "none";
        divMod.style.display = "block";
    }
}

function ModifyAccount(index) {
    var lblName = document.getElementById("name " + index.toString());
    var name = lblName.innerHTML;

    var lblPW = document.getElementById("Pw " + index.toString());
    var lblToken = document.getElementById("Token " + index.toString());
    var pw = lblPW.value;
    var token = lblToken.value;

    if (pw == "" && token == "") {
        alert("at least one of the field mosst be filled.");
    }
    else {
        if(pw == "") {
            pw = " ";
        }
        else if(token == "") {
            token = " ";
        }
        var data = name + ";" + pw + ";" + token;

        var xmlhttp = new XMLHttpRequest();

        xmlhttp.open("POST", "/Admin/ModifyAccount", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("data=" + data);

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var Result = xmlhttp.responseText;
                //alert(Result);
            }
        }
        LoadAccount();
    }
}

function Trash(index) {
    var lblName = document.getElementById("name " + index.toString());
    var name = lblName.innerHTML;

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", "/Admin/DeleteAccount", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("data=" + name);

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var Result = xmlhttp.responseText;
            alert(Result);
        }
    }
    LoadAccount();
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
            var Result = xmlhttp.responseText;
            alert(Result);
        }
    }

    name.innerHTML = "";

    LoadAccount();
}

function UpdatePython()
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", "/User/UpdatePython", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=" + "updatePython");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var Result = xmlhttp.responseText;
            alert("Requete completed");
            LoadHome();
        }
    }
}