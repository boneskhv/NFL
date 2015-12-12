<?php
//regarde si il c'est bien connecter
session_start();
if (!isset($_SESSION["admin"]))
    header("location: index.php");
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

    <title>Survey</title>

</head>
<body onload="LoadAccount()">
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

        <h2 class="form-signin-heading">Accounts</h2>

        <h3 class="form-signin-heading">Add an accounts</h3>
        <div id="add"><!--action="/Admin/AddAccount" method="post"-->
            <input type="email" id="inputEmail" class="" placeholder="Email address" required autofocus name="email">
            <input type="password" id="inputPassword" class="" placeholder="Password" required name="pw">
            <input type="number" id="inputToken" class="BlackText" placeholder="number of token" required name="token">
            <a class="Account-Management" href="#" onclick="AdminAddAccount()">
                <!--<span class="glyphicon glyphicon-floppy-disk"aria-hidden="true"></span>-->
                <input type="image" class="glyphicon glyphicon-floppy-disk" aria-hidden="true"/>
            </a>
        </div>

        <h3 class="form-signin-heading">List of accounts</h3>
        <ul id="lstAccount">

        </ul>
    </div>

</div>
</body>
</html>
