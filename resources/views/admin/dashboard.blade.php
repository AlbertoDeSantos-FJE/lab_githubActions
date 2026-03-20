<!DOCTYPE html>

<html class="light" lang="ca"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Admin Panel - Guia de l'Hospitalet</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "surface-variant": "#e7d6ff",
              "on-primary-container": "#230076",
              "on-secondary-fixed-variant": "#665500",
              "secondary-container": "#ffd709",
              "surface": "#fcf4ff",
              "surface-container": "#f0e3ff",
              "inverse-on-surface": "#a795c3",
              "on-surface": "#36274e",
              "on-secondary": "#fff2cd",
              "on-primary-fixed": "#000000",
              "primary-dim": "#5130c6",
              "inverse-primary": "#937dff",
              "tertiary-fixed-dim": "#ff7a7b",
              "on-error": "#ffefef",
              "on-tertiary-container": "#680011",
              "on-error-container": "#510017",
              "tertiary": "#b71029",
              "on-background": "#36274e",
              "on-secondary-container": "#5b4b00",
              "on-secondary-fixed": "#453900",
              "secondary-fixed": "#ffd709",
              "tertiary-dim": "#a30021",
              "surface-container-lowest": "#ffffff",
              "surface-bright": "#fcf4ff",
              "primary-container": "#a391ff",
              "surface-container-high": "#ecdcff",
              "tertiary-container": "#ff9190",
              "on-primary": "#f6f0ff",
              "on-tertiary-fixed": "#3a0006",
              "background": "#fcf4ff",
              "inverse-surface": "#14052b",
              "error-container": "#f74b6d",
              "secondary-dim": "#5e4e00",
              "primary": "#5d3fd3",
              "surface-container-low": "#f7edff",
              "outline": "#806f9b",
              "primary-fixed-dim": "#9680ff",
              "outline-variant": "#b7a5d4",
              "tertiary-fixed": "#ff9190",
              "surface-tint": "#5d3fd3",
              "on-primary-fixed-variant": "#2c008f",
              "secondary": "#6c5a00",
              "surface-container-highest": "#e7d6ff",
              "on-surface-variant": "#64547e",
              "surface-dim": "#e0cbff",
              "on-tertiary": "#ffefee",
              "primary-fixed": "#a391ff",
              "error": "#b41340",
              "error-dim": "#a70138",
              "secondary-fixed-dim": "#efc900",
              "on-tertiary-fixed-variant": "#790016"
            },
            fontFamily: {
              "headline": ["Plus Jakarta Sans"],
              "body": ["Inter"],
              "label": ["Inter"]
            },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #dcd0ef; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #5d3fd3; }
    </style>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-surface text-on-surface min-h-screen flex overflow-hidden">
