<?php
session_start();
if(!isset($_SESSION["user"])){
	header("location: logind");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dimselab - Statistik</title>
    <link rel="shortcut icon" type="image/png" href="assets/favicon.ico"/>
    <link rel="stylesheet" href="css/all.min.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="./">Dimselab</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDimselab" aria-controls="navbarDimselab"
            aria-expanded="false" aria-label="Vis menu">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarDimselab">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./oversigt">Oversigt</a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link" href="./udlånreturnering">Udlån/Returnering</a>
                <div class="dropdown-submenu" aria-labelledby="dropdownLending">
                    <a class="submenu-item" href="./udlån">Udlån</a>
                    <a class="submenu-item" href="./returnering">Returnering</a>
                </div>
            </li>
            <li class="nav-item active nav-dropdown">
                <a class="nav-link" href="./historik">Historik</a>
                <div class="dropdown-submenu" aria-labelledby="dropdownHistory">
                    <a class="submenu-item" href="./projekter">Projekter</a>
                    <a class="submenu-item" href="./statistik">Statistik</a>
                </div>
            </li>
        </ul>
        <ul class="form-inline ml-auto navbar-nav">
            <li class="nav-item"><span class="navbar-text">Velkommen <strong><?php echo $_SESSION["user"]?></strong></span></li>
            <li><a class="nav-link" href="./logud">Log ud</a></li>
        </ul>
    </div>
</nav>
<div class="container content">

    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input type="search" name="search" class="form-control" id="statisticsearch" placeholder="Søg statistik" autofocus
               autocomplete="off">
    </div>

    <div class="content-overview">
        <table class="table table-hover mt-4">
            <thead>
            <tr>
                <th scope="col">Artikel</th>
                <th scope="col">Stregkode</th>
                <th scope="col">Bruger</th>
                <th scope="col">Projekt</th>
                <th scope="col">Dato</th>
            </tr>
            </thead>
            <tbody id="table-statistic">
            <tr>
                <td colspan="7">Ingen statistikker hentet</td>
            </tr>
            </tbody>
        </table>
    </div>

</div>

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/all.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script>
    $(document).ready(function ()
    {
        $.ajax({
            method: "GET",
            url   : "api/getstatistics.php",
        }).done(function (result)
        {
            $("#table-statistic").html(result);
        });
    });
    $("#statisticsearch").keyup(function (event)
    {
        var $searchtext = $(event.target).val();

        if ($searchtext.length === 0)
        {
            $.ajax({
                method: "GET",
                url   : "api/getstatistics.php",
            }).done(function (result)
            {
                $("#table-statistic").html(result);
            });
        }
        else
        {
            $.ajax({
                method: "GET",
                url   : "api/getstatistics.php?search=" + $searchtext,
            }).done(function (result)
            {
                $("#table-statistic").html(result);
            });
        }
    });
</script>
</body>
</html>