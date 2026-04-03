<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "result_system_db";
$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    echo "Error connecting with DB";
}
