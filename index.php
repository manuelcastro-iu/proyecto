<?php
session_start();
include 'db.php';

$esAdmin = isset($_SESSION['usuario']) && $_SESSION['rol'] === 'admin';

// Generar itinerarios diarios si no existen
$hoy = date('Y-m-d');
$fijos = mysqli_query($conn, "SELECT * FROM itinerarios_fijos WHERE activo = 1");

while ($fijo = mysqli_fetch_assoc($fijos)) {
  $bus_id = $fijo['bus_id'];
  $conductor_id = $fijo['conductor_id'];
  $origen = mysqli_real_escape_string($conn, $fijo['ciudad_origen']);
  $destino = mysqli_real_escape_string($conn, $fijo['ciudad_destino']);
  $salida = $fijo['hora_salida'];
  $llegada = $fijo['hora_llegada'];
  $precio = intval($fijo['precio']);

  $existe = mysqli_query($conn, "SELECT id FROM itinerarios WHERE bus_id = $bus_id AND fecha = '$hoy' AND hora_salida = '$salida'");
  if (mysqli_num_rows($existe) === 0) {
    mysqli_query($conn, "INSERT INTO itinerarios (bus_id, conductor_id, ciudad_origen, ciudad_destino, fecha, hora_salida, hora_llegada, precio)
      VALUES ($bus_id, $conductor_id, '$origen', '$destino', '$hoy', '$salida', '$llegada', $precio)");
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Logittransport</title>
  <style>
    /* Estilos originales conservados */
    * { box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: url('imagen.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      color: #000000ff;
    }
    header {
      background-color: rgba(0, 0, 0, 0);
      color: white;
      padding: 30px 20px;
      text-align: center;
    }
    header h1 {
      margin: 0;
      font-size: 32px;
    }
    header p {
      margin-top: 10px;
      font-size: 18px;
    }
    main {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(420px, 1fr));
      gap: 40px;
      padding: 40px;
      max-width: 1200px;
      margin: auto;
    }
    section {
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      padding: 30px;
    }
    section h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #1e3a8a;
      font-size: 22px;
    }
    .botonera {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    .botonera form, .botonera button {
      width: 100%;
    }
    button {
      width: 100%;
      padding: 14px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      background-color: #1e3a8a;
      color: white;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }
    button:hover {
      background-color: #3b5fc4;
    }
    .fila-botones {
      display: flex;
      gap: 10px;
    }
    .fila-botones form {
      flex: 1;
    }
    .form-mapa {
      max-width: 500px;
      margin: 40px auto;
      background-color: rgba(255, 255, 255, 0.95);
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      display: none;
    }
    .form-mapa h3 {
      margin-top: 0;
      color: #1e3a8a;
      text-align: center;
    }
    .form-mapa input {
      width: 100%;
      margin: 10px 0;
      padding: 12px;
      border-radius: 4px;
      border: 1px solid #121212ff;
    }
    .form-mapa button {
      background-color: #1e3a8a;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 4px;
      font-size: 16px;
    }
    .form-mapa button:hover {
      background-color: #3b5fc4;
    }
  </style>
</head>
<body>

<header>
  <h1>Bienvenido a Logittransport</h1>
  <p>Selecciona una opción para continuar</p>
</header>

<main>
  <section>
    <h2>Servicios para pasajeros</h2>
    <div class="botonera">
      <form action="comprar_pasaje.php"><button>🎟️ Comprar Pasaje</button></form>
      <form action="ver_pasaje.php"><button>📋 Ver Mis Pasajes</button></form>
      <form action="viajes_privados.php"><button>🛣️ Itinerario de Viajes Privados</button></form>
      <button onclick="mostrarFormulario()">🗺️ ¿Dónde va el bus?</button>
    </div>
  </section>

  <?php if ($esAdmin): ?>
  <section>
    <h2>Gestión administrativa</h2>
    <div class="botonera">
      <form action="admin/pasajes.php"><button>Gestor de Pasajes</button></form>
      <form action="admin/conductores.php"><button>Gestor de Conductores</button></form>
      <form action="admin/viajes_privados.php"><button>✅ Aceptar Viaje Privado</button></form>
      <div class="fila-botones">
        <form action="admin/itinerarios.php"><button>Gestor de Rutas</button></form>
        <form action="admin/nueva_ruta.php"><button>Nueva Ruta</button></form>
        <form action="admin/buses.php"><button>Gestor de Buses</button></form>
      </div>
    </div>
  </section>

  <section>
    <h2>🔐 Sesión</h2>
    <div class="botonera">
      <form action="logout.php"><button>🔓 Cerrar sesión</button></form>
    </div>
  </section>
  <?php endif; ?>
</main>

<section class="form-mapa" id="formMapa">
  <form action="mapa.php" method="GET">
    <h3>Consulta de ubicación</h3>
    <input type="text" name="origen" placeholder="¿De dónde viene el bus?" required>
    <input type="text" name="destino" placeholder="¿A dónde debe llegar?" required>
    <button type="submit">Ver en el mapa</button>
  </form>
</section>

<script>
  function mostrarFormulario() {
    document.getElementById('formMapa').style.display = 'block';
  }
</script>

</body>
</html>