// ================== 1. DONNÉES VÉHICULES ==================
let voitures = [
  { plaque: "VT-001-AAA", marque: "Toyota",    modele: "Prius+",          type: "Berline Hybride",  couleur: "Blanche",      prix: 70,  concession: 1, statut: "disponible" },
  { plaque: "VT-002-AAB", marque: "Toyota",    modele: "Corolla Hybride", type: "Berline",          couleur: "Gris",         prix: 65,  concession: 1, statut: "disponible" },
  { plaque: "VT-003-AAC", marque: "Toyota",    modele: "Camry Hybride",   type: "Berline",          couleur: "Noire",        prix: 80,  concession: 1, statut: "entretien" },
  { plaque: "VT-004-AAD", marque: "Toyota",    modele: "RAV4 Hybride",    type: "SUV",              couleur: "Noir",         prix: 85,  concession: 1, statut: "disponible" },
  { plaque: "VT-005-AAE", marque: "Lexus",     modele: "ES 300h",         type: "Berline Luxe",     couleur: "Noir",         prix: 120, concession: 2, statut: "disponible" },
  { plaque: "VT-006-AAF", marque: "Lexus",     modele: "UX 250h",         type: "SUV Compact",      couleur: "Gris",         prix: 90,  concession: 2, statut: "indisponible" },
  { plaque: "VT-007-AAG", marque: "Lexus",     modele: "NX 350h",         type: "SUV Premium",      couleur: "Noir",         prix: 130, concession: 2, statut: "disponible" },
  { plaque: "VT-008-AAH", marque: "Hyundai",   modele: "Ioniq Hybrid",    type: "Berline Hybride",  couleur: "Blanche",      prix: 60,  concession: 1, statut: "disponible" },
  { plaque: "VT-009-AAI", marque: "Hyundai",   modele: "Tucson Hybrid",   type: "SUV",              couleur: "Gris",         prix: 75,  concession: 1, statut: "entretien" },
  { plaque: "VT-010-AAJ", marque: "Kia",       modele: "Niro Hybrid",     type: "SUV Compact",      couleur: "Blanc",        prix: 65,  concession: 1, statut: "disponible" },

  { plaque: "VT-011-AAK", marque: "Tesla",     modele: "Model 3",         type: "Électrique",       couleur: "Noire",        prix: 95,  concession: 2, statut: "disponible" },
  { plaque: "VT-012-AAL", marque: "Tesla",     modele: "Model Y",         type: "Électrique",       couleur: "Blanche",      prix: 110, concession: 2, statut: "disponible" },
  { plaque: "VT-013-AAM", marque: "Mercedes",  modele: "EQE",             type: "Électrique Luxe",  couleur: "Gris",         prix: 140, concession: 2, statut: "indisponible" },
  { plaque: "VT-014-AAN", marque: "BMW",       modele: "i4",              type: "Électrique",       couleur: "Noire",        prix: 135, concession: 2, statut: "disponible" },
  { plaque: "VT-015-AAO", marque: "Kia",       modele: "EV6",             type: "Électrique",       couleur: "Rouge",        prix: 100, concession: 2, statut: "disponible" },

  { plaque: "VT-016-AAP", marque: "Mercedes",  modele: "Classe E",        type: "Berline Luxe",     couleur: "Noire",        prix: 150, concession: 2, statut: "disponible" },
  { plaque: "VT-017-AAQ", marque: "BMW",       modele: "Série 5",         type: "Berline Luxe",     couleur: "Gris foncé",   prix: 145, concession: 2, statut: "disponible" },
  { plaque: "VT-018-AAR", marque: "Audi",      modele: "A6",              type: "Berline Premium",  couleur: "Noir métal",   prix: 140, concession: 2, statut: "entretien" },
  { plaque: "VT-019-AAS", marque: "Skoda",     modele: "Superb",          type: "Berline",          couleur: "Blanc nacré",  prix: 85,  concession: 1, statut: "disponible" },
  { plaque: "VT-020-AAT", marque: "Volkswagen",modele: "Passat",          type: "Berline",          couleur: "Argent",       prix: 75,  concession: 1, statut: "disponible" }
];

// ================== 2. ÉTAT ==================
const INITIAL_VISIBLE = 6;  // toujours 6 au départ
const LOAD_STEP = 3;        // +3 à chaque clic

