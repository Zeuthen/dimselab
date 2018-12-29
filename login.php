<?php
/**
 * Created by PhpStorm.
 * User: brorm
 * Date: 29/12/2018
 * Time: 01:23
 */
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="css/all.min.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body class="bg-light mt-5">
<h1 class="text-center mb-5">Velkommen til Dimselab</h1>

<form class="needs-validation form-login text-center mx-auto mt-5 px-3 py-3" novalidate="" method="post">
    <div class="mb-3">
        <label for="email" class="sr-only">E-mail adresse</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="email" class="form-control" id="email" placeholder="dit-navn@edu.easj.dk" required autofocus autocomplete="off">
            <div class="invalid-feedback">
                Indtastet e-mail er ikke korrekt format
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="password" class="sr-only">Adgangskode</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password" class="form-control" id="password" placeholder="***********" required="">
            <div class="invalid-feedback">
                Feltet er ikke udfyldt
            </div>
        </div>
    </div>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="remember-me">
        <label class="custom-control-label" for="remember-me">Husk mig</label>
    </div>
    <hr class="mb-4">
    <button class="btn btn-primary btn-lg btn-block" type="submit">Log ind</button>
</form>

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/all.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script>
  /*  $(function ()
    {
    });*/
    $(".needs-validation").submit(function (e)
    {
        if ($(this)[0].checkValidity() === false)
        {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass("was-validated");
    });
</script>
</body>
</html>
