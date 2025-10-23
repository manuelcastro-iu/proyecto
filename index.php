<?php
session_start();
include 'db.php';
$esAdmin = isset($_SESSION['usuario']) && $_SESSION['rol'] === 'admin';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Logittransport</title>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: url('imagen.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      color: #333;
    }
    header {
      background-color: rgba(115, 115, 115, 0);
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
      border: 1px solid #ccc;
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

<?php include 'estilo_menu.php'; ?>

<header>
  <h1>Bienvenido a Logittransport</h1>
  <p>Selecciona una opción para continuar</p>
</header>

<main>
  <section>
    <h2>Servicios para pasajeros</h2>
    <div class="botonera">
      <form action="comprar_pasaje.php">
        <button type="submit">🎟️ Comprar Pasaje</button>
      </form>
      <form action="ver_pasaje.php">
        <button type="submit">📋 Ver Mis Pasajes</button>
      </form>
      <form action="viajes_privados.php">
        <button type="submit">🛣️ Itinerario de Viajes Privados</button>
      </form>
      <button onclick="mostrarFormulario()">🗺️ ¿Dónde va el bus?</button>
    </div>
  </section>

  <section>
    <h2>Gestión administrativa</h2>
    <div class="botonera">
      <form action="<?= $esAdmin ? 'admin/pasajes.php' : 'login.php' ?>">
        <button type="submit">Gestor de Pasajes</button>
      </form>
      <form action="<?= $esAdmin ? 'admin/conductores.php' : 'login.php' ?>">
        <button type="submit">Gestor de Conductores</button>
      </form>
      <form action="<?= $esAdmin ? 'admin/viajes_privados.php' : 'login.php' ?>">
        <button type="submit">✅ Aceptar Viaje Privado</button>
      </form>
      <div class="fila-botones">
        <form action="<?= $esAdmin ? 'admin/itinerarios.php' : 'login.php' ?>">
          <button type="submit">Gestor de Rutas</button>
        </form>
        <form action="<?= $esAdmin ? 'admin/nueva_ruta.php' : 'login.php' ?>">
          <button type="submit">Nueva Ruta</button>
        </form>
        <form action="<?= $esAdmin ? 'admin/buses.php' : 'login.php' ?>">
          <button type="submit">Gestor de Buses</button>
        </form>
      </div>
    </div>
  </section>
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
<form action="logout.php" method="POST" style="text-align:right; margin: 10px;">
  <button type="submit">🔓 Cerrar sesión</button>
</form>
</body>
</html>