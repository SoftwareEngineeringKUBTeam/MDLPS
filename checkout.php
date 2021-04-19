<!--
Chris Droney
Mail Delivery Logging and Processing System
Creation Date: 4/18/2021
checkout.php
For checking-out packages.
-->
<?php
	include("functions.php");
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Package Delivery Processing</title>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>
<?php require_once("header.php"); ?>
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
				echo "<option>{$row['tracking_id']}</option>";
			}
			?>
		</select>
		<input type="submit" value="Submit">
		<input class="line" type="reset" value="Clear Form">
            </form>
        </div>
    </div>
	<?php
	if(ISSET($_POST["verify"]) && ISSET($_POST["trackingID"])){
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM package WHERE tracking_ID = :tid");
		$stmt->bindParam(":tid", $_POST["trackingID"]);
		$stmt->execute();
		$log = $stmt->fetch();
		$verified = verify2FA($log['log_date'], $log['tracking_ID']);
		echo "2FA Code: {$_POST['verify']} <br>";
		echo "Generated Code: $verified";
	}
	?>
</body>
</html>
