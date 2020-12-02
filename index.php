<!-- Hunter DeBlase
Mail Delivery Logging and Processing System
Creation Date: 11/30/2020
Last Modified: 12/2/2020
index.php
Basic prototype page for the MDLPS-->
<html>
<head>
    <meta charset="utf-8">
    <title>Package Delivery Processing</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <!-- Load header file -->
    <?php require_once('./header.php'); ?>

    <!-- Container div for entirety of package logging -->
    <div class="log">
        <!-- Log section's header -->
        <div class="loghead">
            <h2>Log a Package</h2>
        </div>
        <!-- Container for styling forms -->
        <div class="forms">
            <form method="post" action="print.php">
                <input type="text" name="trackingID" placeholder="Tracking Number" required autofocus>
                <input type="text" name="nameLast" placeholder="Last Name" required>
                <input type="text" name="nameFirst" placeholder="First Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <select name="building" placeholder="Building ID">
                    <option selected="selected">Building 1</option>
                    <option>Building 2</option>
                    <option>Building 3</option>
                    <option>Building 4</option>
                </select>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</body>
</html>