<!-- Sidebar Navigation -->
<aside class="hidden md:flex flex-col h-screen w-64 bg-[#f7edff] dark:bg-slate-900 border-r-0 py-6 shrink-0 z-40 font-['Plus_Jakarta_Sans'] text-sm font-medium">
<div class="mb-10 px-6 flex justify-center">
<img alt="Logo" class="h-10 w-auto" src="https://lh3.googleusercontent.com/aida/ADBb0ugZMK3wAYFw6LvogaW0ILthSpwSbN0kXe0YTI0YFDHHjj0PU36bi8iMQOszguZo5rHYIAVm7cbLT7sINDeFmqz7FxzrdKn5GM8aNkVOThTLGkvhxTaaUMXomEqBBc0C0TC7vEnrh6GKqq-NDIQb0kjINpnsdLB2i6YMCISCtXoGVxIhHUmklC2Dq6GqMzNvkFubXbRblirqj7eJnZckgR0Uf-uE_0cj2ICRvvwCgMjXDZQmOmCt5Md1E5NfTDMDeo-c93-N7qfhEQ"/>
</div>
<nav class="flex flex-col space-y-2">
<a class="bg-[#5d3fd3] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 transition-all active:translate-x-1 duration-200 shadow-lg shadow-[#5d3fd3]/30" href="#">
<span class="material-symbols-outlined text-xl" data-icon="location_on" style="font-variation-settings: 'FILL' 1;">location_on</span>
<span>Llocs</span>
</a>
<a class="text-slate-600 dark:text-slate-400 mx-2 my-1 px-4 py-3 flex items-center gap-3 hover:bg-[#a391ff]/20 dark:hover:bg-[#5d3fd3]/20 rounded-lg transition-all active:translate-x-1 duration-200" href="#">
<span class="material-symbols-outlined text-xl" data-icon="extension">extension</span>
<span>Gimcanes</span>
</a>
<a class="text-slate-600 dark:text-slate-400 mx-2 my-1 px-4 py-3 flex items-center gap-3 hover:bg-[#a391ff]/20 dark:hover:bg-[#5d3fd3]/20 rounded-lg transition-all active:translate-x-1 duration-200" href="#">
<span class="material-symbols-outlined text-xl" data-icon="category">category</span>
<span>Categories</span>
</a>
<a class="text-slate-600 dark:text-slate-400 mx-2 my-1 px-4 py-3 flex items-center gap-3 hover:bg-[#a391ff]/20 dark:hover:bg-[#5d3fd3]/20 rounded-lg transition-all active:translate-x-1 duration-200" href="#">
<span class="material-symbols-outlined text-xl" data-icon="group">group</span>
<span>Usuaris</span>
</a>
</nav>
</aside>
<!-- Main Content Canvas -->
<main class="flex-1 flex flex-col relative overflow-hidden h-screen">
<!-- TopAppBar -->
<header class="sticky top-0 z-50 flex justify-between items-center w-full px-6 py-3 bg-[#fcf4ff] dark:bg-slate-950 border-b border-[#f7edff] dark:border-slate-900 font-['Plus_Jakarta_Sans'] antialiased">
<div class="flex items-center gap-6">
<h2 class="text-[#5d3fd3] dark:text-[#a391ff] font-black tracking-tight text-xl">Gestió de Llocs</h2>
<div class="hidden lg:flex items-center bg-[#f7edff] dark:bg-slate-900 px-4 py-2 rounded-2xl w-80 group focus-within:ring-2 focus-within:ring-[#5d3fd3]/20 transition-all">
<span class="material-symbols-outlined text-lg text-slate-600 dark:text-slate-400 mr-3" data-icon="search">search</span>
<input class="bg-transparent border-none text-sm focus:ring-0 p-0 w-full placeholder:text-slate-600/50" placeholder="Cerca llocs o rutes..." type="text"/>
</div>
</div>
<div class="flex items-center gap-2">
<div class="relative group">
<button class="flex items-center gap-1 px-3 py-1.5 rounded-lg hover:bg-[#f7edff] dark:hover:bg-slate-800 transition-all text-xs font-bold text-[#5d3fd3] dark:text-[#a391ff] active:opacity-80 active:scale-95">
<span class="material-symbols-outlined text-sm" data-icon="language">language</span>
<span>CA</span>
<span class="material-symbols-outlined text-[14px]" data-icon="expand_more">expand_more</span>
</button>
<div class="absolute right-0 top-full mt-1 w-32 bg-white dark:bg-slate-800 rounded-lg shadow-xl border border-outline-variant/20 hidden group-hover:block overflow-hidden z-50">
<a class="block px-4 py-2 text-xs hover:bg-[#f7edff] dark:hover:bg-slate-700 text-on-surface" href="#">Català</a>
<a class="block px-4 py-2 text-xs hover:bg-[#f7edff] dark:hover:bg-slate-700 text-on-surface" href="#">Español</a>
<a class="block px-4 py-2 text-xs hover:bg-[#f7edff] dark:hover:bg-slate-700 text-on-surface" href="#">English</a>
</div>
</div>
<div class="h-6 w-[1px] bg-surface-container-highest mx-1"></div>
<button class="p-2.5 dark:text-slate-400 hover:bg-[#f7edff] dark:hover:bg-slate-800 transition-colors rounded-2xl active:opacity-80 active:scale-95 transition-all text-[#5d3fd3]" id="dark-mode-toggle">
<span class="material-symbols-outlined" data-icon="dark_mode">dark_mode</span>
</button>
<form method="POST" action="{{ route('logout') }}" class="inline">@csrf<button type="submit" class="p-2.5 text-[#5d3fd3] hover:bg-[#5d3fd3]/10 transition-colors rounded-2xl active:opacity-80 active:scale-95 transition-all"><span class="material-symbols-outlined" data-icon="logout">logout</span></button></form>
<div class="ml-2 w-8 h-8 rounded-full bg-surface-container-highest overflow-hidden border border-[#5d3fd3]/20 cursor-pointer">
<img alt="Admin user profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDfto521M3O06b0GivjHze8HMXvDGY7ht3tlg_RdfE0iQXyngCB4RRMxdKSNT_W6rHs9VMnHchQqzi4y2mDB_aKh0MXn7fKMEfWORBX7SQL3gD2vaEY-BlQQFLzzCze-zDt110_NdnCYzQDgMFvVVTKSojsSKCQIitgoD8V3TRLZIcHQ4E2566DV6sOocLYOxCC4FLC8JcQVR4Iyiy68IOZJ2EGHKQZNM-563gyzkPW8HB3E-uKN0p-QgOYUvuOxj2nhS-qCN6Zyd8"/>
</div>
</div>
</header>
<!-- Dashboard Layout -->
<div class="flex-1 overflow-y-auto p-8 flex flex-col gap-8 bg-surface/50">
<!-- Top Section: Map and Add Place -->
<div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-stretch shrink-0">
<!-- Central Map Section -->
<div class="xl:col-span-8 flex flex-col gap-4">
<div class="h-full min-h-[500px] bg-surface-container-lowest rounded-[2rem] overflow-hidden relative shadow-[0_24px_48px_-12px_rgba(54,39,78,0.1)] group border border-white">
<div id="main-map" class="absolute inset-0 z-0"></div>
<!-- Markers -->



