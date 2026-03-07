<?php
$host = "localhost";
$port = "8889"; // MAMP MySQL port
$user = "root";
$pass = "root"; // MAMP default MySQL password is root
$dbname = "birail_db";

$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

if (!$conn) {
    die("DB Connection Failed: " . mysqli_connect_error());
}

?>