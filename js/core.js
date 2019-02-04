/* start page_load */
$(function ()
{
    $("[data-toggle=\"tooltip\"]").tooltip();
});
/* end page_load */

/* start get_statistics */
function get_statistics()
{
    $.ajax({
        method: "GET",
        url   : "api/statistic/read.php",

    }).done(function (response)
    {
        var statistics = "";
        $.each(response, function (k, v)
        {
            statistics += "<tr>";
            statistics += "<td>" + v.article + "</td>";
            statistics += "<td>" + v.user + "</td>";
            statistics += "<td>" + v.project + "</td>";
            statistics += "<td>" + v.date + "</td>";
            statistics += "</tr>";
        });
        $("#table-statistic").html(statistics);
    }).fail(function (response)
    {
        var statistics = "<tr>";
        statistics += "<td colspan='8'>" + response["responseJSON"].message + "</td>";
        statistics += "</tr>";

        $("#table-statistic").html(statistics);
    });
}

/* end get_statistics */

/* start statisticsearch */
$("#statisticsearch").keyup(function (event)
{
    var $search_text = $(event.target).val();

    if ($search_text.length > 0)
    {
        $.ajax({
            method: "POST",
            url   : "api/statistic/search.php",
            data  : $(event.target).serialize(),
        }).done(function (response)
        {
            var statistics = "";
            $.each(response, function (k, v)
            {
                statistics += "<tr>";
                statistics += "<td>" + v.article + "</td>";
                statistics += "<td>" + v.user + "</td>";
                statistics += "<td>" + v.project + "</td>";
                statistics += "<td>" + v.date + "</td>";
                statistics += "</tr>";
            });
            $("#table-project").html(statistics);
        }).fail(function (response)
        {
            var statistics = "<tr>";
            statistics += "<td colspan='8'>" + response["responseJSON"].message + "</td>";
            statistics += "</tr>";

            $("#table-statistic").html(statistics);
        });
    }
    else
    {
        get_statistics();
    }
});
/* end statisticsearch */

/* start get_projects */
function get_projects()
{
    $.ajax({
        method: "GET",
        url   : "api/project/read.php",

    }).done(function (response)
    {
        var projects = "";
        $.each(response, function (k, v)
        {
            projects += "<tr>";
            projects += "<td>" + v.project + "</td>";
            projects += "<td>" + v.description + "</td>";
            projects += "<td>" + v.user + "</td>";
            projects += "<td>";
            projects += "<a href='#' data-toggle='modal' data-target='#editProjectModal' data-project-id='" + v.project_id + "' data-project='" + v.project + "' data-description='" + v.description + "'>Redigér</a>";
            projects += "</td>";
            projects += "<td>";
            projects += "<a href='#' class='delete-project' data-project-id='" + v.project_id + "' data-project='" + v.project + "'>Slet</a>";
            projects += "</td>";
            projects += "</tr>";
        });
        $("#table-project").html(projects);
    }).fail(function (response)
    {
        console.log(response);
        var projects = "<tr>";
        projects += "<td colspan='8'>" + response["responseJSON"].message + "</td>";
        projects += "</tr>";

        $("#table-project").html(projects);
    });
}

/* end get_projects */

/* start editProjectModal */
$("#editProjectModal").on("show.bs.modal", function (event)
{
    var button = $(event.relatedTarget);
    var project_id = button.data("project-id");
    var project = button.data("project");
    var description = button.data("description");

    var modal = $(this);
    modal.find(".modal-body input#edit-project-id").val(project_id);
    modal.find(".modal-body input#edit-project-name").val(project);
    modal.find(".modal-body textarea").val(description);
});
/* end editProjectModal */

