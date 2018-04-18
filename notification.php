<?php
	include('dbconnect.php');
	$response = array();

	function isUserExist($con,$androidId,$username){
		$sql = "SELECT * FROM `device` WHERE username = '".$username."' AND androidId = '".$androidId."'";
		$result = mysqli_query($con,$sql);
		$valueOwner = @mysqli_num_rows($result);

		$sql = "SELECT * FROM `memberDetails` WHERE androidId = '".$androidId."' AND username = '".$username."'";
		$result = mysqli_query($con,$sql);
		$valueMember = @mysqli_num_rows($result);


		if ($valueOwner or $valueMember)
			return true;
		return false;
	}




	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(
			isset($_POST['username']) and
			isset($_POST['email']) and
			isset($_POST['androidId'])
		){
			if (isUserExist($con,$_POST['androidId'],$_POST['username'])){
				$sql = "SELECT * FROM `notification` WHERE username = '".$_POST['username']."' AND email = '".$_POST['email']."'";
				$result = mysqli_query($con,$sql);
				$value = @mysqli_num_rows($result);


				if($value){
					//fetching info.
					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

					//creating reply.
					$response['error'] = false;
					$response['message'] = "Found";
					$response['notifyText'] = $row['notifyText'];
					$response['imageId'] = $row['imageId'];

					$id = $row['id'];



					$sql = "DELETE FROM `notification` WHERE id = '$id'";
					$result = mysqli_query($con,$sql);

				}else{
					//reply when username and password is not valid.
					$response['error'] = true;
					$response['message'] = "NotFound";
				}
			}
		}else{
			$response['error'] = true;
			$response['message'] = "username and android ID not found";
		}
	}else{
		//when request method is not POST
		$response['error'] = true;
		$response['message'] = "Invalid Request";
	}

	echo json_encode($response);
?>