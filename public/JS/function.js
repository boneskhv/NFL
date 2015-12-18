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
    //LoadFutureVisitor();
    //LoadFutureLocation();
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

    var id = 1;
    for (i = 1; i < parsedData.length - 1; i++) {
        var content = parsedData[i].replace(',', '');

        var tr = document.createElement("tr");
        var td = document.createElement("td");

        td.appendChild(document.createTextNode(content));
        td.setAttribute("id", "home" + id);
        tr.appendChild(td);
        tr.setAttribute("id", i);

        tableScores.appendChild(tr);
        if(content == "")
            id = id + 1;
    }
    LoadFutureVisitor();
}

//rempli le tableau de visiteur pour les match future
function FillFutureVisitor(data) {
    var parsedData = data.split('\"');

    var id = 1;
    for (i = 1; i < parsedData.length - 1; i++) {
        var content = parsedData[i].replace(',', '');

        var tr = document.getElementById(i.toString());
        var td = document.createElement("td");
        td.setAttribute("text-align", "center");
        td.setAttribute("id", "visitor" + id);

        td.appendChild(document.createTextNode(content));
        tr.appendChild(td);

        if(content == "")
            id = id + 1;
    }
    LoadFutureLocation();
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

    var token = document.getElementById("tokenStand");
    if(token != null)
        BetHome();
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

//rempli la liste de compte
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

//cache/affiche certaine partie de la vue pour la modification de compte
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

//appel de modification d'un compte en AJAX
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

//appel de la suppression d'un compte AJAX
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

//mise a jour du python appeler par un bouton en ce moment
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

//load l'api d'une team pour l'afficher dans une vue
function LoadAPITeam()
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", "/API/Team", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=" + "LoadAPI");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var result = xmlhttp.responseText;
            FillAPI(result, "Team");
        }
    }

    //FillAPITeam();
    LoadAPIGames();
}

//load l'api d'une game pour l'afficher dans une vue
function LoadAPIGames()
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", "/API/Games", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=" + "LoadAPI");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var result = xmlhttp.responseText;
            FillAPI(result, "Games");
        }
    }
}

//rempli l'info de API dans la vue
function FillAPI(data, name)
{
    var p = document.getElementById(name);

    p.appendChild(document.createTextNode(data));

    //LoadAPIGames();
}

//onload de la page d'accueil client
function LoadClientHome()
{
    var tokenStand = document.getElementById("tokenStand");
    tokenStand.innerHTML = "";
    var betAmount = document.getElementById("betAmount");

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", "/Client/GetToken", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=" + "getToken");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var result = xmlhttp.responseText;
            tokenStand.appendChild(document.createTextNode(result));
            betAmount.setAttribute("max", result);
            LoadFutureHome();
        }
    }
}

//rempli le tableau de bet
function BetHome()
{
    var table = document.getElementById("Future");
    var length = table.rows.length;

    var id = 1;
    for(i = 1; i < length + 1; i++)
    {
        var tr = document.getElementById(i.toString());
        if(i % 2 == 0) {
            var td = document.createElement("td");
            var buttonHome = document.createElement("button");
            buttonHome.setAttribute("class", "btn btn-sm btn-primary");
            buttonHome.setAttribute("onclick", "CalculateGains("+ (id).toString() + ", true)");
            buttonHome.appendChild(document.createTextNode("Home"))
            var buttonVisitor = document.createElement("button");
            buttonVisitor.setAttribute("class", "btn btn-sm btn-primary");
            buttonVisitor.setAttribute("onclick", "CalculateGains("+ (id).toString() + ", false)");
            buttonVisitor.appendChild(document.createTextNode("Visitor"))

            td.appendChild(buttonHome);
            td.appendChild(buttonVisitor);

            tr.appendChild(td);

            id = id + 1;
        }
    }
}

//click d'achat de token
function BuyToken()
{
    var token = document.getElementById("token");
    var nbToken = token.value;

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", "/Client/AddToken", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=" + nbToken);

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var result = xmlhttp.responseText;
        }
    }
    LoadClientHome();
}

