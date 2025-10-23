<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Eliminar pasaje
if (isset($_GET['eliminar'])) {
  $id = intval($_GET['eliminar']);
  mysqli_query($conn, "DELETE FROM pasajes WHERE id = $id");
  header("Location: pasajes.php");
  exit;
}

// Insertar nuevo pasaje
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
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

<style>
  form {
    max-width: 400px;
    margin: auto;
    text-align: left;
  }
  input, select, button {
    width: 100%;
    margin: 8px 0;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
  }
  button {
    background-color: #1e3a8a;
    color: white;
    border: none;
    cursor: pointer;
  }
  button:hover {
    background-color: #3b5fc4;
  }
  .mensaje {
    text-align: center;
    margin: 20px;
    font-weight: bold;
  }
</style>

<h2 align="center">GESTIÓN DE PASAJES</h2>

<table width="900" border="1" align="center" cellpadding="3">
  <tr>
    <td colspan="8" align="center">LISTA DE PASAJES</td>
  </tr>
  <tr>
    <td bgcolor="#3399CC">ID</td>
    <td bgcolor="#3399CC">Nombre</td>
    <td bgcolor="#3399CC">RUT</td>
    <td bgcolor="#3399CC">Asiento</td>
    <td bgcolor="#3399CC">Valor</td>
    <td bgcolor="#3399CC">Fecha Compra</td>
    <td bgcolor="#3399CC">Itinerario</td>
    <td bgcolor="#3399CC">Acciones</td>
  </tr>

  <?php while ($p = mysqli_fetch_assoc($pasajes)) { ?>
    <tr>
      <td align="center"><?= $p['id'] ?></td>
      <td align="center"><?= $p['nombre_pasajero'] ?></td>
      <td align="center"><?= $p['rut_pasajero'] ?></td>
      <td align="center"><?= $p['asiento'] ?></td>
      <td align="center"><?= $p['valor'] ?></td>
      <td align="center"><?= $p['fecha_compra'] ?></td>
      <td align="center"><?= $p['ciudad_origen'] ?> → <?= $p['ciudad_destino'] ?></td>
      <td align="center">
        <a href="editar_pasaje.php?id=<?= $p['id'] ?>">Editar</a> |
        <a href="?eliminar=<?= $p['id'] ?>" onclick="return confirm('¿Eliminar este pasaje?')">Eliminar</a>
      </td>
    </tr>
  <?php } ?>
</table>

<br><br>
<div class="menu" align="center">
  <form action="../index.php">
    <button type="submit" style="width:100px">INICIO</button>
  </form>
</div>