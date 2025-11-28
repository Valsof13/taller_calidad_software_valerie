<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: ../auth/login.php");
if (isset($_SESSION['rol']) && $_SESSION['rol'] !== 'admin') header("Location: ../menu.php");

include "../database/db.php";

$cats = $conn->query("SELECT * FROM categorias");

if (isset($_POST['guardar'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $categoria = intval($_POST['categoria']);
    $conn->query("INSERT INTO productos (nombre, precio, categoria_id) VALUES ('$nombre', $precio, $categoria)");
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../css/styles.css">
  <title>Crear Producto</title>
</head>
<body>
<div class="container">
  <h2>Crear Producto</h2>
  <a href="index.php">← Volver</a>
  <form method="POST">
    <input type="text" name="nombre" placeholder="Nombre del producto" required>
    <input type="number" name="precio" placeholder="Precio" step="0.01" required>
    <select name="categoria" required>
      <?php while($c = $cats->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
      <?php endwhile; ?>
    </select>
    <button name="guardar">Guardar</button>
  </form>
</div>
</body>
</html>
