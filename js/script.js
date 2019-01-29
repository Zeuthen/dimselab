$(function ()
{
    $("[data-toggle=\"tooltip\"]").tooltip();

    var $category_dropdown = $("select#article-category");
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
        $category_dropdown.html(categories);
    }).fail(function (response)
    {
        $category_dropdown.html("<option value=''>" + response["message"] + "</option>");
        $category_dropdown.attr("disabled", "disabled");
    });
    get_articles();

    function get_articles()
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
                articles += "<a href='#' data-toggle='modal' data-target='#editArticleModal' data-barcode='" + v.barcode + "'>Redigér</a>";
                articles += "</td>";
                articles += "<td>";
                articles += "<a href='#' class='delete-article' data-article-id='" + v.article_id + "' data-article='" + v.article + "'>Slet</a>";
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

    $(document).on("click", ".delete-article", function (e)
    {
        var article = $(e.target).data("article");
        var article_id = $(e.target).data("article-id");
        if (confirm("Er du sikker på at slette artiklen: " + article + "?"))
        {
            $.ajax({
                method: "POST",
                url   : "api/delete.php",
                data  : "article_id=" + article_id,
            }).done(function (response)
            {
                alert(response["message"]);
                location.reload();
            }).fail(function (response)
            {
                alert(response["message"]);
            });
        }
    });
    $("#articlesearch").keyup(function (event)
    {
        var $searchtext = $(event.target).val();

        if ($searchtext.length > 0)
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
                    articles += "<a href='#' data-toggle='modal' data-target='#editArticleModal' data-barcode='" + v.barcode + "'>Redigér</a>";
                    articles += "</td>";
                    articles += "<td>";
                    articles += "<a href='#' class='delete-article' data-article-id='" + v.article_id + "' data-article='" + v.article + "'>Slet</a>";
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
                    articles += "<a href='#' data-toggle='modal' data-target='#editArticleModal' data-barcode='" + v.barcode + "'>Redigér</a>";
                    articles += "</td>";
                    articles += "<td>";
                    articles += "<a href='#' class='delete-article' data-article-id='" + v.article_id + "' data-article='" + v.article + "'>Slet</a>";
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
    });

    $("#form-edit-article").submit(function (e)
    {
        var form = $(this);
        //var url = form.attr("action");
        $.ajax({
            method: "POST",
            url   : "api/article/update.php",
            data  : form.serialize(),
        }).done(function (response)
        {
            notification(response["message"], "success");
            get_articles();
            $(".modal").modal("hide");
        }).fail(function (response)
        {
            notification(response["message"], "danger");
        });

        e.preventDefault();
    });

    $("#editArticleModal").on("show.bs.modal", function (event)
    {
        var button = $(event.relatedTarget);
        var $modal = $(this);
        $.ajax({
            method: "POST",
            url   : "api/article/read_one.php",
            data  : "barcode=" + button.data("barcode"),
        }).done(function (response)
        {
            $modal.find(".modal-body input#edit-article-id").val(response.article_id);
            $modal.find(".modal-body input#edit-article").val(response.article);
            $modal.find(".modal-body select#article-category").val(response.category_id);
            $modal.find(".modal-body input#edit-article-barcode").val(response.barcode);
            $modal.find(".modal-body input#edit-article-tray_number").val(response.tray_number);
            $modal.find(".modal-body input#edit-article-quantity").val(response.quantity);
        });
    });

    $("#form-new-article input").keyup(function ()
    {
        var location = $("#form-new-article input#new-article-location").val();
        var article = $("#form-new-article input#new-article-prefix").val();
        var tray_number = $("#form-new-article input#new-article-tray_number").val();
        if (location.length === 4 && article.length === 4 && tray_number.length === 4)
        {
            $("input#new-article-barcode").val(location + "." + article + "." + tray_number);
        }
    });
    $("#form-new-article").submit(function (e)
    {
        var form = $(this);
        //var url = form.attr("action");
        $.ajax({
            method: "POST",
            url   : "api/article/create.php",
            data  : form.serialize(),
        }).done(function (response)
        {
            notification(response["message"], "success");
            get_articles();
            $(".modal").modal("hide");

        }).fail(function (response)
        {
            notification(response["message"], "danger");
        });

        e.preventDefault();
    });

    //notification("message", "danger");
    function notification(message, status)
    {
        // status : info, danger, success
        var notification = "<div class=\"alert alert-" + status + " alert-dismissible fade show container notification\" role=\"alert\">";
        notification += message;
        notification += "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">";
        notification += "<span aria-hidden=\"true\">&times;</span>";
        notification += "</button>";
        notification += "</div>";
        $("body").append(notification);
        setTimeout(function () { $(".alert").alert("close"); }, 10000);
    }


    $.ajax({
        method: "GET",
        url   : "api/project/read.php",
    }).done(function (response)
    {
        $("select#project").html(response);
    }).fail(function (response)
    {
        alert(response);
    });

    $(".form-lend #checkbarcode").click(function (e)
    {
        if ($(".form-lend #barcode").val().length > 0)
        {
            $.ajax(
                {
                    method  : "GET",
                    url     : url,
                    data    : "barcode=" + $(".form-lend #barcode").val(),
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
});