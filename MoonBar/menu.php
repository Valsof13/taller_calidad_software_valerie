<?php
session_start();

// Si NO ha iniciado sesión → login
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit;
}

// Si es ADMIN → redirigir al panel de productos
if ($_SESSION['rol'] === 'admin') {
    header("Location: productos/index.php");
    exit;
}

require __DIR__ . '/database/db.php';

// Consulta productos para mostrar menú al cliente
$sql = "SELECT p.id, p.nombre, p.precio, c.nombre AS categoria
        FROM productos p
        LEFT JOIN categorias c ON p.categoria_id = c.id
        ORDER BY p.nombre ASC";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Menú - MoonBar</title>
    <link rel="stylesheet" href="css/styles.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1b1b1b;
            color: white;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            font-size: 18px;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: #2a2a2a;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #444;
            text-align: left;
        }
        th {
            background: #3a3a3a;
        }
        tr:hover {
            background: #444;
        }
        .btn-logout {
            color: #ff5252;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-logout:hover {
            text-decoration: underline;
        }
    </style>

</head>
<body>

<div class="top-bar">
    <span>👤 Usuario: <?= $_SESSION['usuario'] ?> (<?= $_SESSION['rol'] ?>)</span>
    <a class="btn-logout" href="auth/logout.php">Cerrar sesión</a>
</div>

<h2>🍹 Menú de MoonBar</h2>

<table>
    <tr>
        <th>Nombre</th>
        <th>Categoría</th>
        <th>Precio</th>
    </tr>

    <?php while($row = $res->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['nombre']) ?></td>
        <td><?= htmlspecialchars($row['categoria']) ?></td>
        <td>$<?= number_format($row['precio'], 0, ',', '.') ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
