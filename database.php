<?php
$hostname = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "online_university";

$conn = mysqli_connect($hostname, $dbuser, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>