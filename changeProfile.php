<?php
require_once "conn.php";
require "header.php";
$idSes=$_SESSION['id'];
$succes="";
$error="";
$name = $surname = $gender = $dob = "";
    $nameErr = $surnameErr = $genderErr = $birthErr = "";

$sql="SELECT * FROM profiles
WHERE user_id = $idSes";
$result=$conn->query($sql);


    if($result->num_rows == 0){
        $usernameErr="data doesn't exist!";
    }else{
        //old data from db
        $row=$result->fetch_assoc();
        $nameb = $row['name'];
        $surnameb=$row['surname'];
        $genderb=$row['gender'];
        $dobb=$row['dob'];
        $biob=$row['bio'];
       
    }
  
    if($_SERVER["REQUEST_METHOD"]=="POST"){

        $validated = false;
        //name                     
            if(ctype_alpha(str_replace(' ', '', $_POST['name'])) === false || (empty($_POST['name'])) ){
                $validated=true;
                $nameErr = "Name must contain leters and spaces only";
            }
            elseif(strlen($_POST['name']) > 50){
                $validated=true;
                $nameErr = "Name must be smaller than 50 characters";
            }
            else{
                $name = preg_replace('/\t|\s{2,}/', ' ', $_POST["name"]);
            }
        //surename
            if(ctype_alpha(str_replace(' ', '', $_POST['surname'])) === false || (empty($_POST['surname'])) ){
                $validated=true;
                $surnameErr = "surname must contain leters and spaces only";                
            }
            elseif(strlen($_POST['surname']) > 50){
                $validated=true;
                $surnameErr = "surname must be smaller than 50 characters";                
            }
            else{
                $surname = preg_replace('/\t|\s{2,}/', ' ', $_POST["surname"]);
            }
        //date of birth
            if(empty($_POST['dob'])){
                $validated=true;
                $birthErr="insert date of birth";
            }elseif($_POST['dob'] <= "1900-01-01"){
                $validated=true;
                $birthErr="date cannot be below 1900";
            }else{
                $dob=$_POST['dob'];
            }
        //gender
            $gender=$_POST['gender'];

        //bio
            $bio=$_POST['bio'];

        if($validated==false){
            $name=$conn->real_escape_string($name);
            $surname = $conn->real_escape_string($surname);
            $bio=$conn->real_escape_string($bio);
           
            
            $sqlUpdate="UPDATE profiles SET name='$name', surname='$surname', gender='$gender', dob='$dob', bio='$bio'
            WHERE user_id = $idSes";
            $result=$conn->query($sqlUpdate);
                $succes="You have successfully update profile!";

                $sql="SELECT CONCAT(profiles.name, ' ',profiles.surname) as 'full_name'
                FROM users
                INNER JOIN profiles
                ON users.id=profiles.user_id
                WHERE user_id=$idSes";
    
                $result=$conn->query($sql);
                $row=$result->fetch_assoc();
                $_SESSION['full_name']=$row['full_name'];           
                       
        }else{
            $error= "failed";
        }
}    
       
        
?>        
        <div class="container py-5">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-5 col-lg-5 col-md-8 col-sm-12">
                    <form action="#" method="POST">
                        <fieldset class="mt-5">
                            <legend class="text-center text-white">Change profile information</legend>
                            <p>
                            
                            <input class=" form-control text-center bg-primary" placeholder="name" type="text" name="name" value="<?php echo $nameb; ?>"><span class="text-danger">*<?php echo $nameErr ?></span>
                            </p>
                            <p>
                            <input class=" form-control text-center bg-primary" placeholder="surname" type="text" name="surname" value="<?php echo $surnameb ?>"><span class="text-danger ">*<?php echo $surnameErr ?></span>
                            </p>
                            <p>               
                            
                            
                            <p class="text-center">
                            <label class="text-primary text-center">Date of birth</label>
                            <input class=" form-control text-center  bg-primary" type="date" min="1900-01-01" name="dob" value="<?php echo $dobb;?>"><span class="text-danger ">*<?php echo $birthErr ?></span>
                            </p>
                            <p class="text-center">
                            <label class="text-primary font-weight-bold">Gender</label><br>
                            <?php
                            if($genderb=='m'){
                                echo '<input type="radio" name="gender" id=""value="m" checked>male';
                                echo '<input type="radio"  name="gender" id="" value="f">female';
                                echo '<input type="radio"  name="gender" id="" value="o" >other';
                            }elseif($genderb=='f'){
                                echo '<input type="radio" name="gender" id=""value="m" >male';
                                echo '<input type="radio"  name="gender" id="" value="f" checked>female';
                                echo '<input type="radio"  name="gender" id="" value="o" >other';
                            }else{
                                echo '<input type="radio" name="gender" id=""value="m" >male';
                                echo '<input type="radio"  name="gender" id="" value="f" >female';
                                echo '<input type="radio"  name="gender" id="" value="o" checked>other';
                            }
                            ?>          
                            </p>
                            <label class="text-primary">Bio:</label>
                            <textarea cols="30" name="bio" ><?php echo $biob?></textarea>

                            <p>
                            <input class="form-control text-center btn btn-primary" type="submit" name="submit" value="Confirm">
                            </p>
                            <?php echo "<p class='text-danger'>$succes</p>";
                                echo "<p class='text-danger'>$error</p>";
                            ?>

                           
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>        
    </body>
</html> 