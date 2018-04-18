<?php
//update android id.

//connecting DB
include('dbconnect.php');
//array for encoding data to JSON.
$response = array();

//verifying username and password.
function verifyUser($con,$username,$password){
	$result = mysqli_query($con,"SELECT id FROM owner WHERE username = '".$username."' AND password = '".$password."'");
	$value = @mysqli_num_rows($result);

	if ($value){
		return 1;
	}else{
		return 0;
	}
}

function updateTokenTable($con,$androidId,$email,$token){
	$sql1 = "UPDATE tokenlist SET androidId = '".$androidId."' WHERE email = '".$email."'";
	$sql2 = "UPDATE tokenlist SET token = '".$token."' WHERE email = '".$email."'";
	$result1 = mysqli_query($con,$sql1);
	$result2 = mysqli_query($con,$sql2);

	if ($result1 and $result2) return true;
	return false;
}

//server request method.
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	//checking for not null value.
	if(
		isset($_POST['username']) and
		 isset($_POST['password']) and
		   isset($_POST['androidId']) and
		    isset($_POST['email']) and
		     isset($_POST['token'])
		) {

		//verifying username and password.
		if (verifyUser($con,$_POST['username'], $_POST['password']) and updateTokenTable($con,$_POST['androidId'],$_POST['email'],$_POST['token'])){
			
			//query to cnage android ID.
			$chageAndoridId = mysqli_query($con,"
				UPDATE device SET androidId = '".$_POST['androidId']."' WHERE username = '".$_POST['username']."'
				");

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