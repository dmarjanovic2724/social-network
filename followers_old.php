<?php
require "header.php";
require_once "conn.php";


$id=$_SESSION['id'];
//
$sql="SELECT CONCAT(profiles.name,' ', profiles.surname) AS 'name_surname', users.username, users.id
FROM profiles
INNER JOIN users
ON profiles.user_id=users.id
WHERE users.id != '$id'";

$rezultat=$conn->query($sql);
echo '<div class="container py-5">';
echo '<div class="row d-flex justify-content-center">';
echo '<div class="col-xl-12 col-sm-12 py-5">';

        if($rezultat->num_rows){
        
            echo "<table class='table table-striped table-primary myDIV'>";
            echo "<thead>";
            echo "  <tr> 
                    <th scope='col'> name and surename</th>             
                    <th scope='col'> username </th>
                    <th scope='col'> action </th> 
                    </tr> "; 
                    echo "</thead>";
                    echo "<tbody>";
            foreach($rezultat as $row) { 
                echo "<tr class='zoom'>"; 
                echo "<td>" . $row['name_surname']."</td>";        
                echo "<td>" . $row['username'] . "</td>";
                $friendId= $row['id'];
                echo "<td><a href='follow.php?friend_id=$friendId'>Follow</a>  <a href='unfollow.php?friend_id=$friendId'>Unfollow</a></td>";  
                    
                echo "</tr>"; 
                
               
            
            } 
            echo "</tbody>";
            echo "</table>"; 
        }else{
            echo "<p>No users in database</p>";
            }
echo '</div>';
echo '</div>';
echo '</div>';



?>