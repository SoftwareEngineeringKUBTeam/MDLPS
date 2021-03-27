<!--
Hunter DeBlase
Mail Delivery Logging and Processing System
Creation Date: 12/2/2020
Last Modified: 3/27/2020 - check for logged in session before continuing
print.php
Prints contents of POST array for debugging.
-->
<pre>
<?php
    //user must be logged in for this to work
    session_start();
    include("functions.php");
    checkLogin();

    print_r($_POST);
?>
</pre>
