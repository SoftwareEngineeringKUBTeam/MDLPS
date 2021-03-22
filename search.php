<!-- Chris Droney
Mail Delivery Logging and Processing System
Creation Date: 2/19/2021
Last Modified: 3/22/2021
search.php
MDLPS search page-->
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
require_once("header.html");
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

//checking if category & term are set, and 'building' is the selected category
if (isset($_GET['category']) && ($_GET['category'] == 'building') && isset($_GET['term']))
{
    
    //Prepared statement
    $select = "SELECT * FROM package WHERE building = ?"
    $stmt = $conn->prepare($select);
    
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
    
    //closing the css container
    echo "</div>";
}

//checking if category & term are set, and 'Name' is the selected category
if (isset($_GET['category']) && ($_GET['category'] == 'Student Name') && isset($_GET['term'])) {
    
    //Exploding the Student Name into $name_first & $name_last
    $term = $_GET['term'];
    list($name_first, $name_last) = explode(' ', $term);

    //Prepared statement
    $select = "SELECT * FROM package WHERE `name_first` = ? AND `name_last` = ?";
    $stmt = $conn->prepare($select);

    //Parameter Binding
    $category = $_GET['category'];
    $stmt->bindParam($name_first, $name_last);

    $stmt->execute();

    //debug
    print "<h3>Reports where $category =  $term</h3>";

    //Printing Table
    $records = $stmt->fetchall(PDO::FETCH_ASSOC);
    printTable($records);
    
    //closing the css containter
    echo "</div>";
}

//checking if category & term are set, and 'tracking_ID' is the selected category
if (isset($_GET['category']) && ($_GET['category'] == 'tracking_ID') && isset($_GET['term'])) {

    //Prepared statement
    $select = "SELECT * FROM package WHERE `tracking_ID` = ?";
    $stmt = $conn->prepare($select);
        
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
        
    //closing the css containter
    echo "</div>";
}

//Close DB connection
$conn = null;


?>
</body>
</html>

