<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: ../auth/login.php");
if ($_SESSION['rol'] !== 'admin') header("Location: ../menu.php");

include "../database/db.php";

if (isset($_POST['guardar'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);

    if ($nombre !== '') {
        $conn->query("INSERT INTO categorias (nombre) VALUES ('$nombre')");
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../css/styles.css">
  <title>Crear Categoría</title>
</head>
<body>
<div class="container">

  <h2>Crear Categoría</h2>

  <!-- Botón volver al panel admin -->
  <a href="../productos/index.php">⬅ Volver al Panel</a>
  <br><br>

  <!-- Botón volver a categorías -->
  <a href="index.php">← Volver a Categorías</a>
  <br><br>

  <form method="POST">
    <input type="text" name="nombre" placeholder="Nombre de la categoría" required>
    <button name="guardar">Guardar</button>
  </form>

</div>
</body>
</html>
