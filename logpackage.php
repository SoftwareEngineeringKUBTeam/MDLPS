<!-- Shane Flynn
Mail Delivery Logging and Processing System
Creation Date: 2/19/2021
Last Modified: 2/20/2021 - implemented notifyStudent from functions.php
logpackage.php -->

<?php require_once('./header.html'); ?>
<?php

require_once("functions.php"); // used to access notifyStudent function
/*
Array
(
    [trackingID] => TNUM
    [nameLast] => TLNAME
    [nameFirst] => TFNAME
    [email] => T@T.com
    [building] => Building 1
    [roomNum] => 8888
    [bedLetter] => Bed A
)*/

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

if (!isset ($_POST['trackingID']))
{
    header ('Location: index.php');
    die();
}
try{
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // prepare sql and bind parameters
  $stmt = $conn->prepare("INSERT INTO PACKAGE (building, log_date, name_first, name_last, tracking_ID)
  VALUES (:building, NOW(), :name_first, :name_last, :tracking_ID)");
  
  $stmt->bindParam(':building', $_POST['building']);
  $stmt->bindParam(':name_first', $_POST['nameFirst']);
  $stmt->bindParam(':name_last', $_POST['nameLast']);
  $stmt->bindParam(':tracking_ID', $_POST['trackingID']);
  
  $stmt->execute();

  echo "New records created successfully. ";
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;
$email = $_POST['email'];
$trackingID = $_POST['trackingID'];

//echo "<form action='print.php'method='post' id = 'auto'> <input type = 'hidden' name = 'email' value = '{$email}'> <input type = 'hidden' name = 'trackingID' value = '{$trackingID}'> <input type = 'submit'></form>";

$sName = $_POST['nameFirst'];
// call notifyStudent. pass the email and tracking id to be sent in the email
echo (notifyStudent($email, $trackingID, $sName)) ? " Notification sent" : " Error sending email.";



?>

<script type="text/javascript">
    document.getElementById('auto').submit();
</script>
<!--STUDENT (SID, name_first, name_last, email, building, room_num, bed_letter)
PACKAGE (ID, building, log_date, name_first, name_last, tracking_ID, sign_date, 2FA) -->