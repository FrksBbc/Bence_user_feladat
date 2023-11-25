<?php

include("connect.php");



if(isset($_POST["submitted"])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $timestamp = date('Y-m-d H:i:s');

    $error = [];

    if(strlen($name) < 6 || strlen($name) > 255) {
        $error[] = 'A név minimum 6 maximum 255 karakter lehet!';
    }
    if(filter_var($email, FILTER_VALIDATE_EMAIL) != true) {
        $error[] = 'Az email nem megfelelő <br>';
    }

    $sql = "select * from users where email='$email'";
    $eredmeny = mysqli_query($connection, $sql);
    if(mysqli_num_rows($eredmeny) > 0) {
        $error[] = 'Ez az email cím már használatban van!';
    }

    if(strlen($password) < 5 || strlen($password) > 20) {
        $error[] = 'A jelszó minimum 5 maximum 20 karakter lehet!';
    }





    if(count($error) === 0) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($connection, "INSERT INTO `users` (`name`, `email`, `password`,`email_verified_at`) VALUES ('$name','$email','$password','$timestamp');");

        $success = 'Sikeres felvétel!';
        $_SESSION["success"] = $success;
        header("location: mainpage.php");
        exit();

    } else {
        $_SESSION["errors"] = $error;
        $_SESSION["tartalom"] = $_POST;

    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">
        <h3>Felhasználó szerkesztése</h3>
        <?php
            if(isset($_SESSION["errors"]) && count($_SESSION["errors"]) > 0) {
                print '<div class="alert alert-danger">';
                foreach($_SESSION["errors"] as $err) {
                    print "<li>$err</li>";
                }
                print '</div>';
            } elseif(isset($_SESSION["success"])) {
                print '<div class="alert alert-success">';
                print "<li>{$_SESSION["success"]}</li>";

                print '</div>';
            }
            unset($_SESSION["errors"], $_SESSION["success"]);

?>
        <form class="mt-4" method="post">
            <div class="form-group">
                <label for="name">Név</label>
                <input type="text" name="name" class="form-control" value="<?php print $user["name"] ?? '' ?> ">
            </div>
            <div class=" form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" value="<?php print $user["email"] ?? '' ?>">
            </div>
            <div class=" form-group">
                <label for="password">Jelszó</label>
                <input type="text" name="password" class="form-control" value="<?php print $user["password"] ?? '' ?>">
            </div>

            <br>
            <button class="mt-4 btn btn-success" name="submitted">Felvitel</button>
            <a href="javascript:history.go(-1)" class="mt-4 btn btn-secondary">Vissza</a>

        </form>
    </div>



    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html><?php
unset($_SESSION["tartalom"]);?>