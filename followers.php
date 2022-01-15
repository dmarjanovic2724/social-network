
<?php
require "header.php";
require_once "conn.php";

if(empty($_SESSION['id'])){
    header("Location: login.php");
}
$id=$_SESSION['id'];
//follow
if(!empty($_GET['follow'])){
    $friendsId=$conn->real_escape_string($_GET['follow']);
    
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
        echo "<div>error" .$conn->error."</div>";
    }
}

//unfollow

if(!empty($_GET['unfollow'])){
    $friendsId=$conn->real_escape_string($_GET['unfollow']);
    
    $sql="DELETE FROM followers
    WHERE sender_id = $id
    AND receiver_id=$friendsId";
    
    $rezultat = $conn->query($sql);
    
    
    //class error
    if(!$rezultat){
        echo "<div>error" .$conn->error."</div>";
    }
    
    }

$query=$_GET['query'];

//
$sql="SELECT CONCAT(profiles.name,' ', profiles.surname) AS 'name_surname', users.username, users.id
FROM profiles
INNER JOIN users
ON profiles.user_id=users.id
WHERE users.id != '$id'";

$rezultat=$conn->query($sql);

echo '<div class="container py-5">';
echo '<div class="row d-flex justify-content-center py-5">';


        if($rezultat->num_rows){
        
            echo "<table class=' table table-striped table-primary myDIV  w-auto'>";
            echo "<thead>";
            echo "  <tr> 
                    <th scope='col'>name and surename</th>             
                    <th scope='col'> username </th>
                    <th scope='col'> action </th> 
                    </tr> "; 
                    echo "</thead>";
                    echo "<tbody>";
            foreach($rezultat as $row) { 
                $friendId= $row['id'];
                echo "<tr class='zoom'>"; 


                echo "<td><a href='profile.php?user_id=$friendId'>" . $row['name_surname']."</a></td>";        
                echo "<td>" . $row['username'] . "</td>";

                //check if i follow the friend
                $sql1 ="SELECT * FROM followers
                WHERE sender_id = $id
                AND receiver_id =$friendId";
                $result1=$conn->query($sql1);
                $f1 = $result1->num_rows; // 0 ili 1 

                //check if friend follow me
                $sql2="SELECT * FROM followers
                WHERE sender_id = $friendId
                AND receiver_id = $id";

                $result2=$conn->query($sql2);
                $f2=$result2->num_rows; // 0 ili 1

                if($f1 ==0){
                    if($f2==0){
                        $text="Follow";
                    }else{
                        $text="Follow back";
                    }
                    echo "<td><a href='followers.php?follow=$friendId'>$text</a></td>";
                    
                }else{
                    echo "<td><a href='followers.php?unfollow=$friendId'>Unfollow</a></td>";  
                }              
                echo "</tr>";                 
            } 
            echo "</tbody>";
            echo "</table>"; 
        }else{
            echo "<p>No users in database</p>";
            }

echo '</div>';
echo '</div>';


?>


</body>
</html>
