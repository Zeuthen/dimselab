<?php
session_start();
if ( ! isset( $_SESSION["USER"] ) )
{
	header( "location: logind" );
}
if ( ! isset( $_SESSION['CREATED'] ) )
{
	$_SESSION['CREATED'] = time();
}
else if ( time() - $_SESSION['CREATED'] > 1800 )
{
	// session started more than 30 minutes ago
	session_regenerate_id( true );    // change session ID for the current session and invalidate old session ID
	$_SESSION['CREATED'] = time();  // update creation time
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?> - <?php echo $site_title; ?></title>
    <link rel="shortcut icon" type="image/png" href="assets/favicon.ico"/>
    <link rel="stylesheet" href="css/all.min.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="./"><?php echo $site_title; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDimselab" aria-controls="navbarDimselab"
            aria-expanded="false" aria-label="Vis menu">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarDimselab">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="./oversigt">Oversigt</a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link" href="./udlån">Udlån</a>
            </li>
            <!--<li class="nav-item nav-dropdown">
				<a class="nav-link" href="./udlånreturnering">Udlån/Returnering</a>
				<div class="dropdown-submenu" aria-labelledby="dropdownLending">
					<a class="submenu-item" href="./udlån">Udlån</a>
					<a class="submenu-item" href="./returnering">Returnering</a>
				</div>
			</li>-->
            <li class="nav-item nav-dropdown">
                <a class="nav-link" href="./historik">Historik</a>
                <div class="dropdown-submenu" aria-labelledby="dropdownHistory">
                    <a class="submenu-item" href="./projekter">Projekter</a>
                    <a class="submenu-item" href="./statistik">Udlånsstatistik</a>
                </div>
            </li>
        </ul>
        <ul class="form-inline ml-auto navbar-nav">
            <li class="nav-item"><span class="navbar-text">Velkommen <strong><?php echo $_SESSION["user"] ?></strong></span></li>
            <li><a class="nav-link" href="./logud">Log ud</a></li>
        </ul>
    </div>
</nav>

<!-- container -->
<div class="container content">
