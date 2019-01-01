<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 21/11/2018
 * Time: 01:44
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
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Dimselab</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDimselab" aria-controls="navbarDimselab"
            aria-expanded="false" aria-label="Vis menu">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarDimselab">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./">Oversigt <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link" href="#">Udlån/Returnering</a>
                <div class="dropdown-submenu" aria-labelledby="dropdownLending">
                    <a class="submenu-item" href="#">Udlån</a>
                    <a class="submenu-item" href="#">Returnering</a>
                </div>
            </li>
            <li class="nav-item active nav-dropdown">
                <a class="nav-link" href="#">Historik</a>
                <div class="dropdown-submenu" aria-labelledby="dropdownHistory">
                    <a class="submenu-item" href="#">Projekter</a>
                    <a class="submenu-item" href="#">Statistik</a>
                </div>
            </li>
        </ul>
        <ul class="form-inline ml-auto navbar-nav">
            <li class="nav-item"><span class="navbar-text">Velkommen <strong>Username</strong></span></li>
            <li><a class="nav-link" href="#">Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container">

    <h1 class="text-center mb-3">Velkommen til Dimselab</h1>
    <div class="row">
        <div class="col-lg-6">
            <a href="./projekter" role="button" class="btn btn-secondary btn-lg d-block">Projekter</a></div>
        <div class="col-lg-6">
            <a href="./statistik" role="button" class="btn btn-secondary btn-lg d-block">Statistik</a></div>

    </div>
</div>

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/all.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>