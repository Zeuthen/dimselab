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
                <a class="nav-link" href="./">Oversigt</a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link" href="#">Udlån/Returnering</a>
                <div class="dropdown-submenu" aria-labelledby="dropdownLending">
                    <a class="submenu-item" href="#">Udlån</a>
                    <a class="submenu-item" href="#">Returnering</a>
                </div>
            </li>
            <li class="nav-item nav-dropdown">
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

    <div class="content-overview">
        <form class="needs-validation form-login mx-auto mt-5 px-3 py-3" novalidate="" method="post">
            <div class="mb-3">
                <label for="artikel">Artikel</label>
                <div class="input-group">
                    <input type="text" name="artikel" class="form-control" id="artikel" placeholder="artikel navn" required autofocus
                           autocomplete="off">
                    <div class="invalid-feedback">
                        Feltet er ikke udfyldt
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="kategori">Kategori</label>
                <select class="custom-select" id="kategori" required>
                    <option value="none">vælg kategori</option>
                    <option>United States</option>
                </select>
                <div class="invalid-feedback">
                    Vælg en kategori
                </div>
            </div>
            <div class="mb-3">
                <label for="skuffe">Skuffe</label>
                <div class="input-group">
                    <input type="number" name="skuffe" class="form-control" id="skuffe" placeholder="01-99" min="1" max="1000000" required
                           autocomplete="off">
                    <div class="invalid-feedback">
                        Feltet er ikke udfyldt
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="stregkode">Stregkode</label>
                <div class="input-group">
                    <input type="text" name="stregkode" class="form-control" id="stregkode" placeholder="stregkode" required autocomplete="off">
                    <div class="invalid-feedback">
                        Feltet er ikke udfyldt
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="antal">Antal</label>
                <div class="input-group">
                    <input type="number" name="antal" class="form-control" id="antal" placeholder="1-9999" min="1" max="1000000" required autocomplete="off">
                    <div class="invalid-feedback">
                        Indtastet værdi er ikke korrekt format
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-lg btn-block" type="submit">Opret Artikel</button>
        </form>
    </div>

</div>

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/all.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>