<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "bi_librarysystem";
$conn = mysqli_connect($host, $user, $pass, $dbname);
if(!$conn){
    echo "Error connecting with DB";
}
?>