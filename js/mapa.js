// Inicializa el mapa centrado en Victoria, Araucanía
const map = L.map('map').setView([-38.2329, -72.3311], 13);

// Capa base de OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Grupo de marcadores para buses
const grupoBuses = L.layerGroup().addTo(map);

// Función para cargar ubicaciones desde el servidor
async function cargarUbicaciones() {
  try {
    const res = await fetch('ubicaciones.php');
    const buses = await res.json();

    grupoBuses.clearLayers(); // Limpia marcadores anteriores

    buses.forEach(bus => {
      const marcador = L.marker([bus.latitud, bus.longitud])
        .bindPopup(`
          <strong>🚌 Bus ${bus.placa}</strong><br>
          Modelo: ${bus.modelo}<br>
          Conductor: ${bus.conductor}<br>
          Destino: ${bus.destino}
        `);
      grupoBuses.addLayer(marcador);
    });
  } catch (error) {
    console.error('Error al cargar ubicaciones:', error);
  }
}

// Reloj en tiempo real
function actualizarReloj() {
  const reloj = document.getElementById('reloj');
  const ahora = new Date();
  reloj.textContent = "🕒 " + ahora.toLocaleTimeString('es-CL');
}

// Ejecutar al cargar
cargarUbicaciones();
actualizarReloj();

// Actualizar cada 10 segundos
setInterval(cargarUbicaciones, 10000);
setInterval(actualizarReloj, 1000);