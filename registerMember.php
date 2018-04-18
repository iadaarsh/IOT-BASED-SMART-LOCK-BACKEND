<?php
	include('dbconnect.php');
	$response = array();

	function uniqueCheck($con,$email){
		$sql = "SELECT id FROM `memberDetails` WHERE email = '".$email."'";
		$result = mysqli_query($con,$sql);
		$value = @mysqli_num_rows($result);
		if ($value) return false;
		return true;
	}


	function verifiyKey($con,$username,$key){
		$sql = "SELECT * FROM `memberCode` WHERE username = '".$username."' AND code = '".$key."'";
		$result = mysqli_query($con,$sql);
		$value = @mysqli_num_rows($result);
		if($value) {
			$deleteKey = mysqli_query($con,"
				DELETE FROM `memberCode` WHERE code = '".$key."';
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
			isset($_POST['token']) and
			isset($_POST['phone'])
		) {
			if(uniqueCheck($con,$_POST['email']) and 
				verifiyKey($con,$_POST['username'],$_POST['key'])
				){

				$sql = "INSERT INTO `memberDetails` (`id`, `username`, `androidId`, `name`, `address`, `email`, `phone`) VALUES (NULL, '".$_POST['username']."', '".$_POST['androidId']."', '".$_POST['name']."', '".$_POST['address']."', '".$_POST['email']."', '".$_POST['phone']."');";
				$result = mysqli_query($con,$sql);

				$sql = "INSERT INTO `tokenList` (`androidId`, `username`, `email`, `token`) VALUES ('".$_POST['androidId']."', '".$_POST['username']."', '".$_POST['email']."', '".$_POST['token']."');";

				$result = mysqli_query($con,$sql);

				$response['error'] = false;
				$response['message'] = "Member registered.";

			} else {
				$response['error'] = true;
				$response['message'] = "Email ID alread inside or you key is expired!!";
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