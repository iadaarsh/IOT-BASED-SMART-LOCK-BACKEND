<?php
//login and singin for lock.

//connecting DB
include('dbconnect.php');

//array for encoding data to JSON.
$response = array();


//check for existing username and email.
function isUserExist($con,$androidId,$username){
	$result = mysqli_query($con,"SELECT id FROM device WHERE username = '".$username."' AND androidId = ".$androidId."'");
	$value = @mysqli_num_rows($result);

	if ($value){
		return 0;
	}else{
		return 1;
	}
}


//server request method.
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	//checking for not null value.
	if(
		isset($_POST['username']) and
		isset($_POST['androidId']) ) {


		if (isUserExist($con,$_POST['androidId'],$_POST['username'])){
			//query for checking username and password.
			$sql = "SELECT * FROM onlineList WHERE username = '".$_POST['username']."'";

			//executing query,
			$result = mysqli_query($con,$sql);
			//fetching reqults.
			$value = @mysqli_num_rows($result);

			//when username and password is valid.
			if ($value){
				//fetching info.
				//$row = mysqli_fetch_array($result, MYSQLI_ASSOC);


				//creating reply.
				$response['error'] = false;
				$response['message'] = "Found";
				
				//$response['id'] = $row['id'];
				$response['status'] = "Online";


			}else{

				//reply when username and password is not valid.
				$response['error'] = true;
				$response['message'] = "Not Found";
				$response['status'] = "Offline";
			}
		}

	}else{

		//when username and android is null.
		$response['error'] = true;
		$response['message'] = "username and android ID not found";
	}
}else{
	
	//when request method is not POST
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

//encoding array to JSON format for sending for devices.
echo json_encode($response);
?>