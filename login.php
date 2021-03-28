<!--  Nick Naylor
Mail Delivery Logging and Processing System
Creation Date: 03/25/2021
login page for MDLPS
login.php -->




<?php
    
    //use functions.php for the dbConnect function and logout
    include("functions.php");

    //start a session
    session_start();

    //check if user is already logged in
    if(isset($_SESSION["loggedin"])) {
        logout();
    }

//                  DELETE WHEN PUSHED TO ORIGIN FOR WEBSITE
/*************************************************************************************
    define('DB_SERVER','localhost');
    define('DB_USERNAME','MDLPS');
    define('DB_PASSWORD','csc355_testEmail');
    define('DB_NAME','test');
    $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
*************************************************************************************/
try {
    //use dbConnect to assign $conn variable
    $conn = dbConnect();


    //check if database is connected
    if(!$conn) {
        die("error: couldn't connect to database" . mysqli_connect_error());
    }
    
    if(isset($_POST["username"]) && isset($_POST["password"])) {

        $sql = "SELECT * FROM logininfo WHERE user = :user AND BINARY pass = :passwd limit 1";
        $search = $conn->prepare($sql);

        //get fields from form
        $user = $_POST["username"]; //get username field
        $passwd = $_POST["password"]; //get password field

        //bind the parameters
        $search->bindParam(':user', $user);
        $search->bindParam(':passwd', $passwd);

        $search->execute()
        $records = $search->fetchall(PDO::FETCH_BOTH);
        
        //check if database returned a result. if yes, register the session
        if($records) {
            
            $_SESSION["loggedin"] = $user;
            header("Location: index.php");
            die();
        }
        //username or password didn't match, don't log in
        else {
            //message to display on login page if incorrect credentials
            $invalid = "Invalid username or password, please try again.";
        }
    }    
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;

?>

<!-- start of html page -->
<html>
<head>
    <meta charset="utf-8">
    <title>MDLPS Login</title>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>
    <!--page header div-->
    <div class="head">
        <ul class="inlineList">
            <li><a>Mail Delivery Logging and Processing System</a></li>
            <li><a>Please login to scan packages</a></li>
        </ul>
    </div>

    <!--login section div-->
    <div class="log">
        <!--login section header-->
        <div class="loghead">
            <h2>Log In</h2>
        </div>

        <!--user name and password form-->
        <div class="forms">
            <form method="POST" action="#">
                <input type="text" name="username" placeholder="Username" required autofocus>
                <input type="password" name="password" placeholder="Password" required>
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


