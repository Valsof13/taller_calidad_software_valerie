<?php
$host = "localhost";
$user = "root";
$pass = "123";
$db   = "moonbar_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error en conexión: " . $conn->connect_error);
}
?>
