<?php

require_once "header.php";
require_once "conn.php";

$nameb = $surnameb = $genderb = $dobb = $biob = "";

$greska = "";
?>




<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-5 col-sm-12">
            <h2 class="text-center text-white py-4 ">search</h2>
            <form action="" method="GET">

                <fieldset>
                    <input class=" form-control text-center  bg-primary" type="text" name="korisnik" id="pretraga" placeholder="search friends">


                    <input class=" form-control text-center btn btn-primary mt-4" name="submit" type="submit" value="search!">


                </fieldset>

            </form>


        </div>

    </div>

</div>


<?php

if (isset($_GET['submit'])) {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $idkorisnik = $_GET['korisnik'];


        $sql = "SELECT * FROM profiles
WHERE id = $idkorisnik";
        $result = $conn->query($sql);

        $user_id = $result->fetch_assoc();

        $user_id = $user_id['user_id'];

        $sqlUserName = "SELECT * FROM users
WHERE id = $user_id";

        $resultUserName = $conn->query($sqlUserName);
        $resultUserName = $resultUserName->fetch_assoc();
        $username = $resultUserName['username'];


        if ($result) {

            echo '<div class="container py-5">';
            echo '<div class="row d-flex justify-content-center">';
            echo '<div class="col-xl-6 col-sm-12">';
            foreach ($result as $row) {

                if ($row['gender'] == 'm') {
                    $color = 'white';
                } elseif ($row['gender'] == 'f') {
                    $color = 'danger';
                } else {
                    $color = 'dark';
                }
                echo "<h3 class='text-center text-white'>Hello " . $row['name'] . " " . $row['surname'] . "</h3>";

                echo "<table  class=' d-flex justify-content-center table table-bordered  table-sm text-white w-auto'>";
                echo "<tr><th>Name</th><td class='text-$color'>" . $row['name'] . "</td>";
                echo "<tr><th>Surname</th><td class='text-$color'>" . $row['surname'] . "</td>";
                echo "<tr><th>Username</th><td class='text-$color'>" . $username . "</td>";
                echo "<tr><th>Gender</th><td class='text-$color'>" . $row['gender'] . "</td>";
                echo "<tr><th>Bio</th><td class='text-$color'>" . $row['bio'] . "</td>";
                echo "</table>";
            }
        } else {

            echo "<p id='paragraf'>The user doesn't exist!</p>";
        }


        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<a class="btn btn-primary" href="followers.php" role="button">go back</a>';
    }
}
?>



<?php





?>


</body>

</html>