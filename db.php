<?php
$servername = "127.0.0.1"; // use this instead of localhost
$username = 'root';
$password = '';
$database = 'real_estate';

$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn){
    die("Failed To connnect" .mysqli_connect_error());
}
?>