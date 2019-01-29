<?php
// set page headers
$page_title = "Statistik";
$site_title = "Dimselab";
require_once "layout_header.php";
?>

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

<?php
// footer
include_once "layout_footer.php";
?>
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