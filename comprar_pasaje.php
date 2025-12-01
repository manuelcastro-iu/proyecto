<?php
include 'db.php';

$asientos_ocupados = [];
$mensaje = '';
$itinerario_id = null;
$fecha = '';
$hora = '';

// Buscar itinerario automáticamente
if (isset($_POST['origen'], $_POST['destino'])) {
  $origen = $_POST['origen'];
  $destino = $_POST['destino'];       
    
  $buscar = mysqli_query($conn, "SELECT id, fecha, hora_salida FROM itinerarios WHERE ciudad_origen='$origen' AND ciudad_destino='$destino' LIMIT 1");
  if ($row = mysqli_fetch_assoc($buscar)) {
    $itinerario_id = $row['id'];
    $fecha = $row['fecha'];
    $hora = $row['hora_salida'];
  } else {
    $mensaje = "❌ No se encontró un itinerario entre esas ciudades.";
  }
}

// Confirmar compra
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar']) && isset($_POST['itinerario_id'])) {
  $itinerario_id = intval($_POST['itinerario_id']);
  $nombre = $_POST['nombre_pasajero'];
  $rut = $_POST['rut_pasajero'];
  $asiento = intval($_POST['asiento']);
  $valor = intval($_POST['valor']);
  $fecha_compra = date('Y-m-d');

  $verificar_asiento = mysqli_query($conn, "SELECT * FROM pasajes WHERE itinerario_id = $itinerario_id AND asiento = $asiento");
  if (mysqli_num_rows($verificar_asiento) > 0) {
    $mensaje = "❌ Ese asiento ya está ocupado. Elige otro.";
  } else {
    $verificar_rut = mysqli_query($conn, "SELECT * FROM pasajes WHERE rut_pasajero = '$rut' AND itinerario_id = $itinerario_id");
    if (mysqli_num_rows($verificar_rut) > 0) {
      $mensaje = "❌ Este RUT ya tiene un pasaje registrado para este itinerario.";
    } else {
      $query = "INSERT INTO pasajes (itinerario_id, nombre_pasajero, rut_pasajero, asiento, valor, fecha_compra)
                VALUES ($itinerario_id, '$nombre', '$rut', $asiento, $valor, '$fecha_compra')";
      $result = mysqli_query($conn, $query);
      $mensaje = $result ? "✅ Pasaje registrado correctamente." : "❌ Error al registrar el pasaje.";
    }
  }
}

// Obtener asientos ocupados
if ($itinerario_id) {
  $ocupados = mysqli_query($conn, "SELECT asiento FROM pasajes WHERE itinerario_id = $itinerario_id");
  while ($fila = mysqli_fetch_assoc($ocupados)) {
    $asientos_ocupados[] = $fila['asiento'];
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Comprar Pasaje - Logittransport</title>
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
    .mensaje {
      text-align: center;
      margin: 20px;
      font-weight: bold;
      color: #d32f2f;
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
    .asiento-btn {
      padding: 10px;
      background-color: #e0e0e0;
      border: 1px solid #999;
      border-radius: 4px;
      cursor: pointer;
      text-align: center;
      width: 50px;
    }
    .asiento-btn:hover {
      background-color: #c0d4ff;
    }
    .ocupado {
      background-color: #ffcccc;
      cursor: not-allowed;
    }
    .seleccionado {
      background-color: #a2f3a2 !important;
    }
    .menu {
      text-align: center;
      margin: 40px;
    }
  </style>
  <script>
    function seleccionarAsiento(n) {
      document.getElementById('asiento').value = n;
      let botones = document.querySelectorAll('.asiento-btn');
      botones.forEach(btn => btn.classList.remove('seleccionado'));
      document.getElementById('btn-' + n).classList.add('seleccionado');
    }
  </script>
</head>
<body>

<header>
  <h1>🎟️ Comprar Pasaje</h1>
</header>

<?php if ($mensaje) echo "<p class='mensaje'>$mensaje</p>"; ?>

<form method="POST">
  <label>Ciudad de origen:</label>
  <select name="origen" required>
    <option value="">Seleccionar</option>
    <?php
    $origenes = mysqli_query($conn, "SELECT DISTINCT ciudad_origen FROM itinerarios");
    while ($o = mysqli_fetch_assoc($origenes)) {
      $selected = (isset($_POST['origen']) && $_POST['origen'] == $o['ciudad_origen']) ? 'selected' : '';
      echo "<option value='{$o['ciudad_origen']}' $selected>{$o['ciudad_origen']}</option>";
    }
    ?>
  </select>

  <label>Ciudad de destino:</label>
  <select name="destino" required>
    <option value="">Seleccionar</option>
    <?php
    $destinos = mysqli_query($conn, "SELECT DISTINCT ciudad_destino FROM itinerarios");
    while ($d = mysqli_fetch_assoc($destinos)) {
      $selected = (isset($_POST['destino']) && $_POST['destino'] == $d['ciudad_destino']) ? 'selected' : '';
      echo "<option value='{$d['ciudad_destino']}' $selected>{$d['ciudad_destino']}</option>";
    }
    ?>
  </select>

  <button type="submit">Buscar itinerario</button>
</form>

<?php if ($itinerario_id): ?>
  <form method="POST">
    <input type="hidden" name="itinerario_id" value="<?= $itinerario_id ?>">

    <p><strong>Fecha del viaje:</strong> <?= $fecha ?></p>
    <p><strong>Hora de salida:</strong> <?= $hora ?></p>

    <label>Selecciona tu asiento:</label>
    <div style="display: flex; flex-direction: column; gap: 10px; margin: 20px 0;">
      <?php
for ($fila = 0; $fila < 11; $fila++) {
  $izq1 = $fila * 4 + 1;
  $izq2 = $fila * 4 + 2;
  $der1 = $fila * 4 + 3;
  $der2 = $fila * 4 + 4;

  echo "<div style='display: flex; justify-content: center; gap: 20px;'>";

  foreach ([$izq1, $izq2] as $n) {
    if ($n > 45) continue;
    $ocupado = in_array($n, $asientos_ocupados);
    echo "<div id='btn-$n' class='asiento-btn " . ($ocupado ? 'ocupado' : '') . "' onclick='" . ($ocupado ? '' : "seleccionarAsiento($n)") . "'>$n</div>";
  }

  echo "<div style='width: 60px; text-align: center;'>PASILLO</div>";

  foreach ([$der1, $der2] as $n) {
    if ($n > 45) continue;
    $ocupado = in_array($n, $asientos_ocupados);
    echo "<div id='btn-$n' class='asiento-btn " . ($ocupado ? 'ocupado' : '') . "' onclick='" . ($ocupado ? '' : "seleccionarAsiento($n)") . "'>$n</div>";
  }

  echo "</div>";
}
?>
      </div>
 
      <input type="hidden" name="asiento" id="asiento">

      <label>Nombre completo:</label>
      <input type="text" name="nombre_pasajero" required>

      <label>RUT:</label>
      <input type="text" name="rut_pasajero" required>

      <label>Valor del pasaje:</label>
      <input type="number" name="valor" required>

      <button type="submit" name="confirmar">Confirmar compra</button>
    </form>
      <?php endif; ?>

  <div class="menu">
    <form action="index.php">
      <button type="submit" style="width:100px">INICIO</button>
    </form>
  </div>

</body>
</html>