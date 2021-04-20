<!-- Nick Nayor
Mail Delivery logging and processing system
Creation date: 04/18/2021
report.php
-->

<!-- check if user is logged in, if not, redirect to login page -->
<?php
    session_start();
    include("functions.php");
    checkLogin();

    try {
        $conn = dbConnect();
        //check if database is connected
        if(!$conn) {
            die("error: couldn't connect to database");
        }// END if 

        if(isset($_POST["dFrom"]) && isset($_POST["dTo"])) {
            $dFrom = $_POST["dFrom"] . " 00:00:00";
            $dTo = $_POST["dTo"] . " 23:59:59";

            if (strtotime($dFrom) <= strtotime($dTo))  {
                //query
                $sql = ("SELECT * FROM package WHERE log_date BETWEEN :dFrom and :dTo");
                

                /************************************************************************
                 * parameters below are to narrow the database query.
                 * by default, the page is set to search all packages within the date range.
                 * if the user changes the search parameters, the statements below will mutate
                 * the $sql variable to match user's parameters. 
                 ***********************************************************************/
                // package status: not picked up
                if ($_POST["PUstatus"] == "nPU") {
                    $sql .= " AND sign_date IS NULL";
                }
                // package status: picked up
                else if ($_POST["PUstatus"] == "PU") {
                    $sql .= " AND sign_date IS NOT NULL";
                }
                // just to close out the if/else statement.  intentionally blank
                // this will be the case if "All" is left selected as to not specify
                // whether the package was picked up or not
                else {
                    // do nada
                }

                // builidng 1 set
                if (!empty($_POST["bldg1"])) {
                    $bldg1 = $_POST["bldg1"];
                    $sql .= " AND building=:bldg1";
                    $search->bindParam(":bldg1", $bldg1);
                }
                // building 2 set
                if (!empty($_POST["bldg2"])) {
                    $bldg2 = $_POST["bldg2"];
                    $sql .= " AND building=:bldg2";
                    $search->bindParam(":bldg2", $bldg2);
                }
                // building 3 set
                if (!empty($_POST["bldg3"])) {
                    $bldg3 = $_POST["bldg3"];
                    $sql .= " AND building=:bldg3";
                    $search->bindParam(":bldg3", $bldg3);
                }
                // building 4 set 
                if (!empty($_POST["bldg4"])) {
                    $bldg4 = $_POST["bldg4"];
                    $sql .= " AND building=:bldg4";
                    $search->bindParam(":bldg4", $bldg4);
                }
                // if all buildings are unchecked, it should still search using all builidngs
                
                // prepared statement
                $search = $conn->prepare($sql);
                
                $search->bindParam(':dFrom', $dFrom);
                $search->bindParam(":dTo", $dTo);
                $search->execute();

                print "<h3>Report: </h3>";
                $report = $search->fetchall(PDO::FETCH_ASSOC);
                printTable($report);
                
            }
            else {
                $invalid = "Start date should be before end date.";
            }
        } 
    }// END try
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }// END catch
    $conn = null;

    
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Generate A Report</title>
    <link rel='stylesheet' type='text/css' href='style.css'>

    <!-- page specific styling -->
    <style>
        label{
            display: inline-block;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
        require_once("header.php");
    ?>

    <div class="log">
        <div class="createhead">
            <h2>Generate a Report</h2>
        </div>

        <div class="forms">
            <form method="post" action="report.php">
                <label>Range start:<input type="date" name="dFrom" placeholder="MM/DD/YYYY" required autofocus></label>
                <label>Range end:<input type="date" name="dTo" placeholder="MM/DD/YYYY" required></label>
                <p>Package Pickup Status</p>
                <select type="text" name="PUstatus">
                    <option value="all">All</option>
                    <option value="npu">Package Not Picked Up</option>
                    <option value="pu">Package Picked Up</option>
                </select>
                
                <div>
                    <p>Which buildings would you like to include on the report?</p>
                    <label>
                        1
                        <input type="checkbox" id="bldg1" name="bldg1" value="Building 1" checked>
                    </label>                    
                    <label>
                        2
                        <input type="checkbox" id="bldg2" name="bldg2" value="Building 2" checked>
                    </label>                    
                    <label>
                        3
                        <input type="checkbox" id="bldg3" name="bldg3" value="Building 3" checked>
                    </label>
                    <label>
                        4
                        <input type="checkbox" id="bldg4" name="bldg4" value="Building 4" checked>
                    </label>
                </div>
                <br>
                <input type="submit" value="Generate">
                <input type="reset" value="Clear Form">
            </form>
            <div style="font-size:12px; color:red; margin-top:10px">
                <?php if(isset($invalid)){echo $invalid;}?>
            </div>
        </div>
    </div>
</body>
</html>
