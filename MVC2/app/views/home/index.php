
Hello <?=$data['name']?>
<?php

echo '<script src="l.js"></script>';
echo '<script>lol()</script>';

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../CSS/Sondage.css" />
    <link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap.css">
    <!--<link rel="stylesheet" href="bootstrap-3.3.5-dist\css/bootstrap.min.css">-->
    <link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <!--<link rel="stylesheet" href="bootstrap-3.3.5-dist\css/bootstrap-theme.css">-->

    <title>Baker Survey</title>
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <form class="navbar-form navbar-right" action="/NFL/MVC2/public/index.php/home/HomeTP" method="post">>
                <div class="form-group">
                    <input type="email" id="inputEmail" placeholder="Email" class="form-control" required autofocus name="email">
                </div>
                <div class="form-group">
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="pw">
                </div>
                <button type="submit" class="btn btn-success">Sign in</button>
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</div>

<!--
<div class="container">
    <form class="form-signin" action="/NFL/MVC2/public/index.php/home/HomeTP" method="post">
        <div>
            <div class="panel-body">
                <h2 class="form-signin-heading">Please sign in</h2>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus name="email">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="pw">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                <!--<a class="CreateAccount" href="#">Create account</a>-->
           <!-- </div>
        </div>
    </form>
</div>-->
</body>
</html>
