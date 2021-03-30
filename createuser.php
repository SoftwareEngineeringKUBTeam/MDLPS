<?php

require_once("functions.php"); // used to access notifyStudent function

//require user to be logged in before using this
session_start();
checkLogin();
	



try{
	$conn = dbConnect();
	// search student db for record of student and retrieve email and other residential information
	$sql = "INSERT INTO logininfo (`user`, `pass`, `accessLevel`, `nameFirst`, `nameLast`) VALUES (:User, :Passwd, :Position, :nameFirst, :nameLast);"; 
	$stmt = $conn->prepare($sql);
	// prepare sql and bind parameters
	
	$passhash = password_hash($_POST['Passwd'], PASSWORD_DEFAULT);
	
	$stmt->bindParam(":User", $_POST['User']);
	$stmt->bindParam(":Passwd", $passhash);
	$stmt->bindParam(":Position", $_POST['Position']);
	$stmt->bindParam(":nameFirst", $_POST['nameFirst']);
	$stmt->bindParam(":nameLast", $_POST['nameLast']);
	
	$stmt->execute();
					  
	//$return = $search->fetchall(PDO::FETCH_ASSOC);
				
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	header("url=admin.php");
	
	
?>

