<?php
//signup or register for a lock.

//connection DB
include('dbconnect.php');

//array for encoding data to JSON.
$response = array();


//check for existing username and email.
function isUserExist($con,$email){
	$sql = "SELECT id FROM owner WHERE email= '".$email."'";
	$result = mysqli_query($con,$sql);
	$value = @mysqli_num_rows($result);
	// echo $value;
	if ($value){
		return 0;
	}else{
		return 1;
	}
}

function auth($con,$email,$username){
	$sql = "SELECT id FROM `device` WHERE owner_email = '".$email."' AND username = '".$username."'";
	$result = mysqli_query($con,$sql);
	$value = @mysqli_num_rows($result);
	// echo $value;
	if ($value){
		return 1;
	}else{
		return 0;
	}	
}


function addAccess($con,$email,$username){
	$sqlAccess = "INSERT INTO `access` (`email`, `username`, `enable`) VALUES ('".$email."', '".$username."', 'Y');";
	$resultOwner = mysqli_query($con,$sqlAccess);
}


//server request method.
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

//checking for not null value.
	if(	isset($_POST['username']) and
		isset($_POST['password']) and
		isset($_POST['name']) and
		isset($_POST['address']) and
		isset($_POST['email']) and
		isset($_POST['phone']) and
		isset($_POST['androidId'])
		) {



		// echo $_POST['username'];
		// echo $_POST['password'];
		// echo $_POST['name'];
		// echo $_POST['email'];
		// echo $_POST['phone'];
		// echo $_POST['androidId'];
		// echo $_POST['lockMac'];

		if (isUserExist($con,$_POST['email']) and auth($con,$_POST['email'],$_POST['username'])){
			
			$sql = "INSERT INTO `owner` (`id`, `password`, `name`, `address`, `email`, `phone`, `android_id`, `admin`) VALUES (NULL, '".$_POST['password']."', '".$_POST['name']."', '".$_POST['address']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['androidId']."', 'Y');";

			$resultOwner = mysqli_query($con,$sql);

			addAccess($con,$_POST['email'],$_POST['username']);

			//creating reply.
			$response['error'] = false;
			$response['message'] = "Successfull";

			// $response['username'] = $_POST['username'];
			// $response['password'] = $_POST['password'];
			// $response['name'] = $_POST['name'];
			// $response['address'] = $_POST['address'];
			// $response['email'] = $_POST['email'];
			// $response['phone'] = $_POST['phone'];

		}else{
			//when username or email or lock MAC or android ID already exist.
			$response['error'] = true;
			$response['message'] = "already exist";
		}
	}else{
		//when some value null.
		$response['error'] = true;
		$response['message'] = "Missing";
	}
}else{

	//when request is not POST.
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

//encoding array to JSON format for sending for devices.
echo json_encode($response);

?>