<?php
	
	include('dbconnect.php');
	$response = array();

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['username'])){

			$sql = "SELECT * FROM `memberDetails` WHERE username = '".$_POST['username']."';";
			$result = mysqli_query($con,$sql);

			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				array_push($response,
					array(
						"name"=>$row['name'],
						"email"=>$row['email']
				)
				);
			}
		}
	}

	echo json_encode($response);


?>