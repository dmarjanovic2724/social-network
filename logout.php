<?php
session_start();
if(isset($_SESSION['id'])){
//erese session if exists
$_SESSION =array(); //sesion_unset()
session_destroy();
}

header('Location:index.php');