<?php
session_start();

// Validar que el usuario sea admin
if (!isset($_SESSION['usuario'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['rol'] !== 'admin') {
    header("Location: ../menu.php");
    exit;
}

include "../database/db.php";

// Constante para evitar repetir el literal
define("REDIRECT_CATEGORIAS", "Location: index.php");

// Validar parámetro GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header(REDIRECT_CATEGORIAS);
    exit;
}

$id = intval($_GET['id']);

// Obtener categoría
$consulta = $conn->query("SELECT * FROM categorias WHERE id = $id");
$categoria = $consulta->fetch_assoc();

// Redirigir si no existe
if (!$categoria) {
    header(REDIRECT_CATEGORIAS);
    exit;
}

// Actualizar categoría
if (isset($_POST['actualizar'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);

    $conn->query("UPDATE categorias SET nombre='$nombre' WHERE id=$id");

    header(REDIRECT_CATEGORIAS);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Editar Categoría</title>
</head>
<body>
<div class="container">

<h2>Editar Categoría</h2>

<a href="../admin/index.php">⬅ Volver al Panel Admin</a>
<br><br>
<a href="index.php">← Volver a Categorías</a>
<br><br>

<form method="POST">
    <input type="text" name="nombre" value="<?= htmlspecialchars($categoria['nombre']) ?>" required>
    <button name="actualizar">Actualizar</button>
</form>

</div>
</body>
</html>
