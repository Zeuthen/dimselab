<?php
session_start();
if ( isset( $_SESSION["USER"] ) )
{
	header( "location: oversigt" );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Dimselab</title>
    <link rel="shortcut icon" type="image/png" href="assets/favicon.ico"/>
    <link rel="stylesheet" href="css/all.min.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body class="bg-light mt-5">
<h1 class="text-center mb-5">Velkommen til Dimselab</h1>

<form class="form-login text-center mx-auto mt-5 px-3 py-3 w-25" method="post">
    <div class="mb-3">
        <label for="email" class="sr-only">E-mail adresse</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="email"
                   id="login-email"
                   name="email"
                   class="form-control"
                   placeholder="dit-navn@edu.easj.dk"
                   required
                   autofocus
                   autocomplete="off">
        </div>
    </div>
    <div class="mb-3">
        <label for="login-password" class="sr-only">Adgangskode</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password" id="login-password" name="password" class="form-control" placeholder="***********" required>
        </div>
    </div>
    <!--<div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="remember-me">
        <label class="custom-control-label" for="remember-me">Husk mig</label>
    </div>-->
    <hr class="mb-4">
    <button class="btn btn-primary btn-lg btn-block" type="submit">Log ind</button>
</form>

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/all.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<script>
    /*  $(function ()
     {
     });*/
    $(".form-login").submit(function (e)
    {
        var form = $(this);
        $.ajax({
            method: "POST",
            url   : "api/user/login.php",
            data  : form.serialize(),
        }).done(function (response)
        {
            if (response["message"] === "login was successful")
            {
                window.location = "oversigt";
            }
            else
            {
                alert(response["message"]);
            }
        }).fail(function (response)
        {
            alert(response["message"]);
        });

        e.preventDefault();
    });
</script>
</body>
</html>