//appel le calcule de gain et l'affiche dans le txtbox
function CalculateGains(index, isHome)
{
    var btnBet = document.getElementById("btnBet");
    btnBet.removeAttribute("disabled");
    var txtAmount = document.getElementById("betAmount");
    var amount = txtAmount.value;
    var tdTeam;
    var tdOppo;
    if(isHome) {
        tdTeam = document.getElementById("home" + index.toString());
        tdOppo = document.getElementById("visitor" + index.toString());
        btnBet.setAttribute("value", "home " + index);
    }
    else {
        tdTeam = document.getElementById("visitor" + index.toString());
        tdOppo = document.getElementById("home" + index.toString());
        btnBet.setAttribute("value", "visitor " + index);
    }
    var teamName = tdTeam.innerHTML;
    var opponentName = tdOppo.innerHTML;

    var txtCalc = document.getElementById("gainsAmount");



    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "/Client/CalculateGains", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=" + teamName + ";" + opponentName + ";" + amount);

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var result = xmlhttp.responseText;
            txtCalc.value = result;
        }
    }
}

function BetPlaced()
{
    var btnBet = document.getElementById("btnBet");
    $data = btnBet.value.split(' ');
    var home = true;
    if($data[0] != "home")
        home = false;

    var txtAmount = document.getElementById("betAmount");
    var txtReward = document.getElementById("gainsAmount");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "/Client/PlaceBet", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=" + txtAmount.value + ";" + $data[1] + ";" + home + ";" + txtReward.value);

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var result = xmlhttp.responseText;
        }
    }
}

function LoadBetInfo()
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "/Client/BetInfoCurrent", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var result = xmlhttp.responseText;
            FillCurrentBet(result);
        }
    }
}

function FillCurrentBet(data)
{
    var json = JSON.parse(data);
    var amounts = json.map(function(item){
        return item["Amount"];
    });
    var homes = json.map(function(item){
        return item["home"];
    });
    var visitors = json.map(function(item){
        return item["visitor"];
    });
    var locations = json.map(function(item){
        return item["location"];
    });
    var isHome = json.map(function(item){
        return item["Home"];
    });
    var rewards = json.map(function(item){
        return item["Reward"];
    });

    var isPassed = json.map(function(item){
    return item["Status"];
    });
    var betIds = json.map(function(item){
        return item["Id"];
    });

    var tabCurrent = document.getElementById("CurrentBet");
    var tabPassed = document.getElementById("PassedBet");
    tabCurrent.innerHTML = "<tr><th>Amount</th><th>Reward</th><th>Game</th><th>Location</th><th>You are cheering for</th><th>Action</th></tr>";
    tabPassed.innerHTML = "<tr><th>Amount</th><th>Reward</th><th>Game</th><th>Location</th><th>You are cheering for</th><th>Result</th></tr>";
    for(var i = 0; i < amounts.length; i++)
    {
        var tr = document.createElement("tr");
        var tdAmount = document.createElement("td");
        tdAmount.appendChild(document.createTextNode(amounts[i]));
        var tdReward = document.createElement("td");
        tdReward.appendChild(document.createTextNode(rewards[i]));
        var tdGame = document.createElement("td");
        tdGame.appendChild(document.createTextNode(homes[i] + " VS " + visitors[i]));
        var tdVisitor = document.createElement("td");
        tdVisitor.appendChild(document.createTextNode(visitors[i]));
        var tdLocation = document.createElement("td");
        tdLocation.appendChild(document.createTextNode(locations[i]));
        var tdIsVisitor= document.createElement("td");
        if(isHome[i] == 1)
            tdIsVisitor.appendChild(document.createTextNode("home"));
        else
            tdIsVisitor.appendChild(document.createTextNode("visitor"));
        var tdButton = document.createElement("td");
        var btnDel = document.createElement("button");
        btnDel.setAttribute("class", "btn btn-xs btn-primary");
        btnDel.setAttribute("onclick", "DeleteBet(" + betIds[i] + ")");
        btnDel.appendChild(document.createTextNode("Delete Bet"));
        tdButton.appendChild(btnDel)

        tr.appendChild(tdAmount);
        tr.appendChild(tdReward);
        tr.appendChild(tdGame);
        tr.appendChild(tdLocation);
        tr.appendChild(tdIsVisitor);
        if(isPassed[i] == 1) {
            tr.appendChild(tdButton);
            tabCurrent.appendChild(tr);
        }
        else {
            var tdWat = document.createElement("td");
            if(isPassed[i] == 0)
                tdWat.appendChild(document.createTextNode("Won"));

            tr.appendChild(tdWat);
            tabPassed.appendChild(tr);
        }
    }
}

function DeleteBet(id)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "/Client/DeleteBet", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=" + id);

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var result = xmlhttp.responseText;
            LoadBetInfo();
        }
    }
}