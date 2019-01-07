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
    <title>Dimselab - Oversigt</title>
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
            <li class="nav-item active">
                <a class="nav-link" href="./oversigt">Oversigt</a>
            </li>
            <li class="nav-item nav-dropdown">
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

    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input type="search" name="search" class="form-control" id="overviewsearch" placeholder="Søg artikel" autofocus autocomplete="off">
    </div>

    <form class="form-article row my-4" method="post" action="api/createarticle.php">
        <div class="col-lg-2">
            <input type="text" name="artikel" class="form-control" id="artikel" placeholder="Artikel" required/>
        </div>
        <div class="col-lg-2">
            <select class="custom-select" name="kategori" id="kategori" required>
                <option value="none">>>Kategori<<</option>
                <option>Category 1</option>
                <option>Category 2</option>
                <option>Category 3</option>
                <option>Category 4</option>
                <option>Category 5</option>
            </select>
        </div>
        <div class="col-lg-2">
            <input type="text" name="stregkode" class="form-control" id="stregkode" placeholder="Stregkode" required/>
        </div>
        <div class="col-lg-2">
            <input type="text" name="skuffenr" class="form-control" id="skuffenr" placeholder="Skuffenr" required/>
        </div>
        <div class="col-lg-2">
            <input type="number" min="0" max="1000000" name="antal" class="form-control" id="antal" placeholder="Antal" required/>
        </div>
        <div class="col-lg-2">
            <button id="createarticle" class="btn btn-success btn-block" type="submit">Opret Artikel</button>
        </div>
    </form>

    <div class="content-overview">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Artikel</th>
                <th scope="col">Kategori</th>
                <th scope="col">Stregkode</th>
                <th scope="col">Skuffenr</th>
                <th scope="col">Lager</th>
                <th scope="col">Udlånt</th>
                <th scope="col">I alt</th>
            </tr>
            </thead>
            <tbody id="table-overview">
            <tr>
                <td colspan="7">Ingen artikler hentet</td>
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
            url   : "api/getarticles.php",
        }).done(function (result)
        {
            $("#table-overview").html(result);
        });
        $.ajax({
            method: "GET",
            url   : "api/getcategories.php",
        }).done(function (result)
        {
            $("#kategori").html(result);
        });
    });
    $("#overviewsearch").keyup(function (event)
    {
        var $searchtext = $(event.target).val();

        if ($searchtext.length === 0)
        {
            $.ajax({
                method: "GET",
                url   : "api/getarticles.php",
            }).done(function (result)
            {
                $("#table-overview").html(result);
            });
        }
        else
        {
            $.ajax({
                method: "GET",
                url   : "api/getarticles.php?search=" + $searchtext,
            }).done(function (result)
            {
                $("#table-overview").html(result);
            });
        }
    });
    $(".form-article").submit(function (e)
    {
        var form = $(this);
        var url = form.attr("action");

        $.ajax({
            method: "POST",
            url   : url,
            data  : form.serialize(),
        }).done(function (result)
        {
            alert("Artikel tilføjet")
        });

        e.preventDefault();
    });
</script>
</body>
</html>