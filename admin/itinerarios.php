<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Insertar nuevo itinerario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
  $origen = mysqli_real_escape_string($conn, $_POST['ciudad_origen']);
  $destino = mysqli_real_escape_string($conn, $_POST['ciudad_destino']);
  $bus_id = intval($_POST['bus_id']);
  $conductor_id = intval($_POST['conductor_id']);
  $fecha = $_POST['fecha'];
  $hora_salida = $_POST['hora_salida'];
  $hora_llegada = $_POST['hora_llegada'];
  $precio = intval($_POST['precio']);

  mysqli_query($conn, "INSERT INTO itinerarios (bus_id, conductor_id, ciudad_origen, ciudad_destino, fecha, hora_salida, hora_llegada, precio)
    VALUES ($bus_id, $conductor_id, '$origen', '$destino', '$fecha', '$hora_salida', '$hora_llegada', $precio)");
}

// Eliminar itinerario
if (isset($_GET['eliminar'])) {
  $id = intval($_GET['eliminar']);
  mysqli_query($conn, "DELETE FROM itinerarios WHERE id = $id");
  header("Location: itinerarios.php");
  exit;
}

// Obtener buses y conductores
$buses = mysqli_query($conn, "SELECT id, placa, modelo FROM buses");
$conductores = mysqli_query($conn, "SELECT id, nombre, rut FROM conductores");

// Mostrar itinerarios
$itinerarios = mysqli_query($conn, "
  SELECT 
    i.id AS itinerario_id,
    i.ciudad_origen,
    i.ciudad_destino,
    i.fecha,
    i.hora_salida,
    i.hora_llegada,
    i.precio,
    b.placa,
    b.modelo,
    c.nombre,
    c.rut
  FROM itinerarios i
  JOIN buses b ON i.bus_id = b.id
  JOIN conductores c ON i.conductor_id = c.id
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Itinerarios | Logittransport</title>
  <style>
    * { box-sizing: border-box; }
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
      padding: 30px;
      text-align: center;
    }
    header h1 {
      margin: 0;
      font-size: 28px;
    }
    form {
      max-width: 500px;
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
    input, select, button {
      width: 100%;
      margin: 8px 0;
      padding: 12px;
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
    .acciones a {
      margin: 0 5px;
      text-decoration: none;
      color: #1e3a8a;
      font-weight: bold;
    }
    .acciones a:hover {
      text-decoration: underline;
    }
    .menu {
      text-align: center;
      margin: 40px;
    }
  </style>
</head>
<body>

<header>
  <h1>🗺️ Gestión de Itinerarios</h1>
</header>

<form method="POST">
  <label>Ciudad de origen:</label>
  <input type="text" name="ciudad_origen" required>

  <label>Ciudad de destino:</label>
  <input type="text" name="ciudad_destino" required>

  <label>Seleccionar bus:</label>
  <select name="bus_id" required>
    <option value="">Seleccionar bus</option>
    <?php while ($b = mysqli_fetch_assoc($buses)) {
      echo "<option value='{$b['id']}'>{$b['placa']} - {$b['modelo']}</option>";
    } ?>
  </select>

  <label>Seleccionar conductor:</label>
  <select name="conductor_id" required>
    <option value="">Seleccionar conductor</option>
    <?php while ($c = mysqli_fetch_assoc($conductores)) {
      echo "<option value='{$c['id']}'>{$c['nombre']} - {$c['rut']}</option>";
    } ?>
  </select>

  <label>Fecha del viaje:</label>
  <input type="date" name="fecha" required>

  <label>Hora de salida:</label>
  <input type="time" name="hora_salida" required>

  <label>Hora de llegada:</label>
  <input type="time" name="hora_llegada" required>

  <label>Precio del pasaje (CLP):</label>
  <input type="number" name="precio" min="0" required>

  <button type="submit" name="agregar">➕ Agregar Ruta</button>
</form>

<table>
  <tr>
    <th>Bus</th>
    <th>Conductor</th>
    <th>Origen</th>
    <th>Destino</th>
    <th>Fecha</th>
    <th>Salida</th>
    <th>Llegada</th>
    <th>Precio</th>
    <th>Acciones</th>
  </tr>
  <?php while ($i = mysqli_fetch_assoc($itinerarios)) { ?>
    <tr>
      <td><?= $i['placa'] ?> - <?= $i['modelo'] ?></td>
      <td><?= $i['nombre'] ?> - <?= $i['rut'] ?></td>
      <td><?= $i['ciudad_origen'] ?></td>
      <td><?= $i['ciudad_destino'] ?></td>
      <td><?= $i['fecha'] ?></td>
      <td><?= $i['hora_salida'] ?></td>
      <td><?= $i['hora_llegada'] ?></td>
      <td><?= number_format($i['precio'], 0, ',', '.') ?> CLP</td>
      <td class="acciones">
        <a href="editar_itinerario.php?id=<?= $i['itinerario_id'] ?>">✏️ Editar</a>
        <a href="?eliminar=<?= $i['itinerario_id'] ?>" onclick="return confirm('¿Eliminar esta ruta?')">🗑️ Eliminar</a>
      </td>
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