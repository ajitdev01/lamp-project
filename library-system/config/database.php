<?php
// db.php

$host     = "localhost";
$username = "root";
$password = "root";
$database = "library_db";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");
