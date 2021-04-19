<?php
/*********************************    CHANGES   *********************************
    -20FEB2021 Nick Naylor: added notifyStudent function to send an email to the
                            student's email address
    -27MAR2021 Nick Naylor: Added logout function.  Kills the session and 
                            redirects back to the login page.
                            Added checklogin function.  the pages will use this 
                            to verify the user is logged in before they can access
                            the page.

*********************************************************************************/



/* Function Name: printTable
 * Description: prints an HTML table based on data from the sqlite3 database
 * Parameters: (string) $name: the array of sql data being passed to the function
 */

function printTable($data) {
    if (count($data) === 0) {
        return;
    }
    $header = array_keys($data[0]);
    print "<table>\n";
    print "<tr>";
    foreach ($header as $h) {
        print "<th>$h</th>";
    }
    print "</tr>\n";
    foreach ($data as $record) {
        $values = array_values($record);
        print "<tr>";
        foreach ($values as $v) {
            print "<td>$v</td>";
        }
        print "</tr>\n";
    }
    print "</table>";
}

/* Function Name: printFormTable
 * Description: prints an HTML table with a checkbox form based on data from the MySQL database
 * Parameters: (string) $data: the array of sql data being passed to the function
 */

function printFormTable($data) {
    if (count($data) === 0) {
        return;
    }
    $header = array_keys($data[0]);
    print "<table>\n";
    print "<tr>";
    print "<th>Check Out</th>";
    foreach ($header as $h) {
        print "<th>$h</th>";
    }
    print "</tr>\n";
    foreach ($data as $record) {
        $values = array_values($record);
        $form_value = implode(',', $values);
        print "<tr>";
        print "<td><input type=\"submit\" value =\"Check Out\"></td>";
        foreach ($values as $v) {
            print "<td>$v</td>";
        }
        print "</tr>\n";
    }
    print "</table>";
}




/* Function Name:   dbConnect
 * Author:          Hunter DeBlase
 * Description:     Connects to the database in the environment variable CLEARDB_DATABASE_URL
 * Return:          Database connection
 */
function dbConnect(){
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	$server = $url["host"];
	$username = $url["user"];
    $password = $url["pass"];
    $db = substr($url["path"] , 1);

	$conn = new PDO("mysql:host=$server;dbname=$db", $username, $password);
    return $conn;
}

/* Function Name:   verify2fa
 * Author:          Shane Flynn
 * Description:     Verifies the 2fa code
 * Return:          True if codes are the same false otherwise
 */
function verify2fa($logdate, $trackId){
$hash = substr(md5($logdate.$trackingId), 0, 8);
return $hash;
}

/*
    Function Name:  notifyStudent
    Author:         Nick Naylor
    Description:    This function is called in logpackage.php and uses the PHP
                    mail function to send an email to the student's email address
                    with the tracking number.
    Parameters:     string $email - the student's email address 
                    string $trackID - the package's tracking number
                    string $name - the students first name
    Returns:        True if mail sent, False if mail did not send
    Considerations: For the PHP mail function to work you must have your server
                    configured for using SMTP
*/
function notifyStudent($email, $trackID, $name, $validateCode) {
    // define the subject
    $subject = 'You have a package ready for pickup!';

    // define the message
    $message = "
    <html>     
    <body>
        <div id=\"email\" style='background: #701932;color: white; height: 100% auto;'>
            <div id=\"welcome\" style='background: #b6a368; color: black; height: 2em auto; text-align: center; display: block;'>
                <h2>This message was sent by the Mail Delivery Logging and Processing System</h2>
            </div>
            <div id=\"text\" style='background: #701932; color: white; margin: 3em; padding-bottom: 3em; line-height: 3em auto;'>
                <h2>{$name},</h2>
                <p>You have a package with tracking number {$trackID} ready for pickup!</p>
                <p>Your code is {$validateCode}.</p>`
            </div>
            
        </div>
    </body>
    </html>";    

    // define headers
    $headers = "From: DO NOT REPLY <testMDLPS@gmail.com>\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";

    // send the message
    return mail($email, $subject, $message, $headers);
} // END notifyStudent 

/*
    Function Name:  logout
    Author:         Nick Naylor
    Description:    This function is used to logout from the system.  
                    It uses session_destroy and redirects back to the login page
    Parameters:     N/A
    Returns:        N/A - redirects back to login page
*/
function logout() {    

    session_start(); //get session data
    session_unset(); //unset session variables
    session_destroy(); //destroy session data
    session_write_close(); //overkill
    session_regenerate_id(true); //replace the sesson id
    header("Location: login.php"); //redirect to login page    
    
} // END logout function


/*
    Function Name:  checkLogin
    Author:         Nick Naylor
    Description:    This function is called on each access of a page to verify
                    that the user is logged in.  checks $_SESSON["loggedin"]
    Parameters:     N/A
    Returns:        N/A
*/
function checkLogin() {
    session_start();
    
    //make sure loggedin is set. if not, redirect to login.php
    if(!isset($_SESSION["loggedin"])) {        
        header("Location: login.php");
        die(); //die
    }// END if

}// END checkLogin function


?>