let currentSearch = "";
let currentTypeFilter = "all";
let currentConcessionFilter = "all";
let currentStatusFilter = "all";
let currentSort = "none";

let visibleCount = INITIAL_VISIBLE;

// mode suppression
let deleteMode = false;
let selectedForDelete = new Set();

// ================== 3. UTILS ==================
function resetVisibleCount() {
  visibleCount = INITIAL_VISIBLE;
}

function statutBadge(statut) {
  switch (statut) {
    case "disponible":
      return `<span class="status-badge status-disponible">🟢 Disponible</span>`;
    case "entretien":
      return `<span class="status-badge status-entretien">🟡 En entretien</span>`;
    case "indisponible":
      return `<span class="status-badge status-indisponible">🔴 Indisponible</span>`;
    default:
      return "";
  }
}


function createCard(v) {
  const isSelected = selectedForDelete.has(v.plaque);
  return `
    <article class="vehicle-card ${isSelected ? "selected-delete" : ""}"
             data-plaque="${v.plaque}">
      
      <div class="vehicle-img-placeholder"></div>

      <span class="heart" data-plaque="${v.plaque}">♡</span>

      <div class="brand">${v.marque}</div>
      <div class="type">${v.modele} · ${v.type} · ${v.couleur}</div>

      <div class="price-row">
        <div class="price">${v.prix}€</div>
        <div class="per-day">Par jour</div>
      </div>

      <div class="infos-row">
        <span>🔖 ${v.plaque}</span>
        <span>${statutBadge(v.statut)}</span>
      </div>

      <div class="infos-row">
        <span>🏢 Concession ${v.concession}</span>
        <span></span>
      </div>
    </article>
  `;
}

function getFilteredCars() {
  const q = currentSearch.toLowerCase();

  let filtered = voitures.filter(v => {
    const inSearch =
      v.marque.toLowerCase().includes(q) ||
      v.modele.toLowerCase().includes(q) ||
      v.type.toLowerCase().includes(q) ||
      v.couleur.toLowerCase().includes(q) ||
      v.plaque.toLowerCase().includes(q);

    let inType = true;
    if (currentTypeFilter !== "all") {
      const t = currentTypeFilter.toLowerCase();
      inType = v.type.toLowerCase().includes(t);
    }

    let inConcession = true;
    if (currentConcessionFilter !== "all") {
      inConcession = v.concession === Number(currentConcessionFilter);
    }

    let inStatus = true;
    if (currentStatusFilter !== "all") {
      inStatus = v.statut === currentStatusFilter;
    }

    return inSearch && inType && inConcession && inStatus;
  });

  // Tri
  if (currentSort === "prix-asc") {
    filtered = [...filtered].sort((a, b) => a.prix - b.prix);
  } else if (currentSort === "prix-desc") {
    filtered = [...filtered].sort((a, b) => b.prix - a.prix);
  } else if (currentSort === "marque-az") {
    filtered = [...filtered].sort((a, b) =>
      a.marque.localeCompare(b.marque, "fr", { sensitivity: "base" })
    );
  }

  return filtered;
}

// ================== 4. RENDU ==================
function renderCars() {
  const grid = document.getElementById("carGrid");
  const loadMoreBtn = document.getElementById("loadMoreBtn");
  if (!grid) return;

  const filtered = getFilteredCars();
  const carsToShow = filtered.slice(0, visibleCount);
    // ✅ Mise à jour du résumé
  const resultsCountEl = document.getElementById("resultsCount");
  const availableCountEl = document.getElementById("availableCount");

  if (resultsCountEl && availableCountEl) {
    const total = filtered.length;
    const disponibles = filtered.filter(v => v.statut === "disponible").length;

    resultsCountEl.textContent = `${total} véhicule${total > 1 ? "s" : ""} trouvés`;
    availableCountEl.textContent = `${disponibles} disponible${disponibles > 1 ? "s" : ""}`;
  }


  grid.innerHTML = carsToShow.map(createCard).join("");

  attachHeartListeners();
  attachCardSelectionListeners();

  if (!loadMoreBtn) return;
  loadMoreBtn.style.display =
    visibleCount >= filtered.length ? "none" : "inline-flex";
}

