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
<body onload="LoadClientHome()">
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
                    <li><a href="/User/LogOut">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" style="min-height: 5%;">
    <div class="SondageCreateHome TextCenter">
        <div class="panel-body">
            <h2 class="WhiteHeader">Token Stand</h2>

            <h3>Current Token coun: <label id="tokenStand"></label></h3>
            <input type="number" id="token" class="BlackText" min="1" value="20" placeholder="Quantity" name="nbQ"
                   required></br>
            <!--<button class="btn btn-sm btn-primary" onclick="BuyToken()">Buy</button>-->
            <a href="#" onclick="BuyToken()"><img src="../img/Paynow.png"></a>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="SondageCreateHome CenterInfo">
        <div class="panel-body">
            <h2 class="WhiteLink">Bets</h2>
            </p>
            <label>Token amount:
                <input type="number" id="betAmount" class="BlackText" min="10" value="10"
                       placeholder="token bet amount" required>
            </label>
            <label>Gains amount:
                <input class="BlackText" type="number" id="gainsAmount" placeholder="calculate" readonly>
            </label>
            <button class="btn btn-sm btn-primary" id="btnBet" onclick="BetPlaced()" disabled>Bet</button>
            </p>
            <table id="Future"></table>
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