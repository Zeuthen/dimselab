var $project_dropdown = $("select#loan-project");
$.ajax({
    method: "GET",
    url   : "api/project/read.php",
}).done(function (response)
{
    var projects = "<option value=''>Vælg Projekt</option>";
    //$("select#new-article-category.js").append("<option value=''>Vælg Kategori</option>");
    $.each(response, function (k, v)
    {
        //$("select#new-article-category.js").append("<option value=" + v.id + ">" + v.name + "</option>");
        projects += "<option value=" + v.project_id + ">" + v.project + ", " + v.description + "</option>";
    });
    $project_dropdown.html(projects);
}).fail(function (response)
{
    $project_dropdown.html("<option value=''>" + response["responseJSON"].message + "</option>");
    $project_dropdown.attr("disabled", "disabled");
    notification(response["responseJSON"].message, "danger");
});
