<?php
$link = mysqli_connect($hostname, $username, $password, $database);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
mysqli_select_db($link, $database) or die("Could not open the db 'DBname'");

 // Your time zone
date_default_timezone_set('America/Sao_Paulo');

?>