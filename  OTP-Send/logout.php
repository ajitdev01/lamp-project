<?php
session_start();

$_SESSION = [];        // remove all session variables
session_destroy();     // destroy the session

header("Location: index.php");
exit();
?>