/* start projectsearch */
$("#projectsearch").keyup(function (event)
{
    var $search_text = $(event.target).val();

    if ($search_text.length > 0)
    {
        $.ajax({
            method: "POST",
            url   : "api/project/search.php",
            data  : $(event.target).serialize(),
        }).done(function (response)
        {
            var projects = "";
            $.each(response, function (k, v)
            {
                projects += "<tr>";
                projects += "<td>" + v.project + "</td>";
                projects += "<td>" + v.description + "</td>";
                projects += "<td>" + v.user + "</td>";
                projects += "<td>";
                projects += "<a href='#' data-toggle='modal' data-target='#editProjectModal' data-project-id='" + v.project_id + "' data-project='" + v.project + "' data-description='" + v.description + "'>Redigér</a>";
                projects += "</td>";
                projects += "<td>";
                projects += "<a href='#' class='delete-project' data-project-id='" + v.project_id + "' data-project='" + v.project + "'>Slet</a>";
                projects += "</td>";
                projects += "</tr>";
            });
            $("#table-project").html(projects);
        }).fail(function (response)
        {
            var project = "<tr>";
            project += "<td colspan='8'>" + response["responseJSON"].message + "</td>";
            project += "</tr>";

            $("#table-project").html(project);
        });
    }
    else
    {
        get_projects();
    }
});
/* end projectsearch */

/* start form-new-project */
$(".form-new-project").submit(function (e)
{
    e.preventDefault();
    var form = $(this);
    $.ajax({
        method: "POST",
        url   : "api/project/create.php",
        data  : form.serialize(),

    }).done(function (response)
    {
        notification(response["message"], "success");
        get_projects();
        $(".modal").modal("hide");
    }).fail(function (response)
    {
        notification(response["responseJSON"].message, "danger");
    });
});
/* end form-new-project */

/* start form-edit-project */
$(".form-edit-project").submit(function (e)
{
    e.preventDefault(); //this will not allow browser to move to a different URL
    var form = $(this);
    $.ajax({
        method: "POST",
        url   : "api/project/update.php",
        data  : form.serialize(),

    }).done(function (response)
    {
        notification(response["message"], "success");
        get_projects();
        $(".modal").modal("hide");
    }).fail(function (response)
    {
        notification(response["responseJSON"].message, "danger");
    });
});
/* end form-edit-project */

/* start delete-project */
$(document).on("click", ".delete-project", function (e)
{
    var project_id = $(e.target).data("project-id");
    var project = $(e.target).data("project");
    if (confirm("Er du sikker på at slette projektet: " + project + "?"))
    {
        $.ajax({
            method: "POST",
            url   : "api/project/delete.php",
            data  : "project_id=" + project_id,

        }).done(function (response)
        {
            notification(response["message"], "success");
            get_projects();
        }).fail(function (response)
        {
            notification(response["responseJSON"].message, "danger");
        });
    }
});
/* end delete-project */

/* start get_articles */
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
            // articles += "<td>" + v.barcode + "</td>";
            articles += "<td>" + v.tray_number + "</td>";
            articles += "<td>" + (v.quantity - v.on_loan) + "</td>";
            articles += "<td>" + v.on_loan + "</td>";
            articles += "<td>" + v.quantity + "</td>";
            articles += "<td>";
            articles += "<a href='#' data-toggle='modal' data-target='#edit-article-modal' data-barcode='" + v.barcode + "'>Redigér</a>";
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

/* end get_articles */

/* start delete-article */
$(document).on("click", ".delete-article", function (e)
{
    var article_id = $(e.target).data("article-id");
    var article = $(e.target).data("article-id");
    if (confirm("Er du sikker på at slette artiklen: " + article + "?"))
    {
        $.ajax({
            method: "POST",
            url   : "api/delete.php",
            data  : "article_id=" + article_id,

        }).done(function (response)
        {
            notification(response["message"], "success");
            get_articles();
        }).fail(function (response)
        {
            notification(response["responseJSON"].message, "danger");
        });
    }
});
/* end delete-article */

/* start articlesearch */
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
                articles += "<td>" + v.tray_number + "</td>";
                articles += "<td>" + (v.quantity - v.on_loan) + "</td>";
                articles += "<td>" + v.on_loan + "</td>";
                articles += "<td>" + v.quantity + "</td>";
                articles += "<td>";
                articles += "<a href='#' data-toggle='modal' data-target='#edit-article-modal' data-barcode='" + v.barcode + "'>Redigér</a>";
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
        get_articles();
    }
});
/* end articlesearch */

