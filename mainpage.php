<?php
include("connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cikkek</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>



    <div class="container mt-3">
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
        <h3>Felhasználók</h3>
        <table class="table table-hover">
            <tr>
                <th>Név</th>
                <th>Email</th>
                <th>Regisztráció dátuma</th>
                <th>Műveletek</th>

            </tr>
            <?php
                $sql = "SELECT * FROM users";
$result = mysqli_query($connection, $sql);
while($user = mysqli_fetch_assoc($result)) {
    print "<tr>
                <td>{$user["name"]}</td>
                <td>{$user["email"]}</td>
                <td>{$user["created_at"]}</td>

                <td><a href='user-details.php?id=" . $user["id"] . "' class='btn btn-success btn-md center-block' style='width:100px;margin-bottom:10px;'>Szerkesztés</a>
                <a href='delete.php?id=" . $user["id"] . "' class='btn btn-danger btn-md center-block'style='width:100px;margin-bottom:10px;'>Törlés</a></>

                
            </tr>";
}
?>
        </table>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>