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
     $oldPassword = $_POST["oldPassword"];
     $newhash = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

     $conn = dbConnect();
     $check = "SELECT * from logininfo WHERE user=:user";
     $search = $conn->prepare($check);     
     $search->bindParam(':user', $_SESSION['loggedin']);
     $result = $search->fetch(PDO::FETCH_ASSOC);
     $oldhash = $result["pass"];

     // make sure old password input by user matches password in DB
     if (!password_verify($oldPassword, $oldhash)) {
         $invalid = "Old password must match your current password";
     }
    
     // new passwords don't match
     else if ($_POST["newPassword"] != $_POST["verifyPassword"]) {
         $invalid = "Passwords must match";
     }
     // password checks pass, update the password
     else {
        $query = "UPDATE logininfo SET pass = :pass WHERE user = :user";        
        $stmt = $conn -> prepare($query);
        $stmt->bindParam(":user", $_SESSION['loggedin']);
        $stmt->bindParam(":pass", $newhash);
        $stmt-> execute();
        $invalid = "";
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