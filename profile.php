<?php

require_once "header.php";
require_once "conn.php";

if(isset($_GET['user_id'])){
    
    $userID=$_GET['user_id'];

    $sql="SELECT profiles.name, profiles.surname, profiles.user_id, profiles.gender, profiles.bio, users.username
    FROM profiles
    INNER JOIN users
    ON users.id=profiles.user_id
    WHERE profiles.user_id = $userID";
    
    $result=$conn->query($sql);

    
    if($result->num_rows ==0){

        echo "<p id='wrongP' class='display-6  text-white'>no users</p>";
    }else{
        $row=$result->fetch_assoc();
        
        echo '<div class="container py-5">';
        echo '<div class="row d-flex justify-content-center py-5">';
        
            
            if($row['gender']=='m'){
                $color='white';
            }elseif($row['gender']=='f'){
                $color='danger';
            }else{
                $color='dark';
            }
            echo"<h3 class='text-center text-white'>Hello ".$row['name']." ".$row['surname']."</h3>";
           
            echo"<table  class=' d-flex justify-content-center table table-bordered  table-sm text-white w-auto'>";
            echo"<tr><th>Name</th><td class='text-$color'>".$row['name']."</td>";
            echo"<tr><th>Surname</th><td class='text-$color'>".$row['surname']."</td>";
            echo"<tr><th>Username</th><td class='text-$color'>".$row['username']."</td>";
            echo"<tr><th>Gender</th><td class='text-$color'>".$row['gender']."</td>";
            echo"<tr><th>Bio</th><td class='text-$color'>".$row['bio']."</td>";
            echo"</table>";    
    }
 
}

echo '</div>';
echo '</div>';echo '<a class="btn btn-primary" href="followers.php" role="button">go back</a>';
