<?php
// set page headers
$page_title = "Udlån";
$site_title = "Dimselab";
require_once "layout_header.php";
?>

    <form class="form-loan mx-auto py-3 w-50" method="POST" action="api/loan.php">
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
                       title="Artikel">
            </div>
        </div>
        <div class="form-group">
            <label for="loan-barcode">Scan barcode</label>
            <div class="input-group">
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
                    <button id="checkbarcode" class="btn btn-primary btn-block" data-toggle="tooltip" title="Validér Stregkode">Validér Stregkode
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="loan-project">Projekt</label>
            <div class="input-group">
                <select class="custom-select" name="project" id="loan-project" data-toggle="tooltip" title="Projekt" required>
                    <option value="">Projekt</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <button id="addloan" class="btn btn-success btn-block" type="submit">Lån</button>
        </div>
    </form>

<?php
// footer
include_once "layout_footer.php";
?>