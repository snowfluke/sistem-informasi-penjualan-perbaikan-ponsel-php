<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

$hostname = "localhost";
$username = "root";
$password = "";
$database = "db_siponsel";

$con = mysqli_connect($hostname, $username, $password, $database) or die(mysqli_error($con));
?>