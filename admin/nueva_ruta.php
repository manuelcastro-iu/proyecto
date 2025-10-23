<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Insertar nueva ruta (ida y vuelta)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
  $origen = $_POST['ciudad_origen'];
  $destino = $_POST['ciudad_destino'];

  // Insertar ida
  mysqli_query($conn, "INSERT INTO itinerarios (ciudad_origen, ciudad_destino) VALUES ('$origen', '$destino')");
  // Insertar vuelta
  mysqli_query($conn, "INSERT INTO itinerarios (ciudad_origen, ciudad_destino) VALUES ('$destino', '$origen')");
}

// Eliminar ruta
if (isset($_GET['eliminar'])) {
  $id = intval($_GET['eliminar']);
  mysqli_query($conn, "DELETE FROM itinerarios WHERE id = $id");
  header("Location: rutas.php");
  exit;
}

// Obtener rutas existentes
$rutas = mysqli_query($conn, "SELECT id, ciudad_origen, ciudad_destino FROM itinerarios");
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

<h2 align="center">INGRESAR NUEVA RUTA</h2>

<form method="POST">
  <input type="text" name="ciudad_origen" placeholder="Ciudad de origen" required>
  <input type="text" name="ciudad_destino" placeholder="Ciudad de destino" required>
  <button type="submit" name="agregar">Agregar Nueva Ruta</button>
</form>

<table width="500" border="1" align="center" cellpadding="3">
  <tr>
    <td colspan="4" align="center">RUTAS EXISTENTES</td>
  </tr>
  <tr>
    <td bgcolor="#3399CC">Ciudad Origen</td>
    <td bgcolor="#3399CC">Ciudad Destino</td>
    <td bgcolor="#3399CC">Editar</td>
    <td bgcolor="#3399CC">Eliminar</td>
  </tr>

  <?php while ($i = mysqli_fetch_assoc($rutas)) { ?>
    <tr>
      <td align="center"><?= $i['ciudad_origen'] ?></td>
      <td align="center"><?= $i['ciudad_destino'] ?></td>
      <td align="center">
        <a href="editar_ruta.php?id=<?= $i['id'] ?>">Editar</a>
      </td>
      <td align="center">
        <a href="?eliminar=<?= $i['id'] ?>" onclick="return confirm('¿Eliminar esta ruta?')">Eliminar</a>
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