<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Insertar nuevo itinerario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bus_id = $_POST['bus_id'];
  $conductor_id = $_POST['conductor_id'];
  $origen = $_POST['ciudad_origen'];
  $destino = $_POST['ciudad_destino'];
  $fecha = $_POST['fecha'];
  $hora_salida = $_POST['hora_salida'];
  $hora_llegada = $_POST['hora_llegada'];
  mysqli_query($conn, "INSERT INTO itinerarios (bus_id, conductor_id, ciudad_origen, ciudad_destino, fecha, hora_salida, hora_llegada) VALUES ($bus_id, $conductor_id, '$origen', '$destino', '$fecha', '$hora_salida', '$hora_llegada')");
}

// Obtener buses y conductores
$buses = mysqli_query($conn, "SELECT id, placa FROM buses");
$conductores = mysqli_query($conn, "SELECT id, nombre FROM conductores");

// Mostrar itinerarios
$itinerarios = mysqli_query($conn, "SELECT i.*, b.placa, c.nombre FROM itinerarios i JOIN buses b ON i.bus_id = b.id JOIN conductores c ON i.conductor_id = c.id");
?>

<h2>Gestión de Itinerarios</h2>
<form method="POST">
  <select name="bus_id" required>
    <option value="">Seleccionar bus</option>
    <?php while ($b = mysqli_fetch_assoc($buses)) {
      echo "<option value='{$b['id']}'>{$b['placa']}</option>";
    } ?>
  </select>
  <select name="conductor_id" required>
    <option value="">Seleccionar conductor</option>
    <?php while ($c = mysqli_fetch_assoc($conductores)) {
      echo "<option value='{$c['id']}'>{$c['nombre']}</option>";
    } ?>
  </select>
  <input type="text" name="ciudad_origen" placeholder="Ciudad de origen" required>
  <input type="text" name="ciudad_destino" placeholder="Ciudad de destino" required>
  <input type="date" name="fecha" required>
  <input type="time" name="hora_salida" required>
  <input type="time" name="hora_llegada" required>
  <button type="submit">Agregar Itinerario</button>
</form>

<table>
  <tr><th>ID</th><th>Bus</th><th>Conductor</th><th>Origen</th><th>Destino</th><th>Fecha</th><th>Salida</th><th>Llegada</th></tr>
  <?php while ($i = mysqli_fetch_assoc($itinerarios)) {
    echo "<tr>
            <td>{$i['id']}</td>
            <td>{$i['placa']}</td>
            <td>{$i['nombre']}</td>
            <td>{$i['ciudad_origen']}</td>
            <td>{$i['ciudad_destino']}</td>
            <td>{$i['fecha']}</td>
            <td>{$i['hora_salida']}</td>
            <td>{$i['hora_llegada']}</td>
          </tr>";
  } ?>
</table>