<?php
// app/views/carte_concessions.php

$pageCss = ['carte.css'];
require __DIR__ . '/layout/header.php';

// Récupérer toutes les concessions avec coordonnées
require_once __DIR__ . '/../models/ConcessionnaireModel.php';
$concessionnaireModel = new ConcessionnaireModel();
$concessions = $concessionnaireModel->getAllWithCoordinates();

// JSON safe pour JS
$concessionsJson = json_encode(
    $concessions,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
);
?>

<!-- Leaflet (si déjà inclus dans header.php, tu peux supprimer ces 2 lignes) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="carte-container">
    <h1>🗺️ Carte des concessions</h1>

    <div class="map-filters">
        <input type="text"
               id="search-address"
               placeholder="🔍 Rechercher une ville ou une concession..."
               class="search-input">

        <button type="button" id="btn-search" class="btn-search">Rechercher</button>
    </div>

    <div id="map" style="height: 600px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"></div>

    <div class="concessions-list">
        <h2>📍 Liste des concessions (<?= count($concessions) ?>)</h2>

        <div class="list-items" id="concessions-list">
            <?php foreach ($concessions as $c): ?>
                <div class="concession-item"
                     data-id="<?= htmlspecialchars((string)$c['id_concess']) ?>"
                     data-lat="<?= htmlspecialchars((string)$c['latitude']) ?>"
                     data-lon="<?= htmlspecialchars((string)$c['longitude']) ?>">
                    <h3><?= htmlspecialchars($c['nom']) ?></h3>
                    <p>📍 <?= htmlspecialchars($c['adresse']) ?></p>
                    <small><?= (int)$c['nb_vehicules'] ?> véhicule(s) disponible(s)</small>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // 1) Data
  const concessions = <?= $concessionsJson ?>;

  // 2) Map init
  const map = L.map('map').setView([46.603354, 1.888334], 6); // Centre France
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  // 3) Markers storage
  const markersById = new Map();

  concessions.forEach(c => {
    if (!c.latitude || !c.longitude) return;

    const lat = parseFloat(c.latitude);
    const lon = parseFloat(c.longitude);
    if (Number.isNaN(lat) || Number.isNaN(lon)) return;

    const marker = L.marker([lat, lon]).addTo(map);

    const vehiclesUrl = "<?= BASE_URL ?>/public/index.php?page=vehicles&concession=" + encodeURIComponent(c.nom);

    marker.bindPopup(`
      <div style="text-align:center;">
        <h3>${escapeHtml(c.nom)}</h3>
        <p><strong>📍</strong> ${escapeHtml(c.adresse)}</p>
        <p><strong>🚗</strong> ${escapeHtml(String(c.nb_vehicules))} véhicule(s)</p>
        <a href="${vehiclesUrl}" style="color:#007bff; text-decoration:none; font-weight:600;">
          Voir les véhicules →
        </a>
      </div>
    `);

    markersById.set(String(c.id_concess), marker);
  });

  // 4) Click on list item -> focus + popup
  const list = document.getElementById('concessions-list');
  list.addEventListener('click', (e) => {
    const item = e.target.closest('.concession-item');
    if (!item) return;

    const id = item.dataset.id;
    const lat = parseFloat(item.dataset.lat);
    const lon = parseFloat(item.dataset.lon);

    if (!Number.isNaN(lat) && !Number.isNaN(lon)) {
      map.setView([lat, lon], 15);
      const marker = markersById.get(String(id));
      if (marker) marker.openPopup();
    }
  });

  // 5) Search hybrid (concession -> else city via Nominatim)
  async function searchNearby() {
    const input = document.getElementById('search-address');
    const query = (input.value || '').trim();
    if (!query) {
      alert('Veuillez saisir une ville ou un nom de concession');
      return;
    }

    const q = query.toLowerCase();

    // 5.1) Local search in concessions
    const match = concessions.find(c => {
      const nom = (c.nom || '').toLowerCase();
      const adr = (c.adresse || '').toLowerCase();
      return nom.includes(q) || adr.includes(q);
    });

    if (match && match.latitude && match.longitude) {
      const lat = parseFloat(match.latitude);
      const lon = parseFloat(match.longitude);
      if (!Number.isNaN(lat) && !Number.isNaN(lon)) {
        map.setView([lat, lon], 15);
        const marker = markersById.get(String(match.id_concess));
        if (marker) marker.openPopup();
        return;
      }
    }

    // 5.2) Geocode city/address via Nominatim
    try {
      const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`;
      const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
      const data = await res.json();

      if (!data || !data.length) {
        alert("Aucun résultat : ni concession trouvée, ni adresse reconnue.");
        return;
      }

      const lat = parseFloat(data[0].lat);
      const lon = parseFloat(data[0].lon);
      if (Number.isNaN(lat) || Number.isNaN(lon)) {
        alert("Résultat invalide.");
        return;
      }

      map.setView([lat, lon], 12);

      L.marker([lat, lon]).addTo(map)
        .bindPopup('📍 Résultat de recherche')
        .openPopup();

    } catch (err) {
      console.error(err);
      alert("Erreur lors de la recherche (voir console).");
    }
  }

  // 6) Bind events
  document.getElementById('btn-search').addEventListener('click', searchNearby);
  document.getElementById('search-address').addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      searchNearby();
    }
  });

  // 7) Small helper for safe HTML in popup
  function escapeHtml(str) {
    return String(str)
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }
});
</script>



<?php require __DIR__ . '/layout/footer.php'; ?>
