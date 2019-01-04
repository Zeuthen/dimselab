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
                <a class="nav-link" href="./udlånreturnering">Udlån/Returnering</a>
                <div class="dropdown-submenu" aria-labelledby="dropdownLending">
                    <a class="submenu-item" href="./udlån">Udlån</a>
                    <a class="submenu-item" href="./returnering">Returnering</a>
                </div>
            </li>
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
        <input type="search" name="livesearch" class="form-control" id="livesearch" placeholder="Søg" autofocus autocomplete="off">
    </div>

    <form class="row my-4">
        <div class="col-lg-2">
            <input type="text" name="artikel" class="form-control" id="artikel" placeholder="Artikel" required/>
        </div>
        <div class="col-lg-2">
            <select class="custom-select" id="kategori" required>
                <option value="none">>>Kategori<<</option>
                <option>Category 1</option>
                <option>Category 2</option>
                <option>Category 3</option>
                <option>Category 4</option>
                <option>Category 5</option>
            </select>
        </div>
        <div class="col-lg-2">
            <input type="text" name="stregkode"class="form-control" id="stregkode" placeholder="Stregkode" required/>
        </div>
        <div class="col-lg-2">
            <input type="text" name="skuffenr"class="form-control" id="skuffenr" placeholder="Skuffenr" required/>
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
            <tbody id="table-content">
            <tr>
                <td>Artikel 1</td>
                <td>Kategori 1</td>
                <td>Stregkode 1</td>
                <td>1</td>
                <td>20</td>
                <td>10</td>
                <td>30</td>
            </tr>
            <tr>
                <td>Artikel 2</td>
                <td>Kategori 2</td>
                <td>Stregkode 2</td>
                <td>2</td>
                <td>20</td>
                <td>10</td>
                <td>30</td>
            </tr>
            <tr>
                <td>Artikel 3</td>
                <td>Kategori 3</td>
                <td>Stregkode 3</td>
                <td>3</td>
                <td>20</td>
                <td>10</td>
                <td>30</td>
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
            $("#table-content").html(result);
        });
    });
    $("#livesearch").keyup(function (event)
    {
        var $searchtext = $(event.target).val();

        if ($searchtext.length === 0)
        {
            $.ajax({
                method: "GET",
                url   : "api/getarticles.php",
            }).done(function (result)
            {
                $("#table-content").html(result);
                console.log(result);
            });
        }
        else
        {
            $.ajax({
                method: "GET",
                url   : "api/getarticles.php?search=" + $searchtext,
            }).done(function (result)
            {
                console.log(result);
                $("#table-content").html(result);
            });
        }
    });
</script>
</body>
</html>