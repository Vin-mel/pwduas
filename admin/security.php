<?php
session_start();

$username = $_SESSION["username"];

if($username == ""){
    header("Location: ../login.php");
    exit();
}

?>
