<!-- Chris Droney
Mail Delivery Logging and Processing System
Creation Date: 2/19/2021
Last Modified: 2/19/2021
search.php
MDLPS main page-->
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
    <!-- Load header file -->
    <?php require_once('./header.html'); ?>

<?php

//Database Connection Parameters
$servername = "localhost";
$username = "MDLPS";
$password = "csc355_testEmail";
$dbname = "test";


// Checks connection to database - for debug
echo "<h4>DB Status: ";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
  die("Connection failed: </h4>" . $conn->connect_error);
}
echo "Connected to $dbname</h4>";
$conn->close();

?>

<!-- php superglobals for collecting form data -->
<?php
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

//container for styling search result table
echo "<div class=\"results\">";

//checking if category & term are set, and 'building' is the selected category
if (isset($_GET['category']) && ($_GET['category'] == 'building') && isset($_GET['term']))
{
    //Connecting to DB
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    //Prepared statement
    $select = "SELECT * FROM package WHERE building = :term";
    $stmt = $db->prepare($select);
    
    //Parameter Binding
    $category = $_GET['category'];
    $term = $_GET['term'];
    $stmt->bindParam(':term', $term);

    $stmt->execute();

    //debug
    print "<h3>Reports where $category =  $term</h3>";

    //Printing Table
    $records = $stmt->fetchall(PDO::FETCH_ASSOC);
    printTable($records);
    
    //closing the db connection & css containter
    $db = null;
    echo "</div>";
}

//checking if category & term are set, and 'Name' is the selected category
if (isset($_GET['category']) && ($_GET['category'] == 'Student Name') && isset($_GET['term'])) {
    
    //Exploding the Student Name into $name_first & $name_last
    $term = $_GET['term'];
    list($name_first, $name_last) = explode(' ', $term);
        
    //Connecting to DB
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    //Prepared statement
    $select = "SELECT * FROM package WHERE `name_first` = :first AND `name_last` = :last";
    $stmt = $db->prepare($select);

    //Parameter Binding
    $category = $_GET['category'];
    $stmt->bindParam(':first', $name_first);
    $stmt->bindParam(':last', $name_last);

    $stmt->execute();

    //debug
    print "<h3>Reports where $category =  $term</h3>";

    //Printing Table
    $records = $stmt->fetchall(PDO::FETCH_ASSOC);
    printTable($records);
    
    //closing the db connection & css containter
    $db = null;   
    echo "</div>";
}

//checking if category & term are set, and 'tracking_ID' is the selected category
if (isset($_GET['category']) && ($_GET['category'] == 'tracking_ID') && isset($_GET['term'])) {

    //Connecting to DB
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    //Prepared statement
    $select = "SELECT * FROM package WHERE `tracking_ID` = :term";
    $stmt = $db->prepare($select);
        
    //Parameter Binding
    $category = $_GET['category'];
    $term = $_GET['term'];
    $stmt->bindParam(':term', $term);

    $stmt->execute();

    //debug
    print "<h3>Reports where $category =  $term</h3>";
    
    //Printing Table
    $records = $stmt->fetchall(PDO::FETCH_ASSOC);
    printTable($records);
        
    //closing the db connection & css containter
    $db = null;   
    echo "</div>";
}


?>
</body>
</html>

