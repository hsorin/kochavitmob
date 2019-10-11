<?php


$connection = mysqli_connect("localhost", "root", "");
if (!$connection){
    die("Error: Could not conect. " . mysqli_connect_error());
}
//
//if (mysqli_query($connection, "CREATE DATABASE myTest")){
//    echo "Succsess";
//} else {
//    echo "Error: " . mysqli_error();
//}


if (mysqli_query($connection, 
    "CREATE TABLE IF NOT EXISTS `myTest`.`user` (
  `username` VARCHAR(16) NOT NULL,
  `email` VARCHAR(255) NULL,
  `password` VARCHAR(32) NOT NULL,
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP);")) {
    echo "Succsess user table";
} else {
    echo "Error: " . mysqli_error();
}
  
mysqli_close($connection);
?>
