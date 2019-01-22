<?php
session_start();
if ( ! isset( $_SESSION["user"] ) )
{
	header( "location: logind" );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Udlån - Dimselab</title>
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

    <div class="col-lg-6 offset-lg-3">
        <form class="form-lend my-4" method="POST" action="api/lend.php">
            <div class="mb-3">
                <label for="artikel">Artikel</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="artikel" name="artikel" placeholder="Artikel" readonly required="" title="artikel">
                </div>
            </div>
            <div class="mb-3">
                <label for="stregkode">Scan Stregkode</label>
                <div class="input-group">
                    <div class="col-lg-8">
                        <div class="row">
                            <input type="text"
                                   class="form-control"
                                   id="stregkode"
                                   name="stregkode"
                                   placeholder="Stregkode"
                                   required=""
                                   title="artikel">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <button id="checkstregkode" class="btn btn-primary btn-block">Tjek Stregkode</button>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="projekt">Projekt</label>
                <div class="input-group">
                    <select class="custom-select" name="projekt" id="projekt" required>
                        <option value="">Projekt</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <button id="addlend" class="btn btn-success btn-block" type="submit">Tilføj til udlån</button>
            </div>
        </form>
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
            url   : "api/getprojects.php",
        }).done(function (result)
        {
            $("select#projekt").html(result);
        });
    });

    $(".form-lend #checkstregkode").click(function (e)
    {
        if ($(".form-lend #stregkode").val().length > 0)
        {
            var url = "api/getarticle.php?stregkode=" + $(".form-lend #stregkode").val();

            $.ajax(
                {
                    method  : "GET",
                    url     : url,
                    dataType: "json",
                }).done(function (response)
                {
                    if (response.length > 0)
                    {
                        var result = response[0];
                        alert("Vi fandt "+ result["Artikel"]);
                        $(".form-lend #artikel").val(result["Artikel"]);
                    }
                    else
                    {
                        alert("Ingen artikel");
                    }
                }
            );
        }
        else
        {
            alert("Scan stregkode");
        }
        e.preventDefault();
    });

    $(".form-checklend").click(function (e)
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
            alert("udlån fuldført" + response);
        });

        e.preventDefault();
    });
</script>
</body>
</html>