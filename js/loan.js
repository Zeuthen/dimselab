var $project_dropdown = $("select#loan-project");
$.ajax({
    method: "GET",
    url   : "api/project/read.php",
}).done(function (response)
{
    var projects = "<option value=''>Vælg Projekt</option>";
    $.each(response, function (k, v)
    {
        projects += "<option value=" + v.project_id + ">" + v.project + ", " + v.description + "</option>";
    });
    $project_dropdown.html(projects);
}).fail(function (response)
{
    $project_dropdown.html("<option value=''>" + response["responseJSON"].message + "</option>");
    $project_dropdown.attr("disabled", "disabled");
    notification(response["responseJSON"].message, "danger");
});