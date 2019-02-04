<?php
// set page headers
$page_title = "Returnering";
$site_title = "Dimselab";
require_once "../layout_header.php";
?>

<form class="form-lend row" method="post" action="api/user/loan.php">
    <div class="col-lg-10">
        <input type="text"
               name="stregkode"
               class="form-control"
               id="stregkode"
               placeholder="Artikel stregkode"
               autofocus
               autocomplete="off"></div>
    <div class="col-lg-2">
        <button id="checkreturn" class="btn btn-primary btn-block" type="submit">Tjek Stregkode</button>
    </div>
</form>

<form class="form-return row my-4">
    <div class="col-lg-2">
        <input type="text" name="artikel" class="form-control" id="artikel" value="Artikel 1" readonly/>
    </div>
    <div class="col-lg-2">
        <input type="text" name="artikel" class="form-control" id="artikel" value="Kategori 1" readonly/>
    </div>
    <div class="col-lg-2">
        <input type="text" name="artikel" class="form-control" id="artikel" value="Stregkode 1" readonly/>
    </div>
    <div class="col-lg-2">
        <input type="text" name="artikel" class="form-control" id="artikel" value="Skuffenr 1" readonly/>
    </div>
    <div class="col-lg-2">
        <input type="number" min="0" max="1000000" name="antal" class="form-control" id="antal" placeholder="Antal" required/>
    </div>
    <div class="col-lg-2">
        <button id="addreturn" class="btn btn-success btn-block" type="submit">Tilføj til returnering</button>
    </div>
</form>

<div class="content-overview">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">Artikel</th>
            <th scope="col">Kategori</th>
            <th scope="col">Skuffenr</th>
            <th scope="col">Antal</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="7">Ingen artikler til returnering</td>
        </tr>
        </tbody>
    </table>
    <div class="col-lg-12">
        <button id="returnarticle" class="btn btn-success btn-block" type="submit">Returnér artikler</button>
    </div>
</div>

<?php
// footer
include_once "layout_footer.php";
?>
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
    $(".form-return").submit(function (e)
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