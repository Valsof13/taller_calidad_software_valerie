<?php
session_start();
require "../database/db.php";

//  Validar que vienen datos del formulario
if (!isset($_POST['usuario']) || !isset($_POST['password'])) {
    header("Location: login.php?error=1");
    exit;
}

$usuario = trim($_POST['usuario']);
$password = trim($_POST['password']);

//  Buscar usuario en BD
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' LIMIT 1";
$res = $conn->query($sql);

if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();

    //  Como tus contraseñas NO están encriptadas:
    if ($password === $row['password']) {
        $_SESSION['usuario'] = $row['usuario'];
        $_SESSION['rol'] = $row['rol'];

        //  Redirección según rol
        if ($row['rol'] === "admin") {
            header("Location: ../productos/index.php");
            exit;
        } else {
            header("Location: ../menu.php");
            exit;
        }
    }
}

//  Usuario o contraseña incorrectos
header("Location: login.php?error=1");
exit;

