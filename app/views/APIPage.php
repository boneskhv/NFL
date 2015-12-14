<?php
//regarde si il c'est bien connecter
session_start();

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/CSS/Sondage.css"/>
    <link rel="stylesheet" href="/CSS/bootstrap-3.3.5-dist/css/bootstrap.css">
    <!--<link rel="stylesheet" href="bootstrap-3.3.5-dist\css/bootstrap.min.css">-->
    <link rel="stylesheet" href="/CSS/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <!--<link rel="stylesheet" href="bootstrap-3.3.5-dist\css/bootstrap-theme.css">-->
    <link href="data:text/css;charset=utf-8," data-href="../dist/css/bootstrap-theme.min.css" rel="stylesheet"
          id="bs-theme-stylesheet">
    <script src="/JS/function.js"></script>

    <title>NFL</title>

</head>
<body onload="LoadAPITeam()">
<div>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">NFL</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse navbar-right">
                <ul class="nav navbar-nav">
                    <li><a href="SignOut.php">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="container">

    <div class="panel-body form-Account-Management">

        <h2 class="form-signin-heading">API</h2>

        <div class="panel-body">
            <h3>Team <a class="WhiteLink" href="#" onclick="ShowHide('Team')"><span class="glyphicon glyphicon-eye-open"aria-hidden="true"></span></a></h3>
            <p class="" id="Team" style="display: none"></p>
            <h3>Games <a class="WhiteLink" href="#" onclick="ShowHide('Games')"><span class="glyphicon glyphicon-eye-open"aria-hidden="true"></span></a></h3>
            <p id="Games" style="display: none"></p>
            <h3>Gains <a class="WhiteLink" href="#" onclick="ShowHide('Gains')"><span class="glyphicon glyphicon-eye-open"aria-hidden="true"></span></a></h3>
            <p id="Gains" style="display: none"></p>
        </div>

        <h3 class="form-signin-heading">List of accounts</h3>
        <ul id="lstAccount">

        </ul>
    </div>

</div>
</body>
</html>