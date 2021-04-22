 <?php

require_once("functions.php"); // used to access notifyStudent function

//require user to be logged in before using this
session_start();
checkLogin();
	



try{
	$conn = dbConnect();
	// search student db for record of student and retrieve email and other residential information
  
   if (isset($_POST['category']) && isset($_POST['term']) && isset($_POST['rows'])){
		if($_POST['category'] == 'user'){

			$sql = "UPDATE logininfo SET `user` = :value WHERE (`user` = :user);";
			$stmt = $conn->prepare($sql);
			// prepare sql and bind parameters

			$stmt->bindParam(":value", $_POST['term']);
			$stmt->bindParam(":user", $_POST['rows']);
			
			$stmt->execute();
		} 
		else if($_POST['category'] == 'accessLevel'){

			$sql = "UPDATE logininfo SET `accessLevel` = :value WHERE (`user` = :user);";
			$stmt = $conn->prepare($sql);
			// prepare sql and bind parameters

			$stmt->bindParam(":value", $_POST['term']);
			$stmt->bindParam(":user", $_POST['rows']);
			
			$stmt->execute();
		}
		else if($_POST['category'] == 'nameFirst'){

			$sql = "UPDATE logininfo SET `nameFirst` = :value WHERE (`user` = :user);";
			$stmt = $conn->prepare($sql);
			// prepare sql and bind parameters

			$stmt->bindParam(":value", $_POST['term']);
			$stmt->bindParam(":user", $_POST['rows']);
			
			$stmt->execute();
		}
		else if($_POST['category'] == 'nameLast'){

			$sql = "UPDATE logininfo SET `nameLast` = :value WHERE (`user` = :user);";
			$stmt = $conn->prepare($sql);
			// prepare sql and bind parameters

			$stmt->bindParam(":value", $_POST['term']);
			$stmt->bindParam(":user", $_POST['rows']);
			
			$stmt->execute();
		}
		echo "<h1>User " . $_POST['rows'] . " edited successfully!</h1>";
	}			  
		
}
catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}
		
	header("Location: edituser.php");

	
?>
