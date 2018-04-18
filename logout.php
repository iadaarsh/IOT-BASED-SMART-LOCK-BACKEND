<?php

include('dbconnect.php');

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if (isset($_POST['email'])){

		$sql = "DELETE FROM `tokenlist` WHERE `tokenlist`.`email` = '".$_POST['email']."'";
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