</div>
</div>
<!-- Add Place Form -->
<div class="xl:col-span-4 bg-surface-container-lowest rounded-[2rem] p-8 shadow-[0_24px_48px_-12px_rgba(54,39,78,0.06)] flex flex-col gap-6 border border-white">
<div>
<h3 class="font-black text-xl text-on-surface tracking-tight">Afegir Nou Lloc</h3>
<p class="text-xs text-on-surface-variant mt-1">Dades del nou punt d'interès per a la ruta.</p>
</div>
<div class="space-y-4 flex-1">
<div class="space-y-1.5">
<label class="text-[10px] font-black text-on-surface-variant uppercase tracking-[0.15em] px-1">Nom del Lloc</label>
<input class="w-full bg-surface-container-low border border-surface-container-highest/20 rounded-2xl text-sm px-5 py-3 focus:ring-4 focus:ring-primary/10 transition-all placeholder:text-outline-variant outline-none" id="place_name" placeholder="Ex: Restaurant L'H" type="text"/>
</div>
<div class="space-y-1.5">
<label class="text-[10px] font-black text-on-surface-variant uppercase tracking-[0.15em] px-1">Adreça</label>
<div class="relative">
<input class="w-full bg-surface-container-low border border-surface-container-highest/20 rounded-2xl text-sm px-5 py-3 focus:ring-4 focus:ring-primary/10 transition-all placeholder:text-outline-variant outline-none" id="place_address" placeholder="Carrer de l'Hospitalet, 42" type="text"/>
<button type="button" id="btn-search-coords" class="absolute right-4 top-2.5 text-primary text-xl hover:scale-110 transition-all"><span class="material-symbols-outlined" data-icon="search">search</span></button>
</div>
</div>
<div class="grid grid-cols-2 gap-4">
<div class="space-y-1.5">
<label class="text-[10px] font-black text-on-surface-variant uppercase tracking-[0.15em] px-1">Latitud</label>
<input class="w-full bg-surface-container-low border border-surface-container-highest/20 rounded-2xl text-sm px-5 py-3 outline-none" id="place_lat" readonly placeholder="41.3597" type="text"/>
</div>
<div class="space-y-1.5">
<label class="text-[10px] font-black text-on-surface-variant uppercase tracking-[0.15em] px-1">Longitud</label>
<input class="w-full bg-surface-container-low border border-surface-container-highest/20 rounded-2xl text-sm px-5 py-3 outline-none" id="place_lng" readonly placeholder="2.1003" type="text"/>
</div>
</div>
<div class="space-y-2">
<label class="text-[10px] font-black text-on-surface-variant uppercase tracking-[0.15em] px-1">Categories</label>
<div id="place-categories" class="bg-surface-container-low border border-surface-container-highest/20 rounded-2xl p-4 max-h-[160px] overflow-y-auto space-y-2"></div></div></div>
<button id="btn-save-place" type="button" class="w-full bg-primary text-on-primary font-black py-4 rounded-2xl flex items-center justify-center gap-2 hover:bg-primary-dim shadow-xl shadow-primary/30 transition-all active:scale-95 text-sm uppercase tracking-widest mt-auto">
<span class="material-symbols-outlined" data-icon="add_location">add_location</span>
                    Guardar Punt
                </button>
