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
    <title>Projekter - Dimselab</title>
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
                <a class="nav-link" href="./udlån">Udlån</a>
            </li>
            <!--<li class="nav-item nav-dropdown">
                <a class="nav-link" href="./udlånreturnering">Udlån/Returnering</a>
                <div class="dropdown-submenu" aria-labelledby="dropdownLending">
                    <a class="submenu-item" href="./udlån">Udlån</a>
                    <a class="submenu-item" href="./returnering">Returnering</a>
                </div>
            </li>-->
            <li class="nav-item active nav-dropdown">
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
        <input type="search" name="search" class="form-control" id="projectsearch" placeholder="Søg projekt" autofocus autocomplete="off">
    </div>

    <button class="btn btn-success my-4 float-right" data-toggle='modal' data-target='#newProjectModal'>Nyt projekt</button>

    <div class="content-overview">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Projekt</th>
                <th scope="col">Beskrivelse</th>
                <th scope="col">Artikel</th>
                <th scope="col">Bruger</th>
                <th>Bruger</th>
            </tr>
            </thead>
            <tbody id="table-project">
            <tr>
                <td colspan="7">Ingen projekter hentet</td>
            </tr>
        </table>
    </div>

</div>

<div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-edit-project" method="post" action="api/editproject.php">
                    <div class="form-group">
                        <label for="project-name" class="col-form-label">Projekt navn:</label>
                        <input type="text" class="form-control" id="project-name">
                    </div>
                    <div class="form-group">
                        <label for="project-description" class="col-form-label">Projekt beskrivelse:</label>
                        <textarea class="form-control" id="project-description"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger">Slet projekt</button>
                <button type="button" class="btn btn-primary">Gem ændringer</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="newProjectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-new-project" method="post" action="api/createproject.php">
                    <div class="form-group">
                        <label for="project-name" class="col-form-label">Projekt navn:</label>
                        <input type="text" class="form-control" id="project-name">
                    </div>
                    <div class="form-group">
                        <label for="project-description" class="col-form-label">Projekt beskrivelse:</label>
                        <textarea class="form-control" id="project-description"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary">Luk</button>
                <button type="button" class="btn btn-primary">Opret projekt</button>
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
            url   : "api/getprojecthistory.php",
        }).done(function (result)
        {
            $("#table-project").html(result);
        });
    });
    $("#editProjectModal").on("show.bs.modal", function (event)
    {
        var button = $(event.relatedTarget);
        var project = button.data("project");
        var description = button.data("description");

        var modal = $(this);
        modal.find(".modal-body input").val(project);
        modal.find(".modal-body textarea").val(description);
    });
    $("#projectsearch").keyup(function (event)
    {
        var $searchtext = $(event.target).val();

        if ($searchtext.length === 0)
        {
            $.ajax({
                method: "GET",
                url   : "api/getprojecthistory.php",
            }).done(function (result)
            {
                $("#table-project").html(result);
            });
        }
        else
        {
            $.ajax({
                method: "GET",
                url   : "api/getprojects.php?search=" + $searchtext,
            }).done(function (result)
            {
                $("#table-project").html(result);
            });
        }
    });
</script>
</body>
</html>