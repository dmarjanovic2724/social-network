<?php session_start() ?>


<?php require "nav.php"; ?>
<?php
$succes = "";
$error = "";
$name = $surname = $gender = $birth = $username =  $password = $repassword = "";
$nameErr = $surnameErr = $genderErr = $birthErr = $usernameErr =  $passwordErr = $repasswordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validated = false;
    //name
    if (ctype_alpha(str_replace(' ', '', $_POST['name'])) === false || (empty($_POST['name']))) {
        $nameErr = "Name must contain leters and spaces only";
        $validated = true;
    } elseif (strlen($_POST['name']) > 50) {
        $nameErr = "Name must be smaller than 50 characters";
        $validated = true;
    } else {
        $name = preg_replace('/\t|\s{2,}/', ' ', $_POST["name"]);
    }
    //surename
    if (ctype_alpha(str_replace(' ', '', $_POST['surname'])) === false || (empty($_POST['surname']))) {
        $surnameErr = "surname must contain leters and spaces only";
        $validated = true;
    } elseif (strlen($_POST['surname']) > 50) {
        $surnameErr = "surname must be smaller than 50 characters";
        $validated = true;
    } else {
        $surname = preg_replace('/\t|\s{2,}/', ' ', $_POST["surname"]);
    }
    //date of bieth
    if (empty($_POST['birth'])) {
        $validated = true;
        $birthErr = "insert date of birth";
    } elseif ($_POST['birth'] <= "1900-01-01") {
        $validated = true;
        $birthErr = "date cannot be below 1900";
    } else {
        $birth = $_POST['birth'];
    }
    //username
    if (empty($_POST['username'])) {
        $validated = true;
        $usernameErr = "enter a username";
    } elseif (strpos($_POST["username"], ' ') !== false) {
        $validated = true;
        $usernameErr = "username cant contain whitespace";
    } elseif (strlen($_POST['username']) < 5 && strlen($_POST['username']) > 50) {
        $validated = true;
        $usernameErr = "username must be between 5 and 50 characters";
    } else {
        $username = $_POST['username'];
    }
    //password
    if (empty($_POST['password'])) {
        $validated = true;
        $passwordErr = "enter a password";
    } elseif (strpos($_POST["password"], ' ') !== false) {
        $validated = true;
        $passwordErr = "password can't contain whitespace";
    } elseif (strlen($_POST['password']) < 5 || strlen($_POST['password']) > 25) {
        $validated = true;
        $passwordErr = "password must be between 5 and 50 characters";
    } elseif ($_POST['password'] == $_POST['repassword']) {
        $password = $_POST['password'];
    } else {
        $validated = true;
        $passwordErr = "The password don't match";
        $repasswordErr = "The password don't match";
    }
    //re-password
    if (empty($_POST['repassword'])) {
        $validated = true;
        $repasswordErr = "enter a retype password";
    } else {
        $repassword = $_POST['repassword'];
    }
    //gender
    $gender = $_POST['gender'];
    if ($validated == false) {

        require_once "conn.php";
        $name = $conn->real_escape_string($name);
        $surname = $conn->real_escape_string($surname);
        $username = $conn->real_escape_string($username);
        $password = $conn->real_escape_string($password);
        $password = md5($password);


        $sqlU = "SELECT * FROM users
        WHERE username = '$username'";
        $rezultat = $conn->query($sqlU);
        $br = $rezultat->num_rows;
        if ($br != 0) {
            $usernameErr = "Username allready taken";
        } else {
            $sql = "INSERT INTO users(username,pass)
        VALUES
        ('$username','$password');";
            $conn->query($sql);
            $sql = "SELECT id
        FROM users
        WHERE username = '$username'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $sql = "INSERT INTO profiles(name,surname,gender,dob,user_id)
        VALUES
        ('$name','$surname','$gender','$birth','$id');";
            if ($conn->query($sql)) {
                $succes = "You have successfully registered!";
            } else {
                $error = "an error has occurred, " . $conn->error . "</p>";
            }
            header('Location: login.php');
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

    <title>mreza</title>
</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-5 col-sm-12">
                <form action="#" method="POST">
                    <fieldset class="mt-5">
                        <h2 class="text-center text-white py-4">Sing up</h2>
                        <p>

                            <input class=" form-control text-center bg-primary" placeholder="name" type="text" name="name" value="<?php echo $name ?>"><span class="text-danger">*<?php echo $nameErr ?></span>
                        </p>
                        <p>
                            <input class=" form-control text-center bg-primary" placeholder="surname" type="text" name="surname" value="<?php echo $surname ?>">*<span class="text-danger "><?php echo $surnameErr ?></span>
                        </p>
                        <p>
                            <input class=" form-control text-center  bg-primary" placeholder="username" type="text" name="username" value="<?php echo $username ?>"><span class="text-danger">*<?php echo $usernameErr ?></span>
                        </p>
                        <p>
                            <input class=" form-control text-center  bg-primary" placeholder="password" type="password" name="password"><span class="text-danger "><?php echo $passwordErr ?>*</span>
                        </p>
                        <p>
                            <input class=" form-control text-center  bg-primary" placeholder="re-type password" type="password" name="repassword"><span class="text-danger ">*<?php echo $repasswordErr ?></span>
                        </p>
                        <label class="text-primary font-weight-bold">Date of birth</label>
                        <p>
                            <input class=" form-control text-center  bg-primary" type="date" min="1900-01-01" name="birth" value="<?php echo date('Y-m-d') ?>"><span class="text-danger ">*<?php echo $birthErr ?></span>
                        </p>
                        <p class="text-center">
                            <label class="text-primary font-weight-bold">Gender</label><br>
                            <input type="radio" name="gender" id="" value="m">male
                            <input type="radio" name="gender" id="" value="f">female
                            <input type="radio" name="gender" id="" value="o" checked>other
                        </p>
                        <p>
                            <input class="form-control text-center btn btn-primary" type="submit" name="submit" value="Registry">
                        </p>
                        <?php echo "<p>$succes</p>"
                        ?>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</body>

</html>