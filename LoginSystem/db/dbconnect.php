<?php
$host = 'localhost';
$user = 'root';
$password = "root";
$dbname = "login_users_10";
$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    echo "FAILD TO CONNECT";
}
