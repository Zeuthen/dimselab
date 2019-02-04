<?php
session_start();
if ( isset( $_SESSION["USER"] ) )
{
	header( "location: oversigt" );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Dimselab</title>
    <link rel="shortcut icon" type="image/png" href="assets/favicon.ico"/>
    <link rel="stylesheet" href="css/all.min.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <!--    <link rel="stylesheet" href="css/style.css"/>-->
    <link rel="stylesheet" href="css/style.min.css"/>
</head>
<body>

<!-- container -->
<div class="container pt-5 mt-4 text-center">
    <h1>Velkommen til Dimselab</h1>

    <form class="form-login mx-auto mt-5 px-3 py-3 w-50" method="post">
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
                       placeholder="brugernavn@zealand.dk"
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
    <!--<script type="text/javascript" src="js/core.js"></script>-->
    <script type="text/javascript" src="js/login.js"></script>
</body>
</html>