 <?php

require_once("functions.php"); // used to access notifyStudent function

//require user to be logged in before using this
checkLogin();
	



try{
	$conn = dbConnect();
	// search student db for record of student and retrieve email and other residential information

	if (isset($_POST['rows']) && $_SESSION['userInfo']['user'] != $_POST['rows']){

			$sql = "DELETE FROM logininfo WHERE (`user` = :user);";
			$stmt = $conn->prepare($sql);
			// prepare sql and bind parameters

			$stmt->bindParam(":user", $_POST['rows']);
			
			$stmt->execute();
		
		echo "<h1>User " . $_POST['rows'] . " deleted successfully!</h1>";
	}			  
		
}
catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}
		
	header("Location: deleteuser.php");

	
?>
