function LoadHome()
{
    var xmlhttp = new XMLHttpRequest();

    //xmlhttp.open("POST", "../app/controllers/User.php/LoadHome", true);
    //xmlhttp.open("POST", "/NFL/User/LoadHome", true);
    xmlhttp.open("POST", "/User/LoadScore", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=LoadHome");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var tabTables = xmlhttp.responseText;
            FillScore(tabTables);
        }
    }

    var xmlhttp = new XMLHttpRequest();

    //xmlhttp.open("POST", "../app/controllers/User.php/LoadHome", true);
    //xmlhttp.open("POST", "/NFL/User/LoadHome", true);
    xmlhttp.open("POST", "/User/LoadFuture", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Action=LoadHome");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var tabTables = xmlhttp.responseTex;
            //var tabScores = tabTables[0].split(',');
            FillFuture(tabTables);
        }
    }
}

function FillScore(data)
{
    var tableScores = document.getElementById("Scores");
    var parseResult = data.split(',');

    for(i = 0; i < data.length; i++)
    {
        var tr = document.createElement("tr");
        var td = document.createElement("td");

        tr.appendChild( document.createTextNode(parseResult[i]));
        tr.appendChild(td);


        tableScores.appendChild(tr);
    }
}

function FillFuture(data)
{
    var tableFutur = document.getElementById("Future");
}