<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Eliminar bus
if (isset($_GET['eliminar'])) {
  $id = intval($_GET['eliminar']);
  mysqli_query($conn, "DELETE FROM buses WHERE id = $id");
  header("Location: buses.php");
  exit;
}

// Insertar nuevo bus
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $placa = $_POST['placa'];
  $modelo = $_POST['modelo'];
  $capacidad = intval($_POST['capacidad']);
  mysqli_query($conn, "INSERT INTO buses (placa, modelo, capacidad) VALUES ('$placa', '$modelo', $capacidad)");
}

// Mostrar buses
$buses = mysqli_query($conn, "SELECT * FROM buses");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Buses | Logittransport</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
      color: #333;
    }
    header {
      background-color: #1e3a8a;
      color: white;
      padding: 20px;
      text-align: center;
    }
    h2 {
      margin: 0;
      font-size: 26px;
    }
    form {
      max-width: 600px;
      margin: 30px auto;
      background-color: white;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    label {
      font-weight: bold;
      margin-top: 10px;
      display: block;
    }
    input, button {
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
      width: 95%;
      margin: 30px auto;
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
    .acciones a {
      margin: 0 5px;
      text-decoration: none;
      font-weight: bold;
      color: #1e3a8a;
    }
    .acciones a:hover {
      text-decoration: underline;
    }
    .menu {
      text-align: center;
      margin: 30px;
    }
  </style>
</head>
<body>

<header>
  <h2>🚌 Gestión de Buses</h2>
</header>

<form method="POST">
  <label>Placa:</label>
  <input type="text" name="placa" placeholder="Placa del bus" required>

  <label>Modelo:</label>
  <input type="text" name="modelo" placeholder="Modelo del bus" required>

  <label>Capacidad:</label>
  <input type="number" name="capacidad" placeholder="Capacidad máxima" required>

  <button type="submit">➕ Agregar Bus</button>
</form>

<table>
  <tr>
    <th>ID</th>
    <th>Placa</th>
    <th>Modelo</th>
    <th>Capacidad</th>
    <th>Acciones</th>
  </tr>
  <?php while ($bus = mysqli_fetch_assoc($buses)) { ?>
    <tr>
      <td><?= $bus['id'] ?></td>
      <td><?= htmlspecialchars($bus['placa']) ?></td>
      <td><?= htmlspecialchars($bus['modelo']) ?></td>
      <td><?= $bus['capacidad'] ?></td>
      <td class="acciones">
        <a href="editar_bus.php?id=<?= $bus['id'] ?>">✏️ Editar</a>
        <a href="?eliminar=<?= $bus['id'] ?>" onclick="return confirm('¿Eliminar este bus?')">🗑️ Eliminar</a>
      </td>
    </tr>
  <?php } ?>
</table>

<div class="menu">
  <form action="../index.php">
    <button type="submit">← Volver al panel</button>
  </form>
</div>

</body>
</html>