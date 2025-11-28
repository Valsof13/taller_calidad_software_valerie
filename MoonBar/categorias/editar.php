<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: ../auth/login.php");
if ($_SESSION['rol'] !== 'admin') header("Location: ../menu.php");

include "../database/db.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);
$consulta = $conn->query("SELECT * FROM categorias WHERE id=$id");
$categoria = $consulta->fetch_assoc();

if (!$categoria) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['actualizar'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);

    $conn->query("UPDATE categorias SET nombre='$nombre' WHERE id=$id");
    header("Location: index.php");
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

  <!-- Botón volver al panel admin -->
  <a href="../productos/index.php">⬅ Volver al Panel</a>
  <br><br>

  <!-- Botón volver a categorías -->
  <a href="index.php">← Volver a Categorías</a>
  <br><br>

  <form method="POST">
    <input type="text" name="nombre" value="<?= htmlspecialchars($categoria['nombre']) ?>" required>
    <button name="actualizar">Actualizar</button>
  </form>

</div>
</body>
</html>

