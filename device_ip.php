<?php
	
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$info = $_GET['info'];

	echo $info;

	$textfile = fopen("network_config.txt", "w") or die("Unable to open file!");
	fwrite($textfile, $info);
	fclose($textfile);

	echo '   Done';
}

?>