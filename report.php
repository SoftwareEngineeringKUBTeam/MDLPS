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
            $dFrom = $_POST["dFrom"];
            $dTo = $_POST["dTo"];

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


                <input type="submit" value="Generate">
            </form>
            <div style="font-size:12px; color:red; margin-top:10px">
                <?php if(isset($invalid)){echo $invalid;}?>
            </div>
        </div>
    </div>
</body>
</html>