function attachHeartListeners() {
  const hearts = document.querySelectorAll(".heart");
  hearts.forEach(heart => {
    heart.addEventListener("click", (e) => {
      e.stopPropagation();
      heart.classList.toggle("filled");
      heart.textContent = heart.classList.contains("filled") ? "♥" : "♡";
    });
  });
}

function attachCardSelectionListeners() {
  const cards = document.querySelectorAll(".vehicle-card");
  cards.forEach(card => {
    card.addEventListener("click", () => {
      if (!deleteMode) return;

      const plaque = card.dataset.plaque;
      if (selectedForDelete.has(plaque)) {
        selectedForDelete.delete(plaque);
        card.classList.remove("selected-delete");
      } else {
        selectedForDelete.add(plaque);
        card.classList.add("selected-delete");
      }
    });
  });
}

// ================== 5. INTERACTIONS ==================

// Recherche
const searchInput = document.getElementById("searchInput");
if (searchInput) {
  searchInput.addEventListener("input", (e) => {
    currentSearch = e.target.value.trim();
    resetVisibleCount();
    renderCars();
  });
}

// Filtre principal (types)
const typeFilterToggle = document.getElementById("typeFilterToggle");
const typeFilterMenu   = document.getElementById("typeFilterMenu");
const typeFilterLabel  = document.getElementById("typeFilterLabel");

if (typeFilterToggle && typeFilterMenu && typeFilterLabel) {
  typeFilterToggle.addEventListener("click", () => {
    typeFilterMenu.classList.toggle("open");
  });

  document.querySelectorAll(".filter-option").forEach(option => {
    option.addEventListener("click", () => {
      const value = option.dataset.filter || "all";
      currentTypeFilter = value;
      typeFilterLabel.textContent = option.textContent;
      resetVisibleCount();
      typeFilterMenu.classList.remove("open");
      renderCars();
    });
  });

  document.addEventListener("click", (e) => {
    if (!typeFilterToggle.contains(e.target) && !typeFilterMenu.contains(e.target)) {
      typeFilterMenu.classList.remove("open");
    }
  });
}

// Filtre concession
const concessionSelect = document.getElementById("concessionFilter");
if (concessionSelect) {
  concessionSelect.addEventListener("change", (e) => {
    currentConcessionFilter = e.target.value;
    resetVisibleCount();
    renderCars();
  });
}

// Filtre statut
const statusSelect = document.getElementById("statusFilter");
if (statusSelect) {
  statusSelect.addEventListener("change", (e) => {
    currentStatusFilter = e.target.value;
    resetVisibleCount();
    renderCars();
  });
}

// Tri
const sortSelect = document.getElementById("sortSelect");
if (sortSelect) {
  sortSelect.addEventListener("change", (e) => {
    currentSort = e.target.value;
    resetVisibleCount();
    renderCars();
  });
}

// Bouton "Afficher plus" (+)
const loadMoreBtn = document.getElementById("loadMoreBtn");
if (loadMoreBtn) {
  loadMoreBtn.addEventListener("click", () => {
    visibleCount += LOAD_STEP;
    renderCars();
  });
}

// Supprimer des véhicules
const deleteBtn = document.querySelector(".btn-delete");
if (deleteBtn) {
  deleteBtn.addEventListener("click", () => {
    if (!deleteMode) {
      deleteMode = true;
      selectedForDelete.clear();
      document.body.classList.add("delete-mode");
      deleteBtn.textContent = "❌ Supprimer la sélection";
    } else {
      if (selectedForDelete.size === 0) {
        alert("Sélectionne au moins un véhicule à supprimer.");
        return;
      }
      const ok = confirm(`Supprimer ${selectedForDelete.size} véhicule(s) ?`);
      if (!ok) return;

      voitures = voitures.filter(v => !selectedForDelete.has(v.plaque));
      selectedForDelete.clear();
      deleteMode = false;
      document.body.classList.remove("delete-mode");
      deleteBtn.textContent = "🗑 Supprimer des véhicules";

      resetVisibleCount();
      renderCars();
    }
  });
}

// Menu Tour de contrôle
const controlToggle = document.getElementById("controlToggle");
const controlMenu   = document.getElementById("controlMenu");

if (controlToggle && controlMenu) {
  controlToggle.addEventListener("click", () => {
    controlMenu.classList.toggle("open");
  });
}

// ================== 6. INIT ==================
resetVisibleCount();
renderCars();
