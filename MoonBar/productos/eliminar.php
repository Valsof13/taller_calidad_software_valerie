<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'admin') {
    header("Location: ../menu.php");
    exit;
}
require __DIR__ . '/../database/db.php';
$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $conn->query("DELETE FROM productos WHERE id=$id");
}
header("Location: index.php");
exit;
