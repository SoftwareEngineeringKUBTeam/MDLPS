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
                    <div><label> 1<input type="checkbox" id="bldg1" name="bldg1" value="Building 1" checked></label></div>
                    <div class="line"><label> 2<input type="checkbox" id="bldg2" name="bldg2" value="Building 2" checked></label></div>
                    <div class="line"><label> 3<input type="checkbox" id="bldg3" name="bldg3" value="Building 3" checked></label></div>
                    <div class="line"><label> 4<input type="checkbox" id="bldg4" name="bldg4" value="Building 4" checked></label></div>
                </div>
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
