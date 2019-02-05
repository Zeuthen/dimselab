<?php
// set page headers
$page_title = "Projekter";
$site_title = "Dimselab";
require_once "layout/layout_header.php";
?>

<div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
    </div>
    <input type="search" name="search" class="form-control" id="projectsearch" placeholder="Søg projekt" autofocus autocomplete="off">
</div>

<button class="btn btn-success my-4 float-right" data-toggle='modal' data-target='#newProjectModal'>Nyt projekt</button>

<div class="content-overview">
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>Projekt</th>
            <th>Beskrivelse</th>
            <th>Bruger</th>
	        <?php if($_SESSION["PERMISSION"]>10) echo "<th colspan=\"2\">Handling</th>"?>
        </tr>
        </thead>
        <tbody id="table-project"></tbody>
    </table>
</div>

<div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Redigér projekt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-project" class="form-edit-project" method="post" action="api/project/update.php">
                    <input type="hidden" id="edit-project-id" name="project_id">
                    <div class="form-group">
                        <label for="project-name" class="col-form-label">Projekt navn:</label>
                        <input type="text" class="form-control" id="edit-project-name" name="project" placeholder="Projekt navn" required>
                    </div>
                    <div class="form-group">
                        <label for="project-description" class="col-form-label">Projekt beskrivelse:</label>
                        <textarea class="form-control"
                                  id="edit-project-description"
                                  name="description"
                                  placeholder="Projekt beskrivelse"
                                  required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="edit-project" form="form-edit-project">Gem ændringer</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="newProjectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Opret nyt projekt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-new-project" class="form-new-project" method="POST" action="api/project/create.php">
                    <div class="form-group">
                        <label for="project-name" class="col-form-label">Projekt navn:</label>
                        <input type="text" class="form-control" id="new-project-name" name="project" placeholder="Projekt navn" required>
                    </div>
                    <div class="form-group">
                        <label for="project-description" class="col-form-label">Projekt beskrivelse:</label>
                        <textarea class="form-control"
                                  id="new-project-description"
                                  name="description"
                                  placeholder="Projekt beskrivelse"
                                  required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="new-project" form="form-new-project">Opret projekt</button>
            </div>
        </div>
    </div>
</div>
<?php
// footer
include_once "layout/layout_footer.php";
?>
<script type="text/javascript" src="js/projects.js"></script>
<!--<script type="text/javascript" src="js/projects.min.js"></script>-->
</body>
</html>