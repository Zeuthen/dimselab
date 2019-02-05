$(".form-login").submit(function (e)
{
    e.preventDefault();
    var form = $(this);
    $.ajax({
        method: "POST",
        url   : "api/user/login.php",
        data  : form.serialize(),
    }).done(function (response)
    {
        window.location = "oversigt";
    }).fail(function (response)
    {
        notification(response["responseJSON"].message, "danger");
    });
});