<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: ../auth/login.php");
if (isset($_SESSION['rol']) && $_SESSION['rol'] !== 'admin') header("Location: ../menu.php");

include "../database/db.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = intval($_GET['id']);

/* Antes de eliminar, podrías revisar si existen productos asociados y manejar la relación.
   Aquí asumimos eliminación directa (si tu FK NO permite eliminar, deberás manejarlo). */
$conn->query("DELETE FROM categorias WHERE id=$id");
header("Location: index.php");
exit;
