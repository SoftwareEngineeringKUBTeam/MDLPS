<!-- Hunter DeBlase
Mail Delivery Logging and Processing System
Creation Date: 11/30/2020
Last Modified: 2/22/2021 - commented out email form for testing, changed bed letter scheme
index.php
MDLPS main page-->
<html>
<head>
    <meta charset="utf-8">
    <title>Package Delivery Processing</title>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>
    <!-- Load header file -->
    <?php require_once('./header.html'); ?>

    <!-- Container div for entirety of package logging -->
    <div class="log">
        <!-- Log section's header -->
        <div class="loghead">
            <h2>Log a Package</h2>
        </div>
        <!-- Container for styling forms -->
        <div class="forms">
            <form method="post" action="logpackage.php">
                <input type="text" name="trackingID" placeholder="Tracking Number" required autofocus>
                <input type="text" name="nameLast" placeholder="Last Name" required>
                <input type="text" name="nameFirst" placeholder="First Name" required>
                <!--<input type="email" name="email" placeholder="Email" required> -->
                <select name="building" placeholder="Building ID">
                    <option>Building 1</option>
                    <option>Building 2</option>
                    <option>Building 3</option>
                    <option>Building 4</option>
		</select>
		<input class="line" type="text" name="roomNum" placeholder="Room Number" maxLength="4" size="6" required>
		<select class="line" name="bedLetter" placeholder="Bed Letter">
			<option>A</option>
			<option>B</option>
			<option>C</option>
			<option>D</option>
			<option>E</option>
			<!--
			Bed letters need to be single characters to be searched in the database
			otherwise, "Bed A" does not correspond with column bed_letter "A"
			-->
		<input type="submit" value="Submit">
		<input class="line" type="reset" value="Clear Form">
            </form>
        </div>
    </div>
</body>
</html>

