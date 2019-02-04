<?php
session_start();
if ( isset( $_SESSION["USER"] ) )
{
	header( "location: oversigt" );
}
// set page headers
$page_title = "Login";
$site_title = "Dimselab";
require_once "layout_header.php";
?>

<h1 class="text-center mb-5">Velkommen til <?php echo $site_title?></h1>

<form class="form-login text-center mx-auto mt-5 px-3 py-3 w-25" method="post">
    <div class="mb-3">
        <label for="email" class="sr-only">E-mail adresse</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="email"
                   id="login-email"
                   name="email"
                   class="form-control"
                   placeholder="dit-navn@edu.easj.dk"
                   required
                   autofocus
                   autocomplete="off">
        </div>
    </div>
    <div class="mb-3">
        <label for="login-password" class="sr-only">Adgangskode</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password" id="login-password" name="password" class="form-control" placeholder="***********" required>
        </div>
    </div>
    <!--<div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="remember-me">
        <label class="custom-control-label" for="remember-me">Husk mig</label>
    </div>-->
    <hr class="mb-4">
    <button class="btn btn-primary btn-lg btn-block" type="submit">Log ind</button>
</form>

<?php
// footer
include_once "layout_footer.php";
?>
<!--<script type="text/javascript" src="js/login.js"></script>-->
<script type="text/javascript" src="js/login.min.js"></script>
</body>
</html>