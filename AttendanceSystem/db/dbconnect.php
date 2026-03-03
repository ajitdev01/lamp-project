<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "attendance_db";

$conn = mysqli_connect($host,$user,$password,$dbname);

if(!$conn){
    echo "Not Db Connted";
}else{
    // echo "SuccessFully Connted !";
}


?>