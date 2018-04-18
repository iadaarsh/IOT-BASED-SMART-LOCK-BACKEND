<?php
	include('dbconnect.php');
	$response = array();

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(
			isset($_POST['email']) and
			isset($_POST['username'])
		){

			$sql = "DELETE FROM `memberDetails` WHERE email = '".$_POST['email']."' AND username = '".$_POST['username']."'";
			$result = mysqli_query($con,$sql);

			$response['error'] = false;
			$response['message'] = "Removed!";

		}else{
			$response['error'] = true;
			$response['message'] = "Invalid Request";
		}
	} else {
		$response['error'] = true;
		$response['message'] = "Invalid Request";
	}


	echo json_encode($response);
?>