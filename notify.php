<?php

include('dbconnect.php');

function notify($token, $msg) {

	// FIREBASE_SERVER_KEY_FOR_ANDROID_NOTIFICATION
	$headers = array(
	'Authorization: key=AAAApilIbBE:APA91bFVdbnfXnv-nckUGxTcUsfuj66PA_w44ouE2o5ninbJDlQW6_-SHMY1gdza4uLad-u3Rka1_pj7W2DlwoQgFH7XMK5-3B4gRGRcnsK80ryYkzOghBdTO-FfS0kDuZNg2srSHg8G', 
	'Content-Type: application/json'
	);

	//notificaion.
	$fields = array(
		'to' =>$token,
		'data'=>array('tag'=>'onof',
					'msg'=>$msg));

	// Open connection
	$ch = curl_init();
	// Set the url, number of POST vars, POST data
	curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	// Disabling SSL Certificate support temporarly
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
	// Execute post
	$result = curl_exec($ch );
	if($result === false){
		die('Curl failed:' .curl_errno($ch));
	}
	// Close connection
	curl_close($ch);
	var_dump($result);
}

function imageNotify($token, $msg, $imgId) {

	// FIREBASE_SERVER_KEY_FOR_ANDROID_NOTIFICATION
	$headers = array(
	'Authorization: key=AAAApilIbBE:APA91bFVdbnfXnv-nckUGxTcUsfuj66PA_w44ouE2o5ninbJDlQW6_-SHMY1gdza4uLad-u3Rka1_pj7W2DlwoQgFH7XMK5-3B4gRGRcnsK80ryYkzOghBdTO-FfS0kDuZNg2srSHg8G', 
	'Content-Type: application/json'
	);

	//notificaion.
	$fields = array(
		'to' =>$token,
		'data'=>array('tag'=>'img',
					'msg'=>$msg,
					'imageId'=>$imgId,
					'filename'=>'123'));

	// Open connection
	$ch = curl_init();
	// Set the url, number of POST vars, POST data
	curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	// Disabling SSL Certificate support temporarly
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
	// Execute post
	$result = curl_exec($ch );
	if($result === false){
		die('Curl failed:' .curl_errno($ch));
	}
	// Close connection
	curl_close($ch);
	var_dump($result);
}



if($_SERVER['REQUEST_METHOD'] == 'GET') {

	$username =  $_GET['username'];
	$msg =  $_GET['msg'];
	$type = $_GET['type'];
	$imageId = $_GET['imageId'];

	echo $imageId;


	$sql = "SELECT token FROM `tokenList` WHERE username = '".$_GET['username']."'";
	$result = mysqli_query($con,$sql);

	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		if ($type == 'ONOFF'){
			notify($row['token'], $msg);
		}
		if ($type == 'IMAGE')
			imageNotify($row['token'], $msg, $imageId);
	}

} else {
	echo "Invalid URL !";
}

?>