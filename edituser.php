 <!-- Phil Corley
Mail Delivery Logging and Processing System
Creation Date: 3/30/2021
Last Modified: 3/30/2021 - created administrator page to create users
edituser.php
MDLPS edit user page-->

<!-- check if user is logged in, if not, redirect to login page -->
<?php
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
<div class="edit user">
        <!-- Log section's header -->
    <div class="createhead">
        <h2>Edit User</h2>
    </div>
        <!-- Container for styling forms -->
        <div class="log">
            <form method="post" action="edituserdb.php">
				<label>Change:
					<select name="category">
						<option selected value="user">Employee Username</option>
						<option value="accessLevel">Access Level</option>
						<option value="nameFirst">First Name</option>
						<option value="nameLast">Last Name</option>
					</select>
				</label>
				<p>
					<label>To:<input type="text" name="term" required></label>
					<input type="submit" value ="Edit">
				</p>

				<?php 

				$conn = dbConnect();
				$stmt = $conn->prepare("SELECT user, accessLevel, nameFirst, nameLast FROM logininfo ORDER BY nameLast");
				// $stmt->bindParam(":pid", $_POST["post_ID"]);
				$stmt->execute();
				$records = $stmt->fetchall(PDO::FETCH_ASSOC);

				printUserEditTable($records);

				?>
			</form>
		</div>
	</div>
</body>
</html>
