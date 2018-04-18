<?php
//login and singin for lock.

//connecting DB
include('dbconnect.php');

//array for encoding data to JSON.
$response = array();

// function for update notification token.
function updateToken($con, $token, $email){
	$sql = "UPDATE `tokenlist` SET token = '".$token."' WHERE email = '".$email."'";
	$result = mysqli_query($con,$sql);
}


//server request method.
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	//checking for not null value.
	if(
		isset($_POST['username']) and
		 isset($_POST['password']) and 
		  isset($_POST['token'])
		   ) {

		//query for checking username and password.
		$sql = "SELECT * FROM owner WHERE username = '".$_POST['username']."' AND password ='".$_POST['password']."'";

		//executing query,
		$result = mysqli_query($con,$sql);
		//fetching reqults.
		$value = @mysqli_num_rows($result);

		//when username and password is valid.
		if ($value){
			//fetching info.
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

			//updating token.
			updateToken($con,$_POST['token'],$row['email']);

			//creating reply.
			$response['error'] = false;
			$response['message'] = "Login successfull";
			
			//$response['id'] = $row['id'];
			$response['name'] = $row['name'];
			$response['username'] = $row['username'];
			$response['email'] = $row['email'];

		}else{

			//reply when username and password is not valid.
			$response['error'] = true;
			$response['message'] = "Incorrect username and password";
		}

	}else{

		//when username and password is null.
		$response['error'] = true;
		$response['message'] = "Incorrect usernamename and password";
	}
}else{
	
	//when request method is not POST
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

//encoding array to JSON format for sending for devices.
echo json_encode($response);
?>