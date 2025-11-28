<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../css/styles.css">
  <title>Login - MoonBar</title>
</head>
<body>
<div class="container">
  <h2>Iniciar Sesión - MoonBar</h2>
  <form action="validar.php" method="POST">
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Ingresar</button>
  </form>
  <p><a href="../index.php">← Volver al inicio</a></p>
</div>
</body>
</html>
