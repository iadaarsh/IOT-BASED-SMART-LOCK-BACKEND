<?php
//update android id.

//connecting DB
include('dbconnect.php');
//array for encoding data to JSON.
$response = array();

//verifying username and password.
function verifyUser($con,$email,$password){
	$result = mysqli_query($con,"SELECT id FROM owner WHERE email = '".$email."' AND password = '".$password."'");
	$value = @mysqli_num_rows($result);

	if ($value){
		return true;
	}else{
		return false;
	}
}

//server request method.
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	//checking for not null value.
	if(	isset($_POST['password']) and
		isset($_POST['androidId']) and
		isset($_POST['email'])
		) {

		//verifying username and password.
		if (verifyUser($con,$_POST['email'], $_POST['password'])){
			

			$sql = "UPDATE `owner` SET `android_id` = '".$_POST['androidId']."' WHERE `owner`.`email` = '".$_POST['email']."';";
			
			$chageAndoridId = mysqli_query($con,$sql);

			//creating reply.
			$response['error'] = false;
			$response['message'] = "Android ID updated";

			// $response['username'] = $_POST['username'];
			// $response['password'] = $_POST['password'];
			// $response['name'] = $_POST['name'];
			// $response['address'] = $_POST['address'];
			// $response['email'] = $_POST['email'];
			// $response['phone'] = $_POST['phone'];
		}else{
			//reply when username and password is invalid.
			$response['error'] = true;
			$response['message'] = "Invalid password";
		}
	}else{
		//reply when username or password is null.
		$response['error'] = true;
		$response['message'] = "Missing";
	}
}else{
	//reply when request method is POST.
	$response['error'] = false;
	$response['message'] = "Invalid Request";
}

//encoding array to JSON format for sending for devices.
echo json_encode($response);
?>