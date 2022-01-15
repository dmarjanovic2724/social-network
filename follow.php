<?php
session_start();
require_once "conn.php";

$id=$_SESSION['id']; //Logged User

if(!empty($_GET['friend_id'])){
$friendsId=$conn->real_escape_string($_GET['friend_id']);

$sql="SELECT * FROM followers
WHERE sender_id = $id
AND receiver_id=$friendsId";

$rezultat = $conn->query($sql);

if($rezultat->num_rows ==0){
    $sql="INSERT INTO followers(sender_id, receiver_id)
    VALUE ($id, $friendsId)";
}
$rezultat1=$conn->query(($sql));

if(!$rezultat1){
    die("Greska:" . $conn->error);
}
}
header("Location: followers.php");
