<?php
$host = 'localhost';
$user = 'root';
$password = "";
$dbname = "revison_10";
$conn = mysqli_connect($host,$user,$password,$dbname);

if(!$conn){
    echo "FAILD TO CONNECT";
}

?>