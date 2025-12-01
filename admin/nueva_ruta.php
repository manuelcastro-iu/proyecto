<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Insertar nueva ruta (ida y vuelta)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
  $origen = mysqli_real_escape_string($conn, $_POST['ciudad_origen']);
  $destino = mysqli_real_escape_string($conn, $_POST['ciudad_destino']);
  $precio = intval($_POST['precio']);

  // Insertar ida
  mysqli_query($conn, "INSERT INTO rutas_fijas (ciudad_origen, ciudad_destino, precio) VALUES ('$origen', '$destino', $precio)");
  // Insertar vuelta
  mysqli_query($conn, "INSERT INTO rutas_fijas (ciudad_origen, ciudad_destino, precio) VALUES ('$destino', '$origen', $precio)");
}

// Eliminar ruta
if (isset($_GET['eliminar'])) {
  $id = intval($_GET['eliminar']);
  mysqli_query($conn, "DELETE FROM rutas_fijas WHERE id = $id");
  header("Location: rutas.php");
  exit;
}

// Obtener rutas existentes
$rutas = mysqli_query($conn, "SELECT id, ciudad_origen, ciudad_destino, precio FROM rutas_fijas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Rutas | Logittransport</title>
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
    table {
      width: 600px;
      margin: 40px auto;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
    }
    th {
      background-color: #1e3a8a;
      color: white;
    }
    .menu {
      text-align: center;
      margin: 40px;
    }
    a {
      color: #1e3a8a;
      text-decoration: none;
      font-weight: bold;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<h2>🛣️ Ingresar Nueva Ruta Predeterminada</h2>

<form method="POST">
  <input type="text" name="ciudad_origen" placeholder="Ciudad de origen" required>
  <input type="text" name="ciudad_destino" placeholder="Ciudad de destino" required>
  <input type="number" name="precio" placeholder="Precio del pasaje (CLP)" min="0" required>
  <button type="submit" name="agregar">➕ Agregar Ruta</button>
</form>

<table>
  <tr>
    <th colspan="5">Rutas Existentes</th>
  </tr>
  <tr>
    <th>Ciudad Origen</th>
    <th>Ciudad Destino</th>
    <th>Precio</th>
    <th>Editar</th>
    <th>Eliminar</th>
  </tr>

  <?php while ($i = mysqli_fetch_assoc($rutas)) { ?>
    <tr>
      <td><?= htmlspecialchars($i['ciudad_origen']) ?></td>
      <td><?= htmlspecialchars($i['ciudad_destino']) ?></td>
      <td><?= number_format($i['precio'], 0, ',', '.') ?> CLP</td>
      <td><a href="editar_ruta.php?id=<?= $i['id'] ?>">✏️ Editar</a></td>
      <td><a href="?eliminar=<?= $i['id'] ?>" onclick="return confirm('¿Eliminar esta ruta?')">🗑️ Eliminar</a></td>
    </tr>
  <?php } ?>
</table>

<div class="menu">
  <form action="../index.php">
    <button type="submit">🏠 INICIO</button>
  </form>
</div>

</body>
</html>