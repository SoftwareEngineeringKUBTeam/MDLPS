<!-- Phil Corley
Mail Delivery Logging and Processing System
Creation Date: 3/30/2021
Last Modified: 3/30/2021 - created administrator page to create users
search.php
MDLPS search page-->

<!-- check if user is logged in, if not, redirect to login page -->
<?php
    session_start();
    include("functions.php");
    checkLogin();
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Administrator Dashboard</title>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>

<?php //include header 
require_once("header.html");?>
<div class="create user">
        <!-- Log section's header -->
        <div class="createhead">
            <h2>Add User</h2>
        </div>
        <!-- Container for styling forms -->
        <div class="forms">
            <form method="post" action="createuser.php">
                <input type="text" name="User" placeholder="Username" required autofocus>
                <input type="text" name="Passwd" placeholder="Password" required>
                <input type="text" name="nameFirst" placeholder="First Name" required>
				<input type="text" name="nameLast" placeholder="Last Name" required>
				<select name="Position" placeholder="Position">
                    <option>DR</option>
                    <option>ARD</option>
                    <option>RD</option>
                    <option>COADMIN</option>
                    <option>SYSADMIN</option>
				<input class="line" type="submit" value="Create User">
				<input class="line" type="reset" value="Clear Form">

		</div>
		
</body>
</html>