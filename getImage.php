<?php

	$con = mysqli_connect("localhost", "root", "", "lockdb");
	
	if (!$con) {
	    echo "Error: Unable to connect to MySQL." . PHP_EOL;
	    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	    exit;
	}


	if($_SERVER['REQUEST_METHOD'] == 'GET') {

		// if ( isset($_POST['imageId']) ){


		$id = $_GET['imageId'];


		$sql = "SELECT path FROM `imageBackup` WHERE id = '$id'";
		
		$result = mysqli_query($con,$sql);
		$value = @mysqli_num_rows($result);

		if ($value){
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$path = $row['path'];
			// echo $path;

			$image = file_get_contents($path);

			header('Content-Type: image/png');

			echo base64_decode($image);

		}

		// } else {
			// $image = file_get_contents('wrongInput');
			// header('Content-Type: image/png');
			// echo base64_decode($image);
		// }	

	} else {
		$image = file_get_contents('wrongInput');
		header('Content-Type: image/png');
		echo base64_decode($image);
	}
?>