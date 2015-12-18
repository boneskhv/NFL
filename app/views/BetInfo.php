<?php
session_start();
//regarde si il c'est bien connecter
if (!isset($_SESSION["client"]))
    header("location: /User/index");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/CSS/Sondage.css"/>
    <link rel="stylesheet" href="/CSS/bootstrap-3.3.5-dist/css/bootstrap.css">
    <!--<link rel="stylesheet" href="bootstrap-3.3.5-dist\css/bootstrap.min.css">-->
    <link rel="stylesheet" href="/CSS/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <!--<link rel="stylesheet" href="bootstrap-3.3.5-dist\css/bootstrap-theme.css">-->
    <link href="data:text/css;charset=utf-8," data-href="../dist/css/bootstrap-theme.min.css" rel="stylesheet"
          id="bs-theme-stylesheet">
    <script src="/JS/function.js"></script>

</head>
<body onload="LoadBetInfo()">
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
                <a class="navbar-brand" href="/User/index">NFL</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse navbar-right">
                <ul class="nav navbar-nav">
                    <li><a href="/Client/BetInfo">Bet Stand</a></li>
                    <li><a href="/User/LogOut">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="SondageCreateHome CenterInfo">
        <div class="panel-body">
            <h2 class="WhiteLink">Current Bets</h2>
            <table id="CurrentBet" class="table ">
                <tr>
                    <th>Amount</th>
                    <th>Reward</th>
                    <th>Game</th>
                    <th>Location</th>
                    <th>You are cheering for</th>
                    <th>Action</th>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="SondageCreateHome CenterInfo">
        <div class="panel-body">
            <h2 class="WhiteLink">Passed Bets</h2>
            <table id="PassedBet" class="table">
                <tr>
                    <th>Amount</th>
                    <th>Reward</th>
                    <th>Game</th>
                    <th>Location</th>
                    <th>You were cheering for</th>
                </tr>
            </table>
        </div>
    </div>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>