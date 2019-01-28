<?php
// set page headers
$page_title = "Udlån";
$site_title = "Dimselab";
require_once "layout_header.php";
?>

<div class="container content">

    <div class="col-lg-6 offset-lg-3">
        <form class="form-lend my-4" method="POST" action="api/lend.php">
            <div class="form-group">
                <label for="artikel">Artikel</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="artikel" name="artikel" placeholder="Artikel" readonly required="" title="artikel">
                </div>
            </div>
            <div class="form-group">
                <label for="stregkode">Scan Stregkode</label>
                <div class="input-group">
                    <div class="col-lg-8">
                        <div class="row">
                            <input type="text"
                                   class="form-control"
                                   id="stregkode"
                                   name="stregkode"
                                   placeholder="Stregkode"
                                   required=""
                                   title="artikel">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <button id="checkstregkode" class="btn btn-primary btn-block">Tjek Stregkode</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="projekt">Projekt</label>
                <div class="input-group">
                    <select class="custom-select" name="projekt" id="projekt" required>
                        <option value="">Projekt</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <button id="addlend" class="btn btn-success btn-block" type="submit">Lån</button>
            </div>
        </form>
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
            url   : "api/getprojects.php",
        }).done(function (result)
        {
            $("select#projekt").html(result);
        });
    });

    $(".form-lend #checkstregkode").click(function (e)
    {
        if ($(".form-lend #stregkode").val().length > 0)
        {
            var url = "api/getarticle.php?stregkode=" + $(".form-lend #stregkode").val();

            $.ajax(
                {
                    method  : "GET",
                    url     : url,
                    dataType: "json",
                }).done(function (response)
                {
                    if (response.length > 0)
                    {
                        var result = response[0];
                        alert("Vi fandt " + result["Artikel"]);
                        $(".form-lend #artikel").val(result["Artikel"]);
                    }
                    else
                    {
                        alert("Ingen artikel");
                    }
                }
            );
        }
        else
        {
            alert("Scan en stregkode");
        }
        e.preventDefault();
    });
    $(".form-lend").submit(function (e)
    {
        var form = $(this);
        var url = form.attr("action");
        $.ajax({
            method: "POST",
            url   : url,
            data  : form.serialize(),
        }).done(function (response)
        {
            alert("udlån fuldført");
            location.reload();
        });

        e.preventDefault();
    });
</script>