<!-- Shane Flynn
Mail Delivery Logging and Processing System
Creation Date: 2/19/2021
Last Modified: 3/27/2021 - check for logged in session before continuing
logpackage.php -->

<?php
require_once("functions.php"); // used to access notifyStudent function

//require user to be logged in before using this
checkLogin();


$email = "";
if (!isset ($_POST['trackingID']))
{
    echo "Tracking ID Invalid";
    header ('Location: index.php');
    die();
}
try{
  $conn = dbConnect();
  // search student db for record of student and retrieve email and other residential information
  $query = "SELECT email FROM STUDENT WHERE `name_last` = :name_last AND `name_first` = :name_first AND `building` = :building AND `room_num` = :room_num AND `bed_letter` = :bed_letter"; 
  $search = $conn->prepare($query);
  // prepare sql and bind parameters
  $search->bindParam(":name_last", $_POST['nameLast']);
  $search->bindParam(":name_first", $_POST['nameFirst']);
  $search->bindParam(":building", $_POST['building']);
  $search->bindParam(":room_num", $_POST['roomNum']);
  $search->bindParam(":bed_letter", $_POST['bedLetter']);
  
  $search->execute();
  
  $return = $search->fetchall(PDO::FETCH_ASSOC);
  
  // if student record was found in database, pull email and log package into package database
  if ($search->rowCount() == 1) {
	// get email from search query
	$email = $return[0]['email'];
	date_default_timezone_set('America/New_York');
	$date = date('Y-m-d H:i:s');
    // Generate 8 character 2FA code from current timestamp
    $hash = verify2fa($date, $_POST['trackingID']);
	
	// prepare sql and bind parameters	
	$stmt = $conn->prepare("INSERT INTO PACKAGE (building, log_date, name_first, name_last, tracking_ID, 2FA) VALUES (:building, :date, :name_first, :name_last, :tracking_ID, :2FA)");
  
    $stmt->bindParam(":building", $_POST['building']);
	$stmt->bindParam(":date", $date);
    $stmt->bindParam(":name_first",  $_POST['nameFirst']);
    $stmt->bindParam(":name_last", $_POST['nameLast']);
    $stmt->bindParam(":tracking_ID", $_POST['trackingID']);
    $stmt->bindParam(":2FA", $hash);
  
    $stmt->execute();

    echo "An email will be sent to: ".$email."<br><br>";
    echo "New records created successfully.<br><br>";
  
  } else {
	/* 
	  This should echo an error that there is no student in the database 
	  that matches these records and forces the user to input the data in 
	  again or search to see if the student is still at that residence 
	  using THD or other residential software.
	  */
	  echo "Student not Found<br><br>";
	  echo "<button onclick=\"goBack()\">Go Back</button>

			<script>
			function goBack() {
				window.history.back();
			}
			</script>
			<form action=\"https:\/\/mykuhousing.kutztown.edu/mobile\">
				<input type=\"submit\" value=\"Lookup Student\" />
			</form>";
	  
	//echo "<p>ERROR</p>";
	//header ('Location: index.php');
	die();
  }
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;

$trackingID = $_POST['trackingID'];

//echo "<form action='print.php'method='post' id = 'auto'> <input type = 'hidden' name = 'email' value = '{$email}'> <input type = 'hidden' name = 'trackingID' value = '{$trackingID}'> <input type = 'submit'></form>";

$sName = $_POST['nameFirst'];
// call notifyStudent. pass the email and tracking id to be sent in the email
echo (notifyStudent($email, $trackingID, $sName, $hash)) ? " Notification sent" : " Error sending email.";
header("refresh:10;url=index.php");
?>

<script type="text/javascript">
    document.getElementById('auto').submit();
</script>
