<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'admin') {
    header("Location: ../menu.php");
    exit;
}
include "../database/db.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = intval($_GET['id']);

$consulta = $conn->query("SELECT * FROM productos WHERE id=$id");
$producto = $consulta->fetch_assoc();
$cats = $conn->query("SELECT * FROM categorias");

if (!$producto) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['actualizar'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $categoria = intval($_POST['categoria']);
    $conn->query("UPDATE productos SET nombre='$nombre', precio=$precio, categoria_id=$categoria WHERE id=$id");
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../css/styles.css">
  <title>Editar Producto</title>
</head>
<body>
<div class="container">
  <h2>Editar Producto</h2>
  <a href="index.php">← Volver</a>
  <form method="POST">
    <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
    <input type="number" name="precio" value="<?= $producto['precio'] ?>" step="0.01" required>
    <select name="categoria" required>
      <?php while($c = $cats->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>" <?= ($c['id'] == $producto['categoria_id']) ? 'selected' : '' ?>><?= htmlspecialchars($c['nombre']) ?></option>
      <?php endwhile; ?>
    </select>
    <button name="actualizar">Actualizar</button>
  </form>
</div>
</body>
</html>
