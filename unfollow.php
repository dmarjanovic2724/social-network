<?php
session_start();
require_once "conn.php";

$id=$_SESSION['id']; //Logged user

if(!empty($_GET['friend_id'])){
$friendsId=$conn->real_escape_string($_GET['friend_id']);

$sql="DELETE FROM followers
WHERE sender_id = $id
AND receiver_id=$friendsId";

$rezultat = $conn->query($sql);

if(!$rezultat){
    die("Greska:" . $conn->error);
}

}

header("Location: followers.php");