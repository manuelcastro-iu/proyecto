<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

$id = intval($_GET['id']);
$pasaje = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pasajes WHERE id = $id"));
$itinerarios = mysqli_query($conn, "SELECT id, ciudad_origen, ciudad_destino, fecha FROM itinerarios");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $itinerario_id = $_POST['itinerario_id'];
  $nombre = $_POST['nombre_pasajero'];
  $rut = $_POST['rut_pasajero'];
  $asiento = $_POST['asiento'];
  $valor = $_POST['valor'];
  $fecha = $_POST['fecha_compra'];

  mysqli_query($conn, "UPDATE pasajes SET itinerario_id=$itinerario_id, nombre_pasajero='$nombre', rut_pasajero='$rut', asiento=$asiento, valor=$valor, fecha_compra='$fecha' WHERE id=$id");
  header("Location: pasajes.php");
  exit;
}
?>

<h2>Editar Pasaje</h2>
<form method="POST">
  <label>Itinerario:</label>
  <select name="itinerario_id" required>
    <?php while ($i = mysqli_fetch_assoc($itinerarios)) {
      $selected = ($pasaje['itinerario_id'] == $i['id']) ? 'selected' : '';
      echo "<option value='{$i['id']}' $selected>{$i['ciudad_origen']} → {$i['ciudad_destino']} ({$i['fecha']})</option>";
    } ?>
  </select>

  <label>Nombre del pasajero:</label>
  <input type="text" name="nombre_pasajero" value="<?= $pasaje['nombre_pasajero'] ?>" required>

  <label>RUT:</label>
  <input type="text" name="rut_pasajero" value="<?= $pasaje['rut_pasajero'] ?>" required>

  <label>Asiento:</label>
  <input type="number" name="asiento" value="<?= $pasaje['asiento'] ?>" required>

  <label>Valor:</label>
  <input type="number" name="valor" value="<?= $pasaje['valor'] ?>" required>

  <label>Fecha de compra:</label>
  <input type="date" name="fecha_compra" value="<?= $pasaje['fecha_compra'] ?>" required>

  <button type="submit">Guardar cambios</button>
  <a href="pasajes.php"><button type="button">Cancelar</button></a>
</form>