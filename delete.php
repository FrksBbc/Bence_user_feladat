<?php

include("connect.php");

$id = $_GET["id"];
$sql = "DELETE FROM users WHERE id = '$id'";
mysqli_query($connection, $sql);

$success = 'A törlés sikeresen megtörtént!';
$_SESSION["success"] = $success;
header("location: mainpage.php");
exit();
