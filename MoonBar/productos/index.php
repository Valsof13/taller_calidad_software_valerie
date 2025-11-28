<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../menu.php");
    exit;
}

require __DIR__ . '/../database/db.php';

$sql = "SELECT p.id, p.nombre, p.precio, c.nombre AS categoria 
        FROM productos p
        LEFT JOIN categorias c ON p.categoria_id = c.id
        ORDER BY p.id DESC";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../css/styles.css">
  <title>Productos - Admin</title>
</head>
<body>
<div class="container">

  <h2>Productos (Panel Admin)</h2>

  <p>
     Sesión iniciada como: <strong><?php echo $_SESSION['usuario']; ?></strong> 
    | Rol: <strong><?php echo $_SESSION['rol']; ?></strong>
    | <a href="../auth/logout.php">Cerrar sesión</a>
  </p>

  <!-- NUEVO BOTÓN PARA CATEGORÍAS -->
  <a href="../categorias/index.php">📂 Gestionar Categorías</a>

  <!-- BOTÓN PARA CREAR PRODUCTO -->
  <a href="crear.php" style="margin-left: 10px;">➕ Nuevo producto</a>

  <br><br>

  <table>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Precio</th>
      <th>Categoría</th>
      <th>Acciones</th>
    </tr>

    <?php while($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['nombre']) ?></td>
        <td>$<?= number_format($row['precio'], 0, ',', '.') ?></td>
        <td><?= htmlspecialchars($row['categoria']) ?></td>
        <td>
          <a href="editar.php?id=<?= $row['id'] ?>">Editar</a> |
          <a href="eliminar.php?id=<?= $row['id'] ?>" onclick="return confirm('Eliminar producto?')">Eliminar</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>
