<?php
// Parámetros de conexión
$host = "localhost";
$usuario = "root";
$clave = "";
$base_datos = "logittransport";

// Crear conexión
$conexion = new mysqli($host, $usuario, $clave, $base_datos);
if ($conexion->connect_error) {
  die("❌ Error de conexión: " . $conexion->connect_error);
}

// Obtener parámetros desde GET
$origen = isset($_GET['origen']) ? urldecode($_GET['origen']) : 'Traiguén';
$destino = isset($_GET['destino']) ? urldecode($_GET['destino']) : 'Victoria';

// Datos ficticios del conductor
$nombre_conductor = "Juan Pérez";
$telefono_conductor = "+56 9 1234 5678";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ubicación del Bus - Logittransport</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
  <style>
    body { font-family: 'Segoe UI', sans-serif; background:#f4f6f8; margin:0; padding:0; }
    header { background:#1e3a8a; color:white; padding:30px; text-align:center; }
    .container { max-width:900px; margin:30px auto; padding:20px; background:white; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
    #map { width:100%; height:450px; border-radius:6px; }
    .info { margin-bottom:20px; font-size:18px; }
  </style>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body>

<header>
  <h1>🗺️ Ubicación del Bus</h1>
</header>

<div class="container">
  <div class="info">
    <p><strong>Origen:</strong> <?= htmlspecialchars($origen) ?></p>
    <p><strong>Destino:</strong> <?= htmlspecialchars($destino) ?></p>
    <p><strong>Conductor:</strong> <?= htmlspecialchars($nombre_conductor) ?></p>
    <p><strong>Teléfono:</strong> <?= htmlspecialchars($telefono_conductor) ?></p>
  </div>
  <div id="map"></div>
</div>

<div class="menu" style="text-align:center; margin-top:20px;">
  <form action="index.php">
    <button type="submit" style="width:100px">INICIO</button>
  </form>
</div>

<script>
// Crear mapa
var map = L.map('map').setView([-38.25, -72.67], 9); // centro aprox Araucanía

// Cargar mapa base
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Función para obtener coordenadas de una ciudad usando Nominatim
async function getCoords(city) {
  let url = "https://nominatim.openstreetmap.org/search?format=json&q=" + encodeURIComponent(city + ", Chile");
  let res = await fetch(url);
  let data = await res.json();
  if (data.length > 0) {
    return [parseFloat(data[0].lat), parseFloat(data[0].lon)];
  }
  return null;
}

// Obtener coordenadas de origen y destino y dibujar ruta
(async () => {
  let origen = "<?= htmlspecialchars($origen) ?>";
  let destino = "<?= htmlspecialchars($destino) ?>";

  let coordOrigen = await getCoords(origen);
  let coordDestino = await getCoords(destino);

  if (coordOrigen && coordDestino) {
    // Marcadores
    L.marker(coordOrigen).addTo(map).bindPopup("Origen: " + origen).openPopup();
    L.marker(coordDestino).addTo(map).bindPopup("Destino: " + destino);

    // Dibujar línea de recorrido
    var ruta = L.polyline([coordOrigen, coordDestino], {color: 'blue'}).addTo(map);

    // Ajustar vista al recorrido
    map.fitBounds(ruta.getBounds());
  } else {
    alert("No se pudieron encontrar coordenadas para las ciudades ingresadas.");
  }
})();
</script>

</body>
</html>