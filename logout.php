<?php

include('dbconnect.php');

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if (isset($_POST['email']) and
		isset($_POST['status']) and
		isset($_POST['username'])
	){

		if($_POST['status'] == 'ADMIN')
			$sql = "UPDATE `tokenList` SET token = 'NULL' WHERE email = '".$_POST['email']."'";
		if($_POST['status'] == 'MEMBER'){
			$memberInfoDelete = mysqli_query($con,"
				DELETE FROM `memberDetails` WHERE username = '".$_POST['username']."' AND email = '".$_POST['email']."';
				");
			
			$sql = "DELETE FROM tokenList WHERE email = '".$_POST['email']."'";
		}

		$result = mysqli_query($con,$sql);

		if ($result){
			$response['error'] = false;
			$response['message'] = "logout";
		}

	} else {
		$response['error'] = true;
		$response['message'] = "Not";
	}
} else {
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

echo json_encode($response);

?>