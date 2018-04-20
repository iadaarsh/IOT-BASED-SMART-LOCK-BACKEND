<?php

// $image = file_get_contents("C:/Users/Suvam Basak/imgCL1");
// header('Content-Type: image/png');
// echo base64_decode($image);


$sql = "SELECT token FROM `tokenlist` WHERE username = '"basak"'";
$result = mysqli_query($con,$sql);


echo "Hello";

// echo $image;
?>