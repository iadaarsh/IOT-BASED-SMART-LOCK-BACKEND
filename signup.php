<?php
//signup or register for a lock.

//connection DB
include('dbconnect.php');

//array for encoding data to JSON.
$response = array();



function initTokenList($con,$username,$androidId,$email){
	$sql = "INSERT INTO `tokenList` (`androidId`, `username`, `email`, `token`) VALUES ('".$androidId."', '".$username."', '".$email."', '');";
	$result = mysqli_query($con,$sql);
}

//check for existing username and email.
function isUserExist($con,$email,$username){
	$result = mysqli_query($con,"SELECT id FROM owner WHERE username= '".$username."' OR email= '".$email."'");
	$value = @mysqli_num_rows($result);
	// echo $value;
	if ($value){
		return 0;
	}else{
		return 1;
	}
}

//check for existing android ID and lock MAC.
function isDeviceExist($con,$androidId,$lockMac){
	$result = mysqli_query($con,"SELECT id FROM device WHERE androidId = '".$androidId."' OR lockMac = '".$lockMac."'");
	$value = @mysqli_num_rows($result);

	if ($value){
		return 0;
	}else{
		return 1;
	}
}

//server request method.
if ($_SERVER['REQUEST_METHOD'] == 'POST'){



//checking for not null value.
	if(
		isset($_POST['username']) and
		 isset($_POST['password']) and
		  isset($_POST['name']) and
		   isset($_POST['address']) and
		    isset($_POST['email']) and
		      isset($_POST['phone']) and
		      	isset($_POST['androidId']) and
		      	  isset($_POST['lockMac'])
		) {



		// echo $_POST['username'];
		// echo $_POST['password'];
		// echo $_POST['name'];
		// echo $_POST['email'];
		// echo $_POST['phone'];
		// echo $_POST['androidId'];
		// echo $_POST['lockMac'];


//verifying email username android ID and Lock MAC.
		if (isUserExist($con,$_POST['email'], $_POST['username']) and isDeviceExist($con,$_POST['androidId'], $_POST['lockMac']) ){
			
			//inserting owner details to owner table. 
			$resultOwner = mysqli_query($con,
				"INSERT INTO `owner` 
				(`id`, `username`, `password`, `name`, `address`, `email`, `phone`) 
				VALUES 
				(NULL, '".$_POST['username']."',
				 '".$_POST['password']."',
				  '".$_POST['name']."',
				   '".$_POST['address']."',
				    '".$_POST['email']."',
				     '".$_POST['phone']."'
				     );");

			//inserting device details into device table.
			$resultDevice = mysqli_query($con,"
				INSERT INTO `device` 
				(`id`, `username`, `androidId`, `lockMac`) 
				VALUES 
				(NULL, '".$_POST['username']."', '".$_POST['androidId']."', '".$_POST['lockMac']."');
				");

			
			initTokenList($con,$_POST['username'],$_POST['androidId'],$_POST['email']);

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
	$response['error'] = false;
	$response['message'] = "Invalid Request";
}

//encoding array to JSON format for sending for devices.
echo json_encode($response);

?>