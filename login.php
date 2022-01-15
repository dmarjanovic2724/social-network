<?php
//start session

session_start();

require_once "conn.php";
$usernameErr = $passwordErr = "";

if($_SERVER['REQUEST_METHOD']=='POST'){
    //user is sent data to db
$username =$conn->real_escape_string($_POST['username']);
$password =$conn->real_escape_string($_POST['password']);
$val = true;

if(empty($username)){
    $val=false;
    $usernameErr="Username cannot be left blank!";
}
if(empty($password)){
    $val=false;
    $passwordErr="Password cannot be left blank!";
}
if($val){
    //validation
    $sql="SELECT * FROM users 
    WHERE username= '$username'";
    $result=$conn->query($sql);
    if($result->num_rows == 0){
        $usernameErr="This username doesn't exist!";
    }else{
        //check password
        $row=$result->fetch_assoc();
        $dbPass = $row['pass'];
        
        if($dbPass != md5($password)){
            $passwordErr="incorrect password!";
        }
        else{
            //start loggin
            $_SESSION['id'] = $row['id'];
            
            $sql="SELECT CONCAT(profiles.name, ' ',profiles.surname) as 'full_name'
            FROM users
            INNER JOIN profiles
            ON users.id=profiles.user_id
            WHERE users.username='$username'";

            $result=$conn->query($sql);
            $row=$result->fetch_assoc();
            $_SESSION['full_name']=$row['full_name'];

            header('Location: followers.php');

        }
    }

}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="stil.css">
    <title>Login to the site!</title>
   
</head>
<body>
    

    <?php require "nav.php"; ?>
    <div class="container">
         <div class="row d-flex justify-content-center">
            <div class="col-xl-5 col-sm-12 py-5">
                     <h2 class="text-center text-white py-4 ">Log in to your account</h2>
                <form action="" method="POST">
                            
                    <fieldset>
                        <input class=" form-control text-center  bg-primary" type="text" name="username" id="username" placeholder="username"><span class="text-danger">*<?php echo $usernameErr?></span>

                        <input  class=" form-control text-center mt-4  bg-primary" type="password" name="password" id="password" placeholder="password"><span class="text-danger">*<?php echo $passwordErr?></span>

                        <input class=" form-control text-center btn btn-primary mt-4" type="submit" value="Log in!">
                    </fieldset>

                </form>

                    <img src="slike/connect.jpg" class="img-fluid " alt="Responsive image">
        
            </div>

        </div>
                      
    </div>


</body>
</html>