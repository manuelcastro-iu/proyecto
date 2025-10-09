<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Insertar nuevo pasaje
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $itinerario_id = $_POST['itinerario_id'];
  $nombre = $_POST['nombre_pasajero'];
  $rut = $_POST['rut_pasajero'];
  $asiento = $_POST['asiento'];
  $valor = $_POST['valor'];
  $fecha = $_POST['fecha_compra'];
  mysqli_query($conn, "INSERT INTO pasajes (itinerario_id, nombre_pasajero, rut_pasajero, asiento, valor, fecha_compra) VALUES ($itinerario_id, '$nombre', '$rut', $asiento, $valor, '$fecha')");
}

// Obtener itinerarios
$itinerarios = mysqli_query($conn, "SELECT id, ciudad_origen, ciudad_destino, fecha FROM itinerarios");

// Mostrar pasajes
$pasajes = mysqli_query($conn, "SELECT p.*, i.ciudad_origen, i.ciudad_destino FROM pasajes p JOIN itinerarios i ON p.itinerario_id = i.id");
?>

<h2>Gestión de Pasajes</h2>
<form method="POST">
  <select name="itinerario_id" required>
    <option value="">Seleccionar itinerario</option>
    <?php while ($i = mysqli_fetch_assoc($itinerarios)) {
      echo "<option value='{$i['id']}'>{$i['ciudad_origen']} → {$i['ciudad_destino']} ({$i['fecha']})</option>";
    } ?>
  </select>
  <input type="text" name="nombre_pasajero" placeholder="Nombre del pasajero" required>
  <input type="text" name="rut_pasajero" placeholder="RUT" required>
  <input type="number" name="asiento" placeholder="Asiento" required>
  <input type="number" name="valor" placeholder="Valor" required>
  <input type="date" name="fecha_compra" required>
  <button type="submit">Registrar Pasaje</button>
</form>

<table>
  <tr><th>ID</th><th>Pasajero</th><th>RUT</th><th>Asiento</th><th>Valor</th><th>Fecha</th><th>Ruta</th></tr>
  <?php while ($p = mysqli_fetch_assoc($pasajes)) {
    echo "<tr>
            <td>{$p['id']}</td>
            <td>{$p['nombre_pasajero']}</td>
            <td>{$p['rut_pasajero']}</td>
            <td>{$p['asiento']}</td>
            <td>{$p['valor']}</td>
            <td>{$p['fecha_compra']}</td>
            <td>{$p['ciudad_origen']} → {$p['ciudad_destino']}</td>
          </tr>";
  } ?>
</table>