</div>
</div>
<!-- Expanded Places List Section -->
<div class="flex flex-col gap-6">
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
<div>
<h3 class="font-black text-2xl text-on-surface tracking-tight">Llistat de Llocs</h3>
<p class="text-sm text-on-surface-variant font-medium">Gestiona els elements existents a la base de dades.</p>
</div>
<div class="flex items-center gap-3 w-full md:w-auto">
<div class="relative group w-full md:w-48">
<button class="w-full px-4 py-2.5 bg-surface-container-lowest text-on-surface font-bold rounded-2xl text-xs flex items-center justify-between gap-2 hover:bg-surface-container-highest transition-all border border-white shadow-sm">
<span class="flex items-center gap-2">
<span class="material-symbols-outlined text-lg text-primary" data-icon="filter_alt">filter_alt</span>
                                Filtrar per Categoria
                            </span>
<span class="material-symbols-outlined text-lg" data-icon="expand_more">expand_more</span>
</button>
<div id="filter-dropdown" class="absolute right-0 top-full mt-2 w-full bg-white rounded-2xl shadow-xl border border-outline-variant/10 hidden group-hover:block overflow-hidden z-20"><a class="block px-4 py-3 text-xs font-bold hover:bg-[#f7edff] text-on-surface" href="#" onclick="window.filterCategory(null); return false;">Totes</a></div></div>
<button class="px-6 py-2.5 bg-primary text-on-primary font-black rounded-2xl text-xs flex items-center gap-2 hover:bg-primary-dim transition-all shadow-sm">
<span class="material-symbols-outlined text-lg" data-icon="download">download</span>
                        Exportar
                    </button>
