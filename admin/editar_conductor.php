<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM conductores WHERE id = $id");
$conductor = mysqli_fetch_assoc($result);

if (!$conductor) {
  echo "Conductor no encontrado.";
  exit;
}

// Guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre'];
  $rut = $_POST['rut'];
  $telefono = $_POST['telefono'];
  $licencia = $_POST['licencia'];

  mysqli_query($conn, "UPDATE conductores SET nombre='$nombre', rut='$rut', telefono='$telefono', licencia='$licencia' WHERE id=$id");
  header("Location: conductores.php");
  exit;
}
?>

<h2>Editar Conductor</h2>
<form method="POST">
  <label>ID (no editable):</label>
  <input type="text" value="<?= $conductor['id'] ?>" disabled><br><br>

  <label>Nombre:</label>
  <input type="text" name="nombre" value="<?= $conductor['nombre'] ?>" required><br><br>

  <label>RUT:</label>
  <input type="text" name="rut" value="<?= $conductor['rut'] ?>" required><br><br>

  <label>Teléfono:</label>
  <input type="text" name="telefono" value="<?= $conductor['telefono'] ?>" required><br><br>

  <label>Licencia:</label>
  <input type="text" name="licencia" value="<?= $conductor['licencia'] ?>" required><br><br>

  <button type="submit">Guardar</button>
  <a href="conductores.php"><button type="button">Cancelar</button></a>
</form>