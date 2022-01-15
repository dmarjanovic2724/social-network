<?php

require_once "conn.php";

$tabele="CREATE TABLE IF NOT EXISTS users(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    pass VARCHAR(255) NOT NULL)
    ENGINE = InnoDB;";

$tabele.="CREATE TABLE IF NOT EXISTS profiles(
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    gander CHAR(1),
    dob DATE,    
    user_id INT UNSIGNED,
    FOREIGN KEY(user_id) REFERENCES users(id))
    ENGINE = InnoDB;";


$tabele.="CREATE TABLE IF NOT EXISTS followers(
    id INT UNSIGNED PRIMARY KEY  AUTO_INCREMENT,
    sender_id INT UNSIGNED NOT NULL,
    receiver_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(sender_id) REFERENCES users(id),
    FOREIGN KEY(receiver_id) REFERENCES users(id))
    ENGINE = InnoDB;";



$rezultat=$conn->multi_query($tabele);

if($rezultat){
    echo "Successfully";
    }
    else{
    echo "Fail, something went wrong".$conn->error;
    } 




?>