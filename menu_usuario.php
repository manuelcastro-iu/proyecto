<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'usuario') {
  header('Location: login_usuario.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Menú Usuario | Logittransport</title>
  <style>
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
    main {
      max-width: 800px;
      margin: 40px auto;
      padding: 20px;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #1e3a8a;
    }
    .botonera {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-top: 30px;
    }
    button {
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
  </style>
</head>
<body>

<header>
  <h1>🎟️ Menú Usuario</h1>
</header>

<main>
  <h2>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></h2>

  <div class="botonera">
    <form action="comprar_pasaje.php"><button>Comprar Pasaje</button></form>
    <form action="ver_pasaje.php"><button>Ver Mis Pasajes</button></form>
    <form action="viajes_privados.php"><button>Itinerario de Viajes Privados</button></form>
    <form action="mapa.php"><button>¿Dónde va el bus?</button></form>
    <form action="logout.php"><button>🔓 Cerrar Sesión</button></form>
  </div>
</main>

</body>
</html>