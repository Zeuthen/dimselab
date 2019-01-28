$(function ()
{
    $("[data-toggle=\"tooltip\"]").tooltip();

    $(document).ready(function ()
    {
        $.ajax({
            method: "GET",
            url   : "api/article/read.php",
        }).done(function (response)
        {
            var articles = "";
            $.each(response, function (k, v)
            {
                articles += "<tr>";
                articles += "<td>" + v.article + "</td>";
                articles += "<td>" + v.category + "</td>";
                articles += "<td>" + v.barcode + "</td>";
                articles += "<td>" + v.tray_number + "</td>";
                articles += "<td>" + (v.quantity - v.on_loan) + "</td>";
                articles += "<td>" + v.on_loan + "</td>";
                articles += "<td>" + v.quantity + "</td>";
                articles += "<td>";
                articles += "<a href='#' data-toggle='modal' data-target='#editArticleModal' data-article-id='" + v.article_id + "' data-article='" + v.article + "' data-category='" + v.category_id + "' data-barcode='" + v.barcode + "' data-tray_number='" + v.tray_number + "' data-quantity='" + v.quantity + "'>Redigér</a>";
                articles += "</td>";
                articles += "<td>";
                articles += "<a href='#' onclick='return confirm_click(" + v.article_id + "," + v.article + ");'" + " data-article-id='" + v.article_id + "' data-article='" + v.article + "'>Slet</a>";
                articles += "</td>";
                articles += "</tr>";
            });

            $("#table-article").html(articles);
        }).fail(function (response)
        {
            var articles = "<tr>";
            articles += "<td colspan='8'>" + response["responseJSON"].message + "</td>";
            articles += "</tr>";

            $("#table-article").html(articles);
        });
        $("#articlesearch").keyup(function (event)
        {
            var $searchtext = $(event.target).val();

            if ($searchtext !== "")
            {
                $.ajax({
                    method: "POST",
                    url   : "api/article/search.php",
                    data  : $(event.target).serialize(),
                }).done(function (response)
                {
                    var articles = "";
                    $.each(response, function (k, v)
                    {
                        articles += "<tr>";
                        articles += "<td>" + v.article + "</td>";
                        articles += "<td>" + v.category + "</td>";
                        articles += "<td>" + v.barcode + "</td>";
                        articles += "<td>" + v.tray_number + "</td>";
                        articles += "<td>" + (v.quantity - v.on_loan) + "</td>";
                        articles += "<td>" + v.on_loan + "</td>";
                        articles += "<td>" + v.quantity + "</td>";
                        articles += "<td>";
                        articles += "<a href='#' data-toggle='modal' data-target='#editArticleModal' data-article-id='" + v.article_id + "' data-article='" + v.article + "' data-category='" + v.category_id + "' data-barcode='" + v.barcode + "' data-tray_number='" + v.tray_number + "' data-quantity='" + v.quantity + "'>Redigér</a>";
                        articles += "</td>";
                        articles += "<td>";
                        articles += "<a href='#' onclick='return confirm_click(" + v.article_id + "," + v.article + ");'" + " data-article-id='" + v.article_id + "' data-article='" + v.article + "'>Slet</a>";
                        articles += "</td>";
                        articles += "</tr>";
                    });

                    $("#table-article").html(articles);
                }).fail(function (response)
                {
                    var articles = "<tr>";
                    articles += "<td colspan='8'>" + response["responseJSON"].message + "</td>";
                    articles += "</tr>";

                    $("#table-article").html(articles);
                });
            }
            else
            {
                $.ajax({
                    method: "GET",
                    url   : "api/article/read.php",
                }).done(function (response)
                {
                    $("#table-article").html(response);
                });
            }
        });

        $.ajax({
            method: "GET",
            url   : "api/category/read.php",
        }).done(function (response)
        {
            var categories = "<option value=''>Vælg Kategori</option>";
            //$("select#new-article-category").append("<option value=''>Vælg Kategori</option>");
            $.each(response, function (k, v)
            {
                //$("select#new-article-category").append("<option value=" + v.id + ">" + v.name + "</option>");
                categories += "<option value=" + v.id + ">" + v.name + "</option>";
            });
            $("select#new-article-category").html(categories);
        }).fail(function (response)
        {
            $("select#new-article-category").html("<option value=''>" + response["message"] + "</option>");
            $("select#new-article-category").attr("disabled", "disabled");
        });
    });
    $("button[type=\"submit\"]").click(function (e)
    {
        $(this).parent("form").submit();
    });
    $(".form-new-article").submit(function (e)
    {
        var form = $(this);
        //var url = form.attr("action");
        $.ajax({
            method: "POST",
            url   : "api/article/update.php",
            data  : form.serialize(),
        }).done(function (response)
        {
            alert("Artikel tilføjet");
            location.reload();
        });

        e.preventDefault();
    });
    $(".form-edit-article").submit(function (e)
    {
        var form = $(this);
        //var url = form.attr("action");
        $.ajax({
            method: "POST",
            url   : "api/article/update.php",
            data  : form.serialize(),
        }).done(function (response)
        {
            alert("Artikel ændret");
            location.reload();
        });

        e.preventDefault();
    });
    $("#form-new-article input").keyup(function ()
    {
        var artikel = $("#form-new-article input#artikelprefix").val();
        var location = $("#form-new-article input#lokation").val();
        var skuffenummer = $("#form-new-article input#skuffenummer").val();
        if (artikel.length === 4 && location.length === 4 && skuffenummer.length === 4)
        {
            $("input#stregkode").val(location + "." + artikel + "." + skuffenummer);
        }
    });
    $("#editArticleModal").on("show.bs.modal", function (event)
    {
        var button = $(event.relatedTarget);
        var articleid = button.data("article-id");
        var article = button.data("article");
        var category = button.data("category");
        var stregkode = button.data("stregkode");
        var skuffenummer = button.data("skuffenummer");
        var antal = button.data("antal");

        var modal = $(this);
        modal.find(".modal-body input#articleid").val(articleid);
        modal.find(".modal-body input#artikel").val(article);
        modal.find(".modal-body select#kategori").val(category);
        modal.find(".modal-body input#stregkode").val(stregkode);
        modal.find(".modal-body input#skuffenummer").val(skuffenummer);
        modal.find(".modal-body input#antal").val(antal);
    });

    function confirm_delete_article(artikelid, artikel)
    {
        var check = confirm("Er du sikker på du vil slette artiklen: " + artikel);
        if (check)
        {
            $.ajax({
                method: "POST",
                url   : "api/delete.php",
                data  : "articleid=" + artikelid,
            }).
                done(function (response)
                {
                    alert("Artikel slettet");
                    location.reload();
                });

        }
    }

})
;