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
    <title>Oversigt - Dimselab</title>
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

    <button class="btn btn-success my-4 float-right" data-toggle='modal' data-target='#newArticleModal'>Ny artikel</button>

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
                <th scope="col"></th>
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

<div class="modal fade" id="editArticleModal" tabindex="-1" role="dialog" aria-labelledby="projectModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-new-article" method="post" action="api/createarticle.php">
                    <div class="mb-3">
                        <label for="artikel">Artikel</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="artikel" name="artikel" placeholder="Artikel" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="kategori">Kategori</label>
                        <div class="input-group">
                            <select class="custom-select" id="kategori" name="kategori" required>
                                <option value="">Kategori</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="stregkode">Stregkode</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="stregkode" name="stregkode" placeholder="Stregkode" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="skuffenummer">Skuffenummer</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="skuffenummer" name="skuffenummer" placeholder="Skuffenummer" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="skuffenummer">Antal</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="antal" name="antal" min="0" max="1000000" placeholder="Antal" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger">Slet artikel</button>
                <button type="button" class="btn btn-primary">Gem ændringer</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="newArticleModal" tabindex="-1" role="dialog" aria-labelledby="projectModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-new-article" method="post" action="api/createarticle.php">
                    <div class="mb-3">
                        <label for="artikel">Artikel</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="artikel" name="artikel" placeholder="Artikel" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="kategori">Kategori</label>
                        <div class="input-group">
                            <select class="custom-select" id="kategori" name="kategori" required>
                                <option value="ingen">Kategori</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="stregkode">Stregkode</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="stregkode" name="stregkode" placeholder="Stregkode" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="skuffenummer">Skuffenummer</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="skuffenummer" name="skuffenummer" placeholder="Skuffenummer" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="skuffenummer">Antal</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="antal" name="antal" min="0" max="1000000" placeholder="Antal" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Opret artikel</button>
            </div>
        </div>
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
            $("select#kategori").html(result);
        });
    });

    $("#editArticleModal").on("show.bs.modal", function (event)
    {
        var button = $(event.relatedTarget);
        var article = button.data("article");
        var category = button.data("category");
        var stregkode = button.data("stregkode");
        var skuffenummer = button.data("skuffenummer");
        var antal = button.data("antal");

        var modal = $(this);
        modal.find(".modal-body input#artikel").val(article);
        modal.find(".modal-body select#kategori").val(category);
        modal.find(".modal-body input#stregkode").val(stregkode);
        modal.find(".modal-body input#skuffenummer").val(skuffenummer);
        modal.find(".modal-body input#antal").val(antal);
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
    $(".form-new-article").submit(function (e)
    {
        var form = $(this);
        var url = form.attr("action");

        $.ajax({
            method: "POST",
            url   : url,
            data  : form.serialize(),
        }).done(function (result)
        {
            alert("Artikel tilføjet");
        });

        e.preventDefault();
    });
</script>
</body>
</html>