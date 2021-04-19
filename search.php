<!-- Chris Droney
Mail Delivery Logging and Processing System
Creation Date: 2/19/2021
Last Modified: 3/27/2021 - check for logged in session before continuing
search.php
MDLPS search page-->

<!-- check if user is logged in, if not, redirect to login page -->
<?php
    session_start();
    include("functions.php");
    checkLogin();
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Package Search</title>
    <link rel='stylesheet' type='text/css' href='style.css'>

    <!-- Page-specific styling. We could just put this all in style.css but idk if it'll conflict with anything -->
    <style>
        table {
            border-collapse: collapse;
            width: 70%;
            margin-left: 15%;
            margin-right: 15%;
        }

        tr:nth-child(even) {
            background-color: #922040;
        }

        th, td {
            text-align: center;
        }

        th {
            color: white;
            font-size: 30px;
            text-transform: capitalize;
        }

        td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 20px;
            color: white
        }
    </style>

</head>
<body>
<?php
//include header
require_once("header.php");
//superglobals for collecting form data
$s_tracking = isset($_GET['category']) && $_GET['category'] === 'tracking_ID';
$s_sname = isset($_GET['category']) && $_GET['category'] === 'Student Name';
$s_building = isset($_GET['category']) && $_GET['category'] === 'building';
?>


    <!-- Container div for entirety of package logging -->
    <div class="log">
        <!-- Log section's header -->
        <div class="loghead">
            <h2>Package Search</h2>
        </div>
        <!-- Container for styling forms -->
        <div class="forms">
              <form action="search.php" method="get">
    <label>Category:
      <select name="category">
        <option selected value="tracking_ID" <?php print $s_tracking ? "selected" : ""; ?> >Tracking Number</option>
        <option value="Student Name" <?php print $s_sname ? "selected" : ""; ?> >Student Name</option>
        <option value="building" <?php print $s_building ? "selected" : ""; ?> >Building</option>
      </select>
    </label>
    <p>
        <label>Term:<input type="text" name="term"></label>
        <input type="submit" value ="Search">
    </p>
  </form>
        </div>
    </div>

<?php
require_once("functions.php");

$conn = dbConnect();

//container for styling search result table
echo "<div class=\"results\">";

//Keeping package_ID stored through the 2FA form's refresh action'
if(isset($_POST["post_ID"]))
{
    $_POST['package_ID'] = $_POST["post_ID"];
}

if (isset($_POST['package_ID']))
{

    print "<h3>2FA Code for Package #";
        print($_POST['package_ID']);
    print "</h3>";


    $stored_ID = $_POST['package_ID'];
    
    //form for entering 2FA code
    print"<div class=\"forms\">";
        print"<form method=\"post\" action='#'>";
            print"<input type=\"hidden\" name=\"post_ID\" value = $stored_ID>";
            print"<input type=\"text\" name=\"verify\" placeholder=\"2FA Code\" required>";
            print"<input type=\"submit\" value=\"Submit\">";
		    print"<input class=\"line\" type=\"reset\" value=\"Clear Form\">";
        print"</form>";
    print"</div>";


    //if 2FA code has been entered, and post_ID is set
    if(ISSET($_POST["verify"]) && ISSET($_POST["post_ID"]))
    {
		    //Verification
            $conn = dbConnect();
		    $stmt = $conn->prepare("SELECT * FROM package WHERE ID = :pid");
		    $stmt->bindParam(":pid", $_POST["post_ID"]);
		    $stmt->execute();
		    $log = $stmt->fetch();
		    $verified = verify2FA($log['log_date'], $log['tracking_ID']);
		    $input_code = $_POST['verify'];

            //if verification successful, set the check-out date accordingly, and clear the saved post_ID
            if($input_code == $verified)
            {
                $date = date('Y-m-d H:i:s');
                print"<h4>Verification Successful. Package has been Checked-Out</h4>";
                $query = "UPDATE package SET sign_date = :sdate WHERE ID = :pid";
                $stmt = $conn -> prepare($query);
                $stmt->bindParam(":sdate", $date);
                $stmt->bindParam(":pid", $_POST["post_ID"]);
                $stmt-> execute();
                unset($_POST["post_ID"]);
            }
            //if verification unsuccessful, print error message and continue.
            if($input_code != $verified)
            {
                 print"<h4>Verification failed. Please re-enter 2FA code.</h4>";
            }
	}


}


//checking if category & term are set, and 'building' is the selected category
if (isset($_GET['category']) && ($_GET['category'] == 'building') && isset($_GET['term']))
{
    
    //Prepared statement
    $select = "SELECT * FROM package WHERE building = :term";
    $stmt = $conn->prepare($select);
    
    //Parameter Binding
    $category = $_GET['category'];
    $term = $_GET['term'];
    $stmt->bindParam(':term', $term);

    $stmt->execute();

    //debug
    //print "<h3>Reports where $category =  $term</h3>";

    //Printing Table
    $records = $stmt->fetchall(PDO::FETCH_ASSOC);
    printPackageTable($records);
    
    //closing the css container
    echo "</div>";
}

//checking if category & term are set, and 'Name' is the selected category
if (isset($_GET['category']) && ($_GET['category'] == 'Student Name') && isset($_GET['term'])) {
    
    //Exploding the Student Name into $name_first & $name_last
    $term = $_GET['term'];
    list($name_first, $name_last) = explode(' ', $term);

    //Prepared statement
    $select = "SELECT * FROM package WHERE `name_first` = :name_first AND `name_last` = :name_last";
    $stmt = $conn->prepare($select);

    //Parameter Binding
    $category = $_GET['category'];
    $stmt->bindParam(":name_first", $name_first);
    $stmt->bindParam(":name_last", $name_last);

    $stmt->execute();

    //debug
    //print "<h3>Reports where $category =  $term</h3>";

    //Printing Table
    $records = $stmt->fetchall(PDO::FETCH_ASSOC);
    printPackageTable($records);
    
    //closing the css containter
    echo "</div>";
}

//checking if category & term are set, and 'tracking_ID' is the selected category
if (isset($_GET['category']) && ($_GET['category'] == 'tracking_ID') && isset($_GET['term'])) {

    //Prepared statement
    $select = "SELECT * FROM package WHERE `tracking_ID` = :term";
    $stmt = $conn->prepare($select);
        
    //Parameter Binding
    $category = $_GET['category'];
    $term = $_GET['term'];
    $stmt->bindParam(':term', $term);

    $stmt->execute();

    //debug
    //print "<h3>Reports where $category =  $term</h3>";
    
    //Printing Table
    $records = $stmt->fetchall(PDO::FETCH_ASSOC);
    printPackageTable($records);
        
    //closing the css containter
    echo "</div>";
}

//Close DB connection
$conn = null;


?>
</body>
</html>