/* start form-edit-article */
$("#form-edit-article").submit(function (e)
{
    e.preventDefault();
    var form = $(this);
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
        notification(response["responseJSON"].message, "danger");
    });
});
/* end form-edit-article */

/* start article-modal */
$(".article-modal").on("show.bs.modal", function (event)
{
    categories_dropdown();
});
/* end article-modal */

/* start edit-article-modal */
$("#edit-article-modal").on("show.bs.modal", function (event)
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
    }).fail(function (response)
    {
        console.log(response["responseJSON"].message);
    });
});
/* end edit-article-modal */

/* start form-new-article input */
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
/* end form-new-article input */

/* start form-new-article */
$("#form-new-article").submit(function (e)
{
    e.preventDefault();
    var form = $(this);
    var location = form.find("#new-article-location").val();
    var prefix = form.find("#new-article-prefix").val();
    var tray_number = form.find("#new-article-tray_number").val();
    var barcode = location + "." + prefix + "." + add_beginning_zeros(tray_number, 4);

    var data = form.serialize() + "&barcode=" + barcode;
    $.ajax({
        method: "POST",
        url   : "api/article/create.php",
        data  : data,

    }).done(function (response)
    {
        notification(response["message"], "success");
        get_articles();
        $(".modal").modal("hide");

    }).fail(function (response)
    {
        notification(response["responseJSON"].message, "danger");
    });
});
/* end form-new-article */

/* start check-barcode */
$(".loan-article #check-barcode").click(function (e)
{
    e.preventDefault();
    var $barcode = $(".loan-article #loan-barcode");
    var $article = $(".form-loan input#loan-article");

    if ($barcode.val().length > 0)
    {
        $.ajax(
            {
                method: "POST",
                url   : "api/article/read_one.php",
                data  : $barcode.serialize(),
            }).done(function (response)
        {
            $article.val(response["article"]);
            notification("Artikel fundet: " + response["article"], "success");
        }).fail(function (response)
        {
            if ($article.val().length > 0)
            {
                $article.val("");
            }
            notification(response["responseJSON"].message, "danger");
        });
    }
    else
    {
        notification("Scan venligst en stregkode", "info");
    }
});
/* end check-barcode */

/* start form-loan */
$(".form-loan").submit(function (e)
{
    e.preventDefault();
    var $button = $(".form-loan input#check-barcode");
    var $article = $(".form-loan input#loan-article");
    if ($article.val().length > 0)
    {
        var form = $(this);
        $.ajax({
            method: "POST",
            url   : "api/user/loan.php",
            data  : form.serialize(),
        }).done(function (response)
        {
            notification(response.message, "success");
        });
    }
    else
    {
        notification("Validér venligst stregkoden", "success");
        $button.focus();
    }
});
/* end form-loan */

/* start modal */
$(".modal").on("show.bs.modal", function (event)
{
    $(".alert").alert("close");
});
/* end form-loan */

/* start categories_dropdown */
function categories_dropdown()
{
    var $category_dropdown = $("select#article-category");
    $.ajax({
        method: "GET",
        url   : "api/category/read.php",
    }).done(function (response)
    {
        var categories = "<option value=''>Vælg Kategori</option>";
        $.each(response, function (k, v)
        {
            categories += "<option value=" + v.id + ">" + v.name + "</option>";
        });
        $category_dropdown.html(categories);
    }).fail(function (response)
    {
        $category_dropdown.html("<option value=''>" + response["message"] + "</option>");
        $category_dropdown.attr("disabled", "disabled");
    });
}

/* end categories_dropdown */

/* start add_beginning_zeros */
function add_beginning_zeros(str, max)
{
    str = str.toString();
    return str.length < max ? add_beginning_zeros("0" + str, max) : str;
}
/* end add_beginning_zeros */

/* start notification */
function notification(message, status)
{
    $(".alert").alert("close");
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

/* end notification */