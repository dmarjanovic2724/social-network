<?php
require_once "conn.php";
require "header.php";

$idSes=$_SESSION['id'];

$succes="";
$error="";
$oldPasswordErr="";
$oldpassword = $newPassword = $repassword = "";
$passwordErr = $repasswordErr = "";

$sql="SELECT pass FROM users
WHERE id = $idSes";

$result=$conn->query($sql);

if($result){
    $row=$result->fetch_assoc();
    $oldpassword=$row['pass'];
}else{
   echo "Error: " . $conn->error;
} 
  

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $validated = false;
//old password validation
        $oldPassCheck=md5($_POST['oldpassword']);
        if($oldpassword !=$oldPassCheck){
            $validated = true;
            $oldPasswordErr=" don't match";           
        }     

//New password

    if(empty($_POST['newPassword'])){
        $validated=true;
        $passwordErr="enter a password";
    }elseif(strpos($_POST["newPassword"], ' ') !== false){
        $validated=true;
        $passwordErr = "password can't contain whitespace";
    }elseif(strlen($_POST['newPassword']) < 5 || strlen($_POST['newPassword']) > 25){
        $validated=true;
        $passwordErr = "password must be between 5 and 50 characters";
    }elseif($_POST['newPassword']== $_POST['repassword']){
        $newPassword=$_POST['newPassword'];
    }else{
        $validated=true;
        $passwordErr="The password don't match";
        $repasswordErr="The password don't match";
    }     


//re-password
    if(empty($_POST['repassword'])){
        $validated=true;
        $repasswordErr="enter a retype password";
    }else{
        $repassword=$_POST['repassword'];
    }   
    
    if($validated ==false){
        $newPass = $conn->real_escape_string($newPassword); 
        $newPassword=md5($newPass);
        $sqlUpdate="UPDATE users SET pass='$newPassword'
        WHERE id = $idSes";
        $result=$conn->query($sqlUpdate);
         $succes="You have successfully update your password!";   
                  
    }else{
       $error="failed";
    }
}    
?>
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-5 col-sm-12">
                <form action="#" method="POST">
                    <fieldset class="mt-5">
                        <legend class="text-center text-white">Change password</legend>
                    
                        <p>
                        <input class=" form-control text-center  bg-primary" placeholder="Old password" type="password" name="oldpassword" ><span class="text-danger "><?php echo $oldPasswordErr ?>*</span>
                        </p>
                        <p>
                        <input class=" form-control text-center  bg-primary" placeholder="New password" type="password" name="newPassword" ><span class="text-danger "><?php echo $passwordErr ?>*</span>
                        </p>
                        <p>
                        <input class=" form-control text-center  bg-primary" placeholder="Re-type new password" type="password" name="repassword"><span class="text-danger ">*<?php echo $repasswordErr ?></span>
                        </p>              
                        
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