<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Validar ID
if (!isset($_GET['id'])) {
  header('Location: nueva_ruta.php');
  exit;
}

$id = intval($_GET['id']);

// Actualizar ruta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
  $origen = mysqli_real_escape_string($conn, $_POST['ciudad_origen']);
  $destino = mysqli_real_escape_string($conn, $_POST['ciudad_destino']);
  $precio = intval($_POST['precio']);

  mysqli_query($conn, "UPDATE rutas_fijas SET ciudad_origen = '$origen', ciudad_destino = '$destino', precio = $precio WHERE id = $id");
  header("Location: nueva_ruta.php");
  exit;
}

// Obtener datos actuales
$ruta = mysqli_query($conn, "SELECT ciudad_origen, ciudad_destino, precio FROM rutas_fijas WHERE id = $id");
if (mysqli_num_rows($ruta) === 0) {
  echo "<p style='text-align:center; font-weight:bold;'>Ruta no encontrada.</p>";
  exit;
}
$datos = mysqli_fetch_assoc($ruta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Ruta | Logittransport</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
      color: #333;
    }
    h2 {
      margin-top: 30px;
      text-align: center;
      color: #1e3a8a;
    }
    form {
      max-width: 400px;
      margin: 20px auto;
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    input, select, button {
      width: 100%;
      margin: 8px 0;
      padding: 10px;
      border-radius: 4px;
      border: 1px solid #ccc;
      font-size: 15px;
    }
    button {
      background-color: #1e3a8a;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }
    button:hover {
      background-color: #3b5fc4;
    }
    .menu {
      text-align: center;
      margin: 40px;
    }
  </style>
</head>
<body>

<h2>✏️ Editar Ruta Predeterminada</h2>

<form method="POST">
  <input type="text" name="ciudad_origen" value="<?= htmlspecialchars($datos['ciudad_origen']) ?>" required>
  <input type="text" name="ciudad_destino" value="<?= htmlspecialchars($datos['ciudad_destino']) ?>" required>
  <input type="number" name="precio" value="<?= $datos['precio'] ?>" min="0" required>
  <button type="submit" name="actualizar">💾 Guardar Cambios</button>
</form>

<div class="menu">
  <form action="nueva_ruta.php">
    <button type="submit">🔙 Volver</button>
  </form>
</div>

</body>
</html>