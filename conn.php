<?php

$servername = "localhost";
$uname = "admin";
$pbaza="admin123";
$db="mreza";


$conn = new mysqli($servername, $uname, $pbaza, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>