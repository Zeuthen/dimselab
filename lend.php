<?php
session_start();
if ( ! isset( $_SESSION["user"] ) ) {
	header( "location: logind" );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dimselab - Udlån</title>
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
            <li class="nav-item active nav-dropdown">
                <a class="nav-link" href="./udlån">Udlån</a>
            </li>
            <!--<li class="nav-item nav-dropdown">
                <a class="nav-link" href="./udlånreturnering">Udlån/Returnering</a>
                <div class="dropdown-submenu" aria-labelledby="dropdownLending">
                    <a class="submenu-item" href="./udlån">Udlån</a>
                    <a class="submenu-item" href="./returnering">Returnering</a>
                </div>
            </li>-->
            <li class="nav-item nav-dropdown">
                <a class="nav-link" href="./historik">Historik</a>
                <div class="dropdown-submenu" aria-labelledby="dropdownHistory">
                    <a class="submenu-item" href="./projekter">Projekter</a>
                    <a class="submenu-item" href="./statistik">Statistik</a>
                </div>
            </li>
        </ul>
        <ul class="form-inline ml-auto navbar-nav">
            <li class="nav-item"><span class="navbar-text">Velkommen <strong><?php echo $_SESSION["user"] ?></strong></span></li>
            <li><a class="nav-link" href="./logud">Log ud</a></li>
        </ul>
    </div>
</nav>
<div class="container content">

    <form class="form-checklend row" method="GET" action="api/getarticle.php">
        <div class="col-lg-10">
            <input type="text"
                   name="stregkode"
                   class="form-control"
                   id="stregkode"
                   placeholder="Stregkode"
                   autofocus
                   required
                   autocomplete="off"></div>
        <div class="col-lg-2">
            <button id="checklend" class="btn btn-primary btn-block" type="submit">Tjek Stregkode</button>
        </div>
    </form>

    <form class="form-lend row my-4" method="POST" action="api/lend.php">
        <div class="col-lg-2">
            <input type="text" name="artikel" class="form-control" id="artikel" placeholder="Artikel" readonly title="artikel"/>
        </div>
        <div class="col-lg-2">
            <input type="text" name="stregkode" class="form-control" id="stregkode" placeholder="Stregkode" readonly title="stregkode"/>
        </div>
        <div class="col-lg-2">
            <input type="text" name="projekt" class="form-control" id="projekt" placeholder="Projekt navn" required title="projekt"/>
        </div>
        <div class="col-lg-2">
            <input type="text" name="beskrivelse" class="form-control" id="beskrivelse" placeholder="Projekt beskrivelse" required
                   title="beskrivelse"/>
        </div>
        <div class="col-lg-2">
            <input type="number" name="antal" class="form-control" id="antal" placeholder="Antal" readonly title="antal"/>
        </div>
        <div class="col-lg-2">
            <button id="addlend" class="btn btn-success btn-block" type="submit">Tilføj til udlån</button>
        </div>
    </form>
</div>

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/all.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script>
    $(".form-checklend").submit(function (e)
    {
        var form = $(this);
        var url = form.attr("action") + "?stregkode=" + $("#stregkode").val();

        $.ajax({
            method  : "GET",
            url     : url,
            dataType: "json",
        }).done(function (response)
        {
            var result = response[0];
            $(".form-lend #artikel").val(result["Artikel"]);
            $(".form-lend #stregkode").val(result["Stregkode"]);
            $(".form-lend #antal").val("1");
        });

        e.preventDefault();
    });
    $(".form-lend").submit(function (e)
    {
        var form = $(this);
        var url = form.attr("action");

        $.ajax({
            method: "POST",
            url   : url,
            data  : form.serialize(),
        }).done(function (response)
        {
            //KNAP_3_UDSTYR
            alert("udlån fuldført"+response)
        });

        e.preventDefault();
    });
</script>
</body>
</html>