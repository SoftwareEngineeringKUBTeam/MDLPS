<!-- Hunter DeBlase
Mail Delivery Logging and Processing System
Creation Date: 11/30/2020
Last Modified: 4/18/2021
header.php
Header file for top of each page.-->

<nav class="head">
    <ul class="inlineList">
        <li><a href="login.php">Log Out</a></li>
        <li><a href="index.php">Log Packages</a></li>
        <li><a href="search.php">Search & Check-Out Packages</a></li>
        <li><a href="ChangePassword.php">Change Password</a></li>
        <li><a href="report.php">Generate Report</a></li>
		<?php
		$userinfo = $_SESSION["userInfo"];
		if ($userinfo["accessLevel"] === "SYSADMIN"){
			
			echo "<div class=\"dropdown\">
					<button class=\"dropbtn\">Administrator</button>
					<div class=\"dropdown-content\">
						<a href=\"createuser.php\">Create User</a>
						<a href=\"edituser.php\">Edit User</a>
						<a href=\"deleteuser.php\">Delete User</a>
					</div>
				  </div>";
		}
		?>
    </ul>
    <!--Auto-logout Functionality; Number following "content" is the logout timer in seconds-->
    <meta http-equiv="refresh" content="600;url=logout.php" />
</nav>
