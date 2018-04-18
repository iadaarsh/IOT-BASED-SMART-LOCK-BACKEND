<?php

$image = file_get_contents("C:/Users/Suvam Basak/imgCL1");
header('Content-Type: image/png');
echo base64_decode($image);

// echo $image;
?>