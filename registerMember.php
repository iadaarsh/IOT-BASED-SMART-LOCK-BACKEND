<?php
	include('dbconnect.php');
	$response = array();

	function uniqueCheck($con,$email){
		$sql = "SELECT id FROM `owner` WHERE email = '".$email."'";
		$result = mysqli_query($con,$sql);
		$value = @mysqli_num_rows($result);
		if ($value) return false;
		return true;
	}


	function verifiyKey($con,$username,$key){
		$sql = "SELECT id FROM `membercode` WHERE username = '".$username."' AND code = '".$key."'";
		$result = mysqli_query($con,$sql);
		$value = @mysqli_num_rows($result);
		if($value) {
			$deleteKey = mysqli_query($con,"
				DELETE FROM `membercode` WHERE code = '".$key."';
				");
			return true;
		}
		return false;
	}


	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(
			isset($_POST['username']) and
			isset($_POST['key']) and
			isset($_POST['name']) and
			isset($_POST['address']) and
			isset($_POST['email']) and
			isset($_POST['androidId']) and
			isset($_POST['phone']) and
			isset($_POST['password'])
		) {
			if(uniqueCheck($con,$_POST['email']) and 
				verifiyKey($con,$_POST['username'],$_POST['key'])
				){


				$ownersql = "INSERT INTO `owner` (`id`, `password`, `name`, `address`, `email`, `phone`, `android_id`, `admin`) VALUES (NULL, '".$_POST['password']."', '".$_POST['name']."', '".$_POST['address']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['androidId']."', 'N')";
				$result = mysqli_query($con,$ownersql);


				$accesssql = "INSERT INTO `access` (`email`, `username`, `enable`) VALUES ('".$_POST['email']."', '".$_POST['username']."', 'Y')";
				$result = mysqli_query($con,$accesssql);


				$response['error'] = false;
				$response['message'] = "Member registered.";

			} else {
				$response['error'] = true;
				$response['message'] = "Email ID already inside or you key is expired!!";
			}
		} else {
			$response['error'] = true;
			$response['message'] = "Attribute is missing !";
		}
	}else{
		$response['error'] = true;
		$response['message'] = "Invalid Request";
	}

	echo json_encode($response);
?>