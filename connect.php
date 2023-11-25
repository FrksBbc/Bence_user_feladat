<?php

session_start();

$connection = mysqli_connect('localhost', 'root', 'FarkasBence', 'bence_gyakorlas');
if($err = mysqli_connect_error()) {
    exit($err);
}
