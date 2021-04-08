<!--
Hunter DeBlase
Mail Delivery Logging and Processing System
Creation Date: 4/8/2021
Last Modified: 4/8/2021 - Added code for demonstrating 2FA verification
verify.php
Demonstrates 2FA verification requirement until check out functionality exists.
-->
<?php
	include("functions.php");
	if(ISSET($_POST["verify"] && ISSET($_POST["trackingID"]){
		
	}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Package Delivery Processing</title>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>
<?php require_once("header.html"); ?>
	<div class="log">
        <!-- Form header -->
        <div class="loghead">
            <h2>Verify 2FA</h2>
        </div>
        <!-- Container for styling forms -->
        <div class="forms">
            <form method="post" action="#">
                <input type="text" name="verify" placeholder="2FA Code" required>
		<select name="trackingID" placeholder="Select Package">
			<?php
			$conn = dbConnect();
			foreach($conn->query("SELECT tracking_id FROM package") as $row){
				echo "<option>{$row['tracking_id']}</option>"
			}
			?>
		</select>
		<input type="submit" value="Submit">
		<input class="line" type="reset" value="Clear Form">
            </form>
        </div>
    </div>
</body>
</html>