function LoadHome()
{
    var xmlhttp = new XMLHttpRequest();

    var tableScores = document.getElementById("Scores");
    var tableFutur = document.getElementById("Futur");

    xmlhttp.open("POST", "../app/controllers/User.php/LoadHome", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=LoadHome");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var tabTables = xmlhttp.responseText.split(';');
            var tabScores = tabTables[0].split(',');
            var tabFutur = tabTables[1].split(',');
        }
    }
}