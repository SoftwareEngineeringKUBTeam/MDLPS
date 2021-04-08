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
	$userinfo = $_SESSION["userInfo"];
	// does not allow users who do not have SYSADMIN accessLevel to access this page
	if ($userinfo["accessLevel"] !== "SYSADMIN"){
		header("Location: index.php");
		die();
	}

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
        <div class="log">
            <form method="post" action="createuser.php">
                <input type="text" name="User" placeholder="Username" required autofocus>
                <input type="text" name="Passwd" placeholder="Password" required>
                <input type="text" name="nameFirst" placeholder="First Name" required>
				<input type="text" name="nameLast" placeholder="Last Name" required>
				<select name="Position" placeholder="Position">
                    <option value="DR">Desk Receptionist</option>
                    <option value="ARD">Assistant Resident Director</option>
                    <option value="RD">Resident Director</option>
                    <option value="COADMIN">Central Office Administrator</option>
                    <option value="SYSADMIN">System Administrator</option>
				</select>
				<input type="submit" value="Create User">
				<input type="reset" value="Clear Form">
			</form>
		</div>
	</div>
</body>
</html>