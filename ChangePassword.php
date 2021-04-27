<!--  Shane Flynn
Mail Delivery Logging and Processing System
Creation Date: 04/18/2021
Last Updated:  04/27/2021 make user verify password 
Page to change password
ChangePassword.php -->


<?php
	
    include("functions.php");
    checkLogin();
    if (ISSET($_POST["oldPassword"])&& ISSET($_POST["newPassword"]) && ISSET($_POST["verifyPassword"])){
     
     if ($_POST["newPassword"] != $_POST["verifyPassword"]) {
         $invalid = "Passwords must match";
     }
     else {
        $conn = dbConnect();
        $query = "UPDATE logininfo SET pass = :pass WHERE user = :user";
        $oldhash = password_hash($_POST['oldPassword'], PASSWORD_DEFAULT);
        $newhash = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
        $stmt = $conn -> prepare($query);
        $stmt->bindParam(":user", $_SESSION['loggedin']);
        $stmt->bindParam(":pass", $newhash);
        $stmt-> execute();
     }
    }
?>
	
<html>
<head>
 <meta charset="utf-8">
    <title>Change Password</title>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>

<body>
    <?php
    require_once("header.php");
    ?>

    <div class="log">
        <!--change password section header-->
        <div class="loghead">
            <h2>Change Password</h2>
        </div>

        <!--password form-->
        <div class="forms">
            <form method="POST" action="#">
                <input type="password" name="oldPassword" placeholder="Old Password" required autofocus>
                <input type="password" name="newPassword" placeholder="New Password" required>
                <input type="password" name="verifyPassword" placeholder="Verify New Password" required>
                <input type="submit" value="Submit">
            </form>
            <!-- error message if invalid login credentials -->
            <div style = "font-size:12px; color:red; margin-top:10px">
                <?php if(isset($invalid)){echo $invalid;} ?> 
            </div>
        </div>
    </div>
</body>
</html>