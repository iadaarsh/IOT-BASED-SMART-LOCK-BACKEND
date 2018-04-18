<?php
//login and singin for lock.

//connecting DB
include('dbconnect.php');

//array for encoding data to JSON.
$response = array();


function getUsername($con, $email){
	$sqlforuser = "SELECT username FROM `access` WHERE email = '".$email."'";
	$result = mysqli_query($con,$sqlforuser);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	return $row['username'];

}

function clearOld($con, $email){
	$sqlclear = "DELETE FROM `tokenlist` WHERE `tokenlist`.`email` = '".$email."'";
	$result = mysqli_query($con,$sqlclear);
}


//server request method.
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	//checking for not null value.
	if(	isset($_POST['email']) and
		isset($_POST['token'])
		) {

		clearOld($con,$_POST['email']);

		$username = getUsername($con,$_POST['email']);

		//query for checking username and password.
		$sql = "INSERT INTO `tokenlist` (`username`, `email`, `token`) VALUES ('".$username."', '".$_POST['email']."', '".$_POST['token']."')";

		//executing query,
		$result = mysqli_query($con,$sql);

		$response['error'] = false;
		$response['message'] = "Token successfully Updated";

	}else{
		//when username and password is null.
		$response['error'] = true;
		$response['message'] = "Invalid Request";
	}
}else{
	//when request method is not POST
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

//encoding array to JSON format for sending for devices.
echo json_encode($response);
?>