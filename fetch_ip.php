<?php

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$myfile = fopen("server_config.txt", "r") or die("Unable to open file!");
	$ip = fgets($myfile);
	fclose($myfile);

	$response['error'] = false;
	$response['message'] = $ip;
}else{
	$response['error'] = true;
	$response['message'] = "null";	
}
echo json_encode($response);
?>