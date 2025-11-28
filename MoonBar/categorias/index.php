<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: ../auth/login.php");
if ($_SESSION['rol'] !== 'admin') header("Location: ../menu.php");

include("../database/db.php");

$result = $conn->query("SELECT * FROM categorias");
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/styles.css">
<title>Categorías</title>
</head>
<body>
<div class="container">

<h2>Categorías</h2>

<!-- Botón para volver al panel admin -->
<a href="../productos/index.php">⬅ Volver al Panel </a>

<br><br>

<!-- Botón crear categoría -->
<a href="crear.php">➕ Nueva Categoría</a>

<br><br>

<table>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Acciones</th>
</tr>
<?php while($row = $result->fetch_assoc()) { ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['nombre']) ?></td>
<td>
<a href="editar.php?id=<?= $row['id'] ?>">Editar</a> |
<a href="eliminar.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar categoría?')">Eliminar</a>
</td>
</tr>
<?php } ?>
</table>

</div>
</body>
</html>
