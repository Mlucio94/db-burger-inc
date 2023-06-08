<?php

$servername = "localhost";
$database = "burgerincdb";
$username = "root";
$password = "";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Falló la conexión: " . mysqli_connect_error());
}

?>