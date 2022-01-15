<?php
session_start();
if(isset($_SESSION['id'])){
    header('Location:followers.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>NETWORK</title>
   
</head>
<body>

<div id="main-animated">
    <div class="container-fluid">
         <div class="row d-flex justify-content-center mt-5">
             <h1 class="text-center mt-3 text-white">SOCIAL NETWORK</h1>
            <div class="offset-xl-2  col-xl-6  offset-lg-4  col-lg-8  offset-md-3  col-md-8  col-sm-8 col-xs-12 mt-5">
            <div>

            <table id="tabelaIndex">
                    <tr>                                      
                        <td class="text-white lead fw-bold  bg-dark  rounded-pill">
                            <strong>Allready have account</strong>
                        </td>
                        <td class=" bg-dark  rounded-pill text-center ">
                            <a class=" h5 text-decoration-none" href="login.php">Log in</a>
                        </td>                       
                    </tr>
                    
                    <tr>
                        <td class="text-white lead fw-bold  bg-dark  rounded-pill text-center">
                         <strong>Become part of the network</strong>
                        </td>
                        <td class=" bg-dark  rounded-pill ">
                             <a class="h5 text-decoration-none " href="register.php">Register</a>
                        </td>
                    </tr>
            </table>
            </div>
    
            </div>
    
         </div>
    
    </div>
</div>
</body>
</html>