<?php


?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/CSS/Sondage.css"/>
    <link rel="stylesheet" href="/CSS/bootstrap-3.3.5-dist/css/bootstrap.css">
    <!--<link rel="stylesheet" href="bootstrap-3.3.5-dist\css/bootstrap.min.css">-->
    <link rel="stylesheet" href="/CSS/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <!--<link rel="stylesheet" href="bootstrap-3.3.5-dist\css/bootstrap-theme.css">-->
    <script src="/JS/function.js"></script>

    <title>Baker Survey</title>
</head>
<body onload="LoadHome()">

<div class="navbar navbar-inverse navbar-fixed-top">
    <a target="_blank" href="https://github.com/dragonmost/NFL" ><img style="position: absolute; top: 0; left: 0; border: 0;" src="https://camo.githubusercontent.com/c6286ade715e9bea433b4705870de482a654f78a/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f6c6566745f77686974655f6666666666662e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_left_white_ffffff.png"></a>

    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand tabIt" href="#" style="margin-left: 100px">Baker NFL</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <!-- action="app/models/function.php" -->
            <form class="navbar-form navbar-right" action="/User/login" method="post">
                <div class="form-group">
                    <input type="email" id="inputEmail" placeholder="Email" class="form-control" required autofocus
                           name="email">
                </div>
                <div class="form-group">
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required
                           name="password">
                </div>
                <button type="submit" class="btn btn-success">Sign in</button>
            </form>
        </div>
        <!--/.navbar-collapse -->
    </div>
</div>

<div class="container CenterInfo">
    <div class="panel-body">
        <button class="BlackText" onclick="UpdatePython()">Refresh data</button>
        <a class="WhiteLink" onclick="ShowHide('Scores')"><h2>Scores</h2></a>
        <table id="Scores"></table>
        <a class="WhiteLink" onclick="ShowHide('Future')"><h2>Future games</h2></a>
        <table id="Future"></table>
    </div>
</div>

</body>
</html>
