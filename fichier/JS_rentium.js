const PROJECT_ROOT = "/rentium_mvc_1";
const API_LIST = `${PROJECT_ROOT}/api/voitures_list.php`;

const INITIAL_COUNT = 6;
const STEP_COUNT = 3;

const UI = {
  grid: "#carGrid",
  loadMoreBtn: "#loadMoreBtn",
  resultsCount: "#resultsCount",
  availableCount: "#availableCount",

  search: "#searchInput",
  concession: "#concessionFilter",
  statut: "#statusFilter",
  sort: "#sortSelect",

  typeToggle: "#typeFilterToggle",
  typeMenu: "#typeFilterMenu",
  typeLabel: "#typeFilterLabel",
  typeOptions: "#typeFilterMenu .filter-option"
};

const state = {
  type: "all",
  offset: 0,
  total: 0
};

const $ = (s) => document.querySelector(s);
const $$ = (s) => Array.from(document.querySelectorAll(s));

function setText(sel, txt) {
  const el = $(sel);
  if (el) el.textContent = txt;
}

function setVisible(sel, visible) {
  const el = $(sel);
  if (!el) return;
  el.style.display = visible ? "" : "none";
}

/* ============ API ============ */
function buildUrl(limit, offset) {
  const params = new URLSearchParams();

  const q = ($(UI.search)?.value ?? "").trim();
  const concession = ($(UI.concession)?.value ?? "all");
  const statut = ($(UI.statut)?.value ?? "all");
  const sort = ($(UI.sort)?.value ?? "none");

  if (q) params.set("q", q);

  params.set("type", state.type || "all");
  params.set("concession", concession);
  params.set("statut", statut);
  params.set("sort", sort);

  params.set("limit", String(limit));
  params.set("offset", String(offset));

  return `${API_LIST}?${params.toString()}`;
}

async function fetchPage(limit, offset) {
  const url = buildUrl(limit, offset);
  const res = await fetch(url, { cache: "no-store" });
  if (!res.ok) throw new Error(`HTTP ${res.status} - ${url}`);

  const text = await res.text();
  let json;
  try { json = JSON.parse(text); }
  catch {
    console.error("API non-JSON (réponse brute):", text);
    throw new Error("API non-JSON (voir console)");
  }

  if (!json.success) throw new Error(json.error || "Erreur API");
  return json;
}

/* ============ RENDER ============ */
function cardHTML(v) {
  const imgFile = (v.image && String(v.image).trim() !== "") ? String(v.image).trim() : "logo-rentium.png";
  const imgPath = `${PROJECT_ROOT}/${imgFile}`;

  return `
    <article class="vehicule-card">
      <div class="vehicule-card__img">
        <img src="${imgPath}" alt="${v.marque ?? ""} ${v.modele ?? ""}" loading="lazy"
             onerror="this.onerror=null;this.src='${PROJECT_ROOT}/logo-rentium.png';">
      </div>

      <div class="vehicule-card__body">
        <div class="vehicule-card__title">
          <h3>${v.marque ?? ""} ${v.modele ?? ""}</h3>
          ${v.statut ? `<span class="badge">${v.statut}</span>` : ""}
        </div>

        <div class="vehicule-card__meta">
          ${v.type ? `<span>${v.type}</span>` : ""}
          ${v.annee ? `<span>${v.annee}</span>` : ""}
          ${v.kilometrage !== undefined ? `<span>${v.kilometrage} km</span>` : ""}
          ${v.concession ? `<span>Concession ${v.concession}</span>` : ""}
        </div>

        <div class="vehicule-card__footer">
          ${v.prix !== undefined ? `<div class="vehicule-card__price">${v.prix} €</div>` : ""}
        </div>
      </div>
    </article>
  `;
}

function clearGrid() {
  const grid = $(UI.grid);
  if (grid) grid.innerHTML = "";
}

function appendCards(rows) {
  const grid = $(UI.grid);
  if (!grid) return;
  grid.insertAdjacentHTML("beforeend", rows.map(cardHTML).join(""));
}

function updateSummary(total, disponibles) {
  setText(UI.resultsCount, `${total} véhicules trouvés`);
  setText(UI.availableCount, `${disponibles} disponibles`);
}

function updateLoadMore() {
  setVisible(UI.loadMoreBtn, state.offset < state.total);
}

/* ============ LOAD ============ */
async function loadFirst() {
  state.offset = 0;
  clearGrid();

  const json = await fetchPage(INITIAL_COUNT, state.offset);

  state.total = json.total;
  updateSummary(json.total, json.disponibles);

  appendCards(json.data);
  state.offset += json.data.length;

  updateLoadMore();
}

async function loadMore() {
  const json = await fetchPage(STEP_COUNT, state.offset);

  state.total = json.total;
  updateSummary(json.total, json.disponibles);

  appendCards(json.data);
  state.offset += json.data.length;

  updateLoadMore();
}

/* ============ TYPE DROPDOWN ============ */
function bindTypeDropdown() {
  const toggle = $(UI.typeToggle);
  const menu = $(UI.typeMenu);
  const label = $(UI.typeLabel);

  if (!toggle || !menu || !label) return;

  menu.style.display = "none";

  toggle.addEventListener("click", (e) => {
    e.stopPropagation();
    menu.style.display = (menu.style.display === "none") ? "" : "none";
    toggle.setAttribute("aria-expanded", menu.style.display !== "none" ? "true" : "false");
  });

  $$(UI.typeOptions).forEach(btn => {
    btn.addEventListener("click", async () => {
      state.type = btn.dataset.filter || "all";
      label.textContent = (state.type === "all") ? "Tous les types" : state.type;
      menu.style.display = "none";
      toggle.setAttribute("aria-expanded", "false");
      await loadFirst();
    });
  });

  document.addEventListener("click", () => {
    menu.style.display = "none";
    toggle.setAttribute("aria-expanded", "false");
  });
}

/* ============ INIT ============ */
document.addEventListener("DOMContentLoaded", async () => {
  if (!$(UI.grid)) return;

  $(UI.loadMoreBtn)?.addEventListener("click", loadMore);

  $(UI.concession)?.addEventListener("change", loadFirst);
  $(UI.statut)?.addEventListener("change", loadFirst);
  $(UI.sort)?.addEventListener("change", loadFirst);

  const s = $(UI.search);
  if (s) {
    s.addEventListener("input", () => {
      clearTimeout(s.__t);
      s.__t = setTimeout(loadFirst, 200);
    });
  }

  bindTypeDropdown();

  try {
    await loadFirst();
  } catch (e) {
    console.error(e);
    alert(`Impossible de charger les véhicules. Détail: ${e.message}`);
  }
});
