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

<div class="content-statistic">
    <table class="table table-hover table-bordered mt-4">
        <thead>
        <tr>
            <th scope="col">Artikel</th>
            <th scope="col">Bruger</th>
            <th scope="col">Projekt</th>
            <th scope="col">Oprettelsesdato</th>
        </tr>
        </thead>
        <tbody id="table-statistic">
        </tbody>
    </table>
</div>

<?php
// footer
include_once "layout_footer.php";
?>
<script type="text/javascript" src="js/statistics.min.js"></script>
<!--<script type="text/javascript" src="js/statistics.js"></script>-->
</body>
</html>