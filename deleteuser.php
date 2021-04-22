 <!-- Phil Corley
Mail Delivery Logging and Processing System
Creation Date: 3/30/2021
Last Modified: 3/30/2021 - created administrator page to create users
edituser.php
MDLPS edit user page-->

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
require_once("header.php");
?>
<div class="delete user">
        <!-- Log section's header -->
    <div class="createhead">
        <h2>Delete User</h2>
    </div>
        <!-- Container for styling forms -->
        <div class="log">
            <form method="post" action="deleteuserdb.php">
					
				<?php 

				$conn = dbConnect();
				$stmt = $conn->prepare("SELECT user, accessLevel, nameFirst, nameLast FROM logininfo ORDER BY nameLast");
				// $stmt->bindParam(":pid", $_POST["post_ID"]);
				$stmt->execute();
				$records = $stmt->fetchall(PDO::FETCH_ASSOC);

				printUserEditTable($records);

				?>
				<input type="submit" value="Delete">
			</form>
		</div>
	</div>
</body>
</html>
