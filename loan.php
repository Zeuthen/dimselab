<?php
// set page headers
$page_title = "Udlån";
$site_title = "Dimselab";
require_once "layout/layout_header.php";
?>
<div class="row mx-auto py-3 w-50">
    <label for="loan-barcode">Scan stregkode</label>
    <div class="input-group loan-article">
        <div class="col-lg-8">
            <div class="row">
                <input type="text"
                       class="form-control"
                       id="loan-barcode"
                       name="barcode"
                       placeholder="Stregkode" data-toggle="tooltip"
                       required=""
                       title="Stregkode">
            </div>
        </div>
        <div class="col-lg-4 pr-0">
            <input type="button"
                   id="check-barcode"
                   class="btn btn-primary btn-block"
                   data-toggle="tooltip"
                   title="Validér Stregkode"
                   value="Validér Stregkode"/>
        </div>
    </div>
    <form class="form-loan py-3 w-100" method="POST" action="api/user/loan.php">
        <div class="form-group">
            <label for="loan-article">Artikel</label>
            <div class="input-group">
                <input type="text"
                       class="form-control"
                       id="loan-article"
                       name="article"
                       placeholder="Artikel"
                       data-toggle="tooltip"
                       readonly
                       required
                       title="Artikel" tabindex="-1">
            </div>
        </div>
        <div class="form-group">
            <label for="loan-project">Projekt</label>
            <div class="input-group">
                <select class="custom-select" name="project" id="loan-project" data-toggle="tooltip" title="Projekt" required>
                </select>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-success btn-block" type="submit">Lån</button>
        </div>
    </form>
</div>

<?php
// footer
include_once "layout/layout_footer.php";
?>
<!--<script type="text/javascript" src="js/loan.js"></script>-->
<script type="text/javascript" src="js/loan.min.js"></script>
</body>
</html>