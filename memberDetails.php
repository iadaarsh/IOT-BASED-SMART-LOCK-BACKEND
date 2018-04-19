<?php
	
	include('dbconnect.php');
	$response = array();

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['username'])){

			$sql = "SELECT owner.email, owner.name, access.enable FROM `access`,`owner` WHERE access.username = '".$_POST['username']."' AND access.email = owner.email AND owner.admin = 'N'";
			$result = mysqli_query($con,$sql);

			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				if ($row['enable'] == 'Y')
					$permission = "Enabled";
				else
					$permission = "Disabled";
				array_push($response,
					array(
						"name"=>$row['name'],
						"email"=>$row['email'],
						"enable"=>$permission
				)
				);
			}
		}
	}

	echo json_encode($response);


?>