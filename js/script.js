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
            $("#table-article").html(response);
        }).fail(function (response)
        {
            $("#table-article").html(response);
        });
        $.ajax({
            method: "GET",
            url   : "api/category/read.php",
        }).done(function (response)
        {
            $("select#new-article-category").html(response);
        }).fail(function (response)
        {
            $("select#new-article-category").html(response);
        });
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
    $("#articlesearch").keyup(function (event)
    {
        var $searchtext = $(event.target).val();

        if ($searchtext.length > 0)
        {
            $.ajax({
                method: "POST",
                url   : "api/article/search.php",
                data : $(event.target).serialize()
            }).done(function (response)
            {
                $("#table-article").html(response);
            }).fail(function (response)
            {
                alert("error");
                $("#table-article").html(response);
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

});