<?php
session_start();
if ( ! isset( $_SESSION["user"] ) )
{
	header( "location: logind" );
}
// set page headers
$page_title = "Artikeloversigt";
$site_title = "Dimselab";
include_once "layout_header.php";
?>

    <div class="container content">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="search" name="search" class="form-control" id="articlesearch" placeholder="Søg artikel" autofocus autocomplete="off">
        </div>

        <button class="btn btn-success my-4 float-right" data-toggle='modal' data-target='#newArticleModal'>Ny artikel</button>

        <div class="content-article">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Artikel</th>
                    <th>Kategori</th>
                    <th>Stregkode</th>
                    <th>Skuffenr</th>
                    <th>Lager</th>
                    <th>Udlånt</th>
                    <th>I alt</th>
                    <th colspan="2">Handling</th>
                </tr>
                </thead>
                <tbody id="table-article">
                </tbody>
            </table>
        </div>

    </div>

    <div class="modal fade" id="editArticleModal" tabindex="-1" role="dialog" aria-labelledby="projectModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Redigér artikel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit-article" class="form-article" name="editarticle" method="post" action="api/article/update.php">
                        <input type="hidden" id="article-id" name="articleid">
                        <div class="form-group">
                            <label for="edit-article">Artikel</label>
                            <div class="input-group">
                                <input type="text"
                                       class="form-control"
                                       id="edit-article"
                                       name="article"
                                       placeholder="Artikel"
                                       title="Artikel"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit-article-category">Kategori</label>
                            <div class="input-group">
                                <select class="custom-select" id="edit-article-category" name="category" title="Kategori" required>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit-article-barcode">Stregkode</label>
                            <div class="input-group">
                                <input type="text"
                                       class="form-control"
                                       id="edit-article-barcode"
                                       name="barcode"
                                       placeholder="Stregkode"
                                       title="Stregkode"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit-article-traynumber">Skuffenummer</label>
                            <div class="input-group">
                                <input type="text"
                                       class="form-control"
                                       id="edit-article-traynumber"
                                       name="traynumber"
                                       placeholder="Skuffenummer"
                                       title="Skuffenummer"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit-article-quantity">Antal</label>
                            <div class="input-group">
                                <input type="number"
                                       class="form-control"
                                       id="edit-article-quantity"
                                       name="quantity"
                                       min="0"
                                       max="1000000"
                                       placeholder="Antal"
                                       title="Skuffenummer"
                                       required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="edit-article" form="form-edit-article">Gem ændringer</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="newArticleModal" tabindex="-1" role="dialog" aria-labelledby="projectModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Opret ny artikel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-new-article" class="form-article" name="newarticle" method="POST" action="api/article/create.php">
                        <div class="form-group">
                            <label for="new-article">Artikel</label>
                            <div class="input-group">
                                <div class="col">
                                    <input type="text"
                                           class="form-control"
                                           id="new-article"
                                           name="article"
                                           placeholder="Artikel"
                                           title="Artikel"
                                           required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" id="new-article-prefix" name="articleprefix" placeholder="Artikel Præfiks"
                                           title="Artikel Præfiks" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new-article-location">Lokation</label>
                            <div class="input-group">
                                <input type="text"
                                       class="form-control"
                                       id="new-article-location"
                                       name="articlelocation"
                                       placeholder="Lokation"
                                       title="Lokation ex ROD5"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new-article-category">Kategori</label>
                            <div class="input-group">
                                <select class="custom-select" id="new-article-category" name="category" title="Kategori" required>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new-article-barcode">Stregkode</label>
                            <div class="input-group">
                                <input type="text"
                                       class="form-control"
                                       id="new-article-barcode"
                                       name="barcode"
                                       placeholder="Stregkode"
                                       title="Kategori"
                                       readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new-article-tray_number">Skuffenummer</label>
                            <div class="input-group">
                                <input type="number"
                                       class="form-control"
                                       id="new-article-tray_number"
                                       name="tray_number"
                                       min="0"
                                       max="10000"
                                       placeholder="Skuffenummer"
                                       title="Skuffenummer"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new-article-quantity">Antal</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="new-article-quantity" name="quantity" min="0" max="1000000"
                                       placeholder="Antal" title="Antal" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="new-article" form="form-new-article">Opret artikel</button>
                </div>
            </div>
        </div>
    </div>

<?php
// footer
include_once "layout_footer.php";
?>