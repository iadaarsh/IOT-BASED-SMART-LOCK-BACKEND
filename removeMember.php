<?php
	include('dbconnect.php');
	$response = array();


	function checkAdmin($con,$username,$andoridId){
		$sql = "SELECT * FROM `owner`, `access` WHERE owner.android_id = '".$andoridId."' AND admin = 'Y' AND owner.email = access.email AND access.username = '".$username."'";
		$result = mysqli_query($con,$sql);
		$value = @mysqli_num_rows($result);
		if ($value){
			return true;
		}else{
			return false;
		}

	}


	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(
			isset($_POST['email']) and
			isset($_POST['username']) and
			isset($_POST['operation']) and
			isset($_POST['androidId'])
		){
			if(checkAdmin($con,$_POST['username'],$_POST['androidId'])){
				
				if($_POST['operation'] == "remove"){
					$sql = "UPDATE `access` SET `enable` = 'N' WHERE `access`.`email` = '".$_POST['email']."' AND `access`.`username` = '".$_POST['username']."'";

					$result = mysqli_query($con,$sql);

					$response['error'] = false;
					$response['message'] = "Removed!";
				}

				if($_POST['operation'] == "add"){
					$sql = "UPDATE `access` SET `enable` = 'Y' WHERE `access`.`email` = '".$_POST['email']."' AND `access`.`username` = '".$_POST['username']."'";
					
					$result = mysqli_query($con,$sql);

					$response['error'] = false;
					$response['message'] = "Added!";
				}

			} else {
				$response['error'] = true;
				$response['message'] = "Permission Deny!";
			}

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