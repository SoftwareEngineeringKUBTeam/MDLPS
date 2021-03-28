<!--  Chris Droney
Mail Delivery Logging and Processing System
Creation Date: 03/28/2021
Last Updated:  03/28/2021 -
Auto-Logout functionality for MDLPS
logout.php -->




<?php
    
    //use functions.php for the logout function
    include("functions.php");

    //start a session
    session_start();

    //check if user is already logged in
    if(isset($_SESSION["loggedin"])) {
        logout();
    }
?>

