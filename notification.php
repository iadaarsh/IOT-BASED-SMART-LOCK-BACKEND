<?php
	include('dbconnect.php');
	$response = array();



	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(
			isset($_POST['username']) and
			isset($_POST['email']) and
			isset($_POST['androidId'])
		){
			
			$sql = "SELECT notification.id, notification.username, notification.email, notification.notifyText, notification.imageId FROM `notification`, `access`, `owner` WHERE owner.email = '".$_POST['email']."' AND owner.android_id = '".$_POST['androidId']."' AND access.username = '".$_POST['username']."' AND access.username = notification.username AND access.email = owner.email AND owner.email = notification.email";
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