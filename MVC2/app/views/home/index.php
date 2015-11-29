
Hello <?=$data['name']?>
<?php

echo '<script src="l.js"></script>';
echo '<script>lol()</script>';

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../../CSS/Sondage.css" />
    <link rel="stylesheet" href="../../../../bootstrap-3.3.5-dist/css/bootstrap.css">
    <!--<link rel="stylesheet" href="bootstrap-3.3.5-dist\css/bootstrap.min.css">-->
    <link rel="stylesheet" href="../../../../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <!--<link rel="stylesheet" href="bootstrap-3.3.5-dist\css/bootstrap-theme.css">-->

    <title>Baker Survey</title>
</head>
<body>
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
            </div>
        </div>
    </form>
</div>
</body>
</html>
