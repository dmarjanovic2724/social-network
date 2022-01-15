<?php

require_once "conn.php";

$sql="ALTER TABLE profiles
ADD bio TEXT(600);";

$rezultat=$conn->query($sql);


if($rezultat){
    echo "Uspesno izvrsen niz upita";
    }
    else{
    echo "Greska prilikom izvrsenja niza upita ".$conn->error;
    } 