</div>
</div>
<!-- Header Row -->
<div class="grid grid-cols-12 gap-4 px-8 py-3 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">
<div class="col-span-4">Nom i Localització</div>
<div class="col-span-4">Adreça</div>
<div class="col-span-2">Categoria</div>
<div class="col-span-2 text-right">Accions</div>
</div>
<!-- List of Items (Extended) --><div id="places-list" class="flex flex-col gap-3"></div><!-- Spacer for bottom padding -->
<!-- Pagination Component -->
<div class="flex justify-end items-center gap-2 mt-4 px-2">
<button class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest border border-white text-on-surface-variant hover:bg-primary hover:text-on-primary hover:border-primary transition-all shadow-sm active:scale-90 disabled:opacity-50 disabled:pointer-events-none">
<span class="material-symbols-outlined text-xl">chevron_left</span>
</button>
<div class="flex items-center gap-2">
<button class="w-10 h-10 flex items-center justify-center rounded-xl bg-primary text-on-primary font-black text-xs shadow-lg shadow-primary/20 transition-all">1</button>
<button class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest border border-white text-on-surface-variant font-black text-xs hover:bg-surface-container-highest transition-all shadow-sm active:scale-90">2</button>
<button class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest border border-white text-on-surface-variant font-black text-xs hover:bg-surface-container-highest transition-all shadow-sm active:scale-90">3</button>
<span class="text-on-surface-variant font-black px-1 text-xs">...</span>
<button class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest border border-white text-on-surface-variant font-black text-xs hover:bg-surface-container-highest transition-all shadow-sm active:scale-90">10</button>
</div>
<button class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest border border-white text-on-surface-variant hover:bg-primary hover:text-on-primary hover:border-primary transition-all shadow-sm active:scale-90">
<span class="material-symbols-outlined text-xl">chevron_right</span>
</button>
</div><div class="h-12 shrink-0"></div>
</div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const HOST = '/admin'; // API base path
        const map = L.map('main-map').setView([41.3663, 2.1167], 14); // Hospitalet center approx
        
        // OSM Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let activeMarkers = [];
        let placesData = [];
        let categoriesData = [];
        let tempMarker = null;

        // Fetch categories to populate select & filters
        async function loadCategories() {
            const res = await fetch(`${HOST}/categories`);
            categoriesData = await res.json();
            
            const catsContainer = document.getElementById('place-categories');
            const dropdown = document.getElementById('filter-dropdown');
            
            catsContainer.innerHTML = '';
            
            categoriesData.forEach(cat => {
                catsContainer.innerHTML += `
                <label class="flex items-center gap-3 p-2 hover:bg-white rounded-xl cursor-pointer transition-colors group">
                    <input class="rounded-lg border-outline-variant text-primary focus:ring-primary h-5 w-5 cat-checkbox" type="checkbox" value="${cat.id}"/>
                    <span class="text-sm font-semibold text-on-surface-variant group-hover:text-primary transition-colors">${cat.name}</span>
                </label>`;
                
                dropdown.innerHTML += `<a class="block px-4 py-3 text-xs font-bold hover:bg-[#f7edff] text-on-surface" href="#" onclick="window.filterCategory(${cat.id}); return false;">${cat.name}</a>`;
            });
        }

        let currentFilter = null;
        window.filterCategory = function(catId) {
            currentFilter = catId;
            renderPlaces();
        };

        // Fetch places
        async function loadPlaces() {
            const res = await fetch(`${HOST}/places`);
            placesData = await res.json();
            renderPlaces();
        }

        function getMarkerColor(catId) {
            const colors = ['red', 'blue', 'green', 'orange', 'purple', 'black', 'grey'];
            return colors[catId % colors.length];
        }

        function createCustomIcon(catId) {
            const color = getMarkerColor(catId);
            return L.divIcon({
                html: `<svg width="24" height="34" viewBox="0 0 24 34" xmlns="http://www.w3.org/2000/svg"><path d="M12 0C5.373 0 0 5.373 0 12c0 8.5 12 22 12 22s12-13.5 12-22C24 5.373 18.627 0 12 0zm0 17c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5z" fill="${color}"/></svg>`,
                className: "",
                iconSize: [24, 34],
                iconAnchor: [12, 34],
                popupAnchor: [0, -32]
            });
        }

        function renderPlaces() {
            // Map markers
            activeMarkers.forEach(m => map.removeLayer(m));
            activeMarkers = [];
            
            const listContainer = document.getElementById('places-list');
            listContainer.innerHTML = '';
            
            placesData.forEach(place => {
                if(currentFilter === null || place.category_id === currentFilter) {
                    
                    // Map Marker
                    let m = L.marker([place.latitude, place.longitude], {
                        icon: createCustomIcon(place.category_id)
                    }).addTo(map);
                    
                    m.bindPopup(`<b>${place.name}</b><br>${place.address || ''}<br><small>${place.category ? place.category.name : ''}</small><br><br><button class="btn btn-danger btn-sm w-100 delete-btn text-white bg-red-600 px-2 py-1 rounded" data-id="${place.id}">Esborrar</button>`);
                    activeMarkers.push(m);
                    
                    // Stitch List Item
                    const catName = place.category ? place.category.name : 'SENSE CATEGORIA';
                    const iconName = place.category && place.category.icon ? place.category.icon : 'location_on';
                    
                    listContainer.innerHTML += `
                    <div class="grid grid-cols-12 gap-4 items-center bg-surface-container-lowest px-8 py-4 rounded-3xl shadow-sm border border-white hover:border-primary/20 transition-all group">
                        <div class="col-span-4 flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-secondary-container flex items-center justify-center text-on-secondary-container shrink-0">
                                <span class="material-symbols-outlined text-xl">${iconName}</span>
                            </div>
                            <div class="truncate">
                                <h4 class="font-black text-sm text-on-surface truncate">${place.name}</h4>
                            </div>
                        </div>
                        <div class="col-span-4 flex items-center gap-2 text-xs text-on-surface-variant font-medium truncate">
                            <span class="material-symbols-outlined text-[16px] text-primary">location_on</span>
                            ${place.address}
                        </div>
                        <div class="col-span-2">
                            <span class="text-[9px] font-black text-primary uppercase tracking-widest bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/10">${catName}</span>
                        </div>
                        <div class="col-span-2 flex justify-end gap-1">
                            <button class="delete-btn w-9 h-9 flex items-center justify-center hover:bg-error/10 text-error rounded-xl transition-colors" data-id="${place.id}">
                                <span class="material-symbols-outlined text-lg pointer-events-none">delete</span>
                            </button>
                        </div>
                    </div>`;
                }
            });

            // Re-bind delete buttons in both popups and list
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', async function(e) {
                    const id = e.target.getAttribute('data-id') || e.target.closest('.delete-btn').getAttribute('data-id');
                    const csrf = document.querySelector('meta[name="csrf-token"]').content;
                    await fetch(`${HOST}/places/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrf } });
                    loadPlaces();
                });
            });
        }

        // Add places logic
        document.getElementById('btn-save-place').addEventListener('click', async function(e) {
            const checkedCats = document.querySelectorAll('.cat-checkbox:checked');
            const catId = checkedCats.length > 0 ? checkedCats[0].value : null;

            const payload = {
                name: document.getElementById('place_name').value,
                address: document.getElementById('place_address').value,
                latitude: document.getElementById('place_lat').value,
                longitude: document.getElementById('place_lng').value,
                category_id: catId
            };

            if(!payload.name || !payload.latitude || !catId){
                alert("Nom, Coordenades i Categoria són obligatoris.");
                return;
            }

            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            const res = await fetch(`${HOST}/places`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: JSON.stringify(payload)
            });

            if(res.ok) {
                document.getElementById('place_name').value = '';
                document.getElementById('place_address').value = '';
                document.getElementById('place_lat').value = '';
                document.getElementById('place_lng').value = '';
                checkedCats.forEach(c => c.checked = false);
                
                if(tempMarker) map.removeLayer(tempMarker);
                loadPlaces();
                alert('Lloc creat amb èxit!');
            } else {
                alert("Error afegint el lloc. Verifica les dades.");
            }
        });

        // Click map to select coordinates
        map.on('click', function(e) {
            document.getElementById('place_lat').value = e.latlng.lat.toFixed(6);
            document.getElementById('place_lng').value = e.latlng.lng.toFixed(6);
            
            if(tempMarker) map.removeLayer(tempMarker);
            tempMarker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map).bindPopup("Nova Ubicació").openPopup();
        });

        // Geocoding with basic Nominatim fetch
        document.getElementById('btn-search-coords').addEventListener('click', async function() {
            const query = document.getElementById('place_address').value;
            if(!query) return alert("Introdueix una adreça per buscar.");
            
            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
            const data = await res.json();
            
            if(data && data.length > 0) {
                const lat = data[0].lat;
                const lon = data[0].lon;
                map.setView([lat, lon], 16);
                
                document.getElementById('place_lat').value = lat;
                document.getElementById('place_lng').value = lon;
                
                if(tempMarker) map.removeLayer(tempMarker);
                tempMarker = L.marker([lat, lon]).addTo(map).bindPopup("Ubicació trobada!").openPopup();
            } else {
                alert("No s'ha trobat l'adreça especificada.");
            }
        });

        // Init
        loadCategories().then(loadPlaces);
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleSpans = document.querySelectorAll('span[data-icon="dark_mode"], span[data-icon="light_mode"]');
    
    toggleSpans.forEach(span => {
        const target = span.closest('button') || span;
        target.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            
            // update all icons
            toggleSpans.forEach(s => {
                s.textContent = isDark ? 'light_mode' : 'dark_mode';
                s.setAttribute('data-icon', isDark ? 'light_mode' : 'dark_mode');
            });
            
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    });
    
    // Check preference
    if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        toggleSpans.forEach(s => {
            s.textContent = 'light_mode';
            s.setAttribute('data-icon', 'light_mode');
        });
    } else {
        document.documentElement.classList.remove('dark');
    }
});
</script>
</body></html>