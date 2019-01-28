<?php
//session_start();
session_unset();     // unset $_SESSION variable for the run-time
session_destroy();   // destroy session data in storage
//if ( ! isset( $_SESSION["USER"] ) )
//{
header( "location: logind" );
//}
?>