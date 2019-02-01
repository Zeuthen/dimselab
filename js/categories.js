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