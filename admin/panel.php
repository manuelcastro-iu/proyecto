<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Administrativo - Logittransport</title>
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
    .container {
      max-width: 800px;
      margin: 40px auto;
      background-color: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .bienvenida {
      text-align: center;
      margin-bottom: 30px;
      font-size: 18px;
      color: #1e3a8a;
    }
    .botonera {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }
    .botonera form {
      margin: 0;
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
    .cerrar {
      margin-top: 40px;
      text-align: center;
    }
  </style>
</head>
<body>

<header>
  <h1>Panel Administrativo</h1>
</header>

<div class="container">
  <div class="bienvenida">
    Bienvenido, <strong><?= $_SESSION['usuario'] ?></strong>
  </div>

  <div class="botonera">
    <form action="pasajes.php"><button>Gestor de Pasajes</button></form>
    <form action="conductores.php"><button>Gestor de Conductores</button></form>
    <form action="viajes_privados.php"><button>Aceptar Viajes Privados</button></form>
    <form action="itinerarios.php"><button>Gestor de Rutas</button></form>
    <form action="nueva_ruta.php"><button>Crear Nueva Ruta</button></form>
    <form action="buses.php"><button>Gestor de Buses</button></form>
  </div>

  <div class="cerrar">
    <form action="../logout.php" method="POST">
      <button type="submit">Cerrar sesión</button>
    </form>
  </div>
</div>

</body>
</html>
<?php
session_start();
session_destroy();
header('Location: login.php');
exit;