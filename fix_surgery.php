<?php
$html = file_get_contents('resources/views/admin/dashboard.blade.php');
$parts = explode("@extends('layouts.app')", $html);
$topHtml = $parts[0];

$script = <<<JS
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
            const res = await fetch(`\${HOST}/categories`);
            categoriesData = await res.json();
            
            const catsContainer = document.getElementById('place-categories');
            const dropdown = document.getElementById('filter-dropdown');
            
            catsContainer.innerHTML = '';
            
            categoriesData.forEach(cat => {
                catsContainer.innerHTML += `
                <label class="flex items-center gap-3 p-2 hover:bg-white rounded-xl cursor-pointer transition-colors group">
                    <input class="rounded-lg border-outline-variant text-primary focus:ring-primary h-5 w-5 cat-checkbox" type="checkbox" value="\${cat.id}"/>
                    <span class="text-sm font-semibold text-on-surface-variant group-hover:text-primary transition-colors">\${cat.name}</span>
                </label>`;
                
                dropdown.innerHTML += `<a class="block px-4 py-3 text-xs font-bold hover:bg-[#f7edff] text-on-surface" href="#" onclick="window.filterCategory(\${cat.id}); return false;">\${cat.name}</a>`;
            });
        }

        let currentFilter = null;
        window.filterCategory = function(catId) {
            currentFilter = catId;
            renderPlaces();
        };

        // Fetch places
        async function loadPlaces() {
            const res = await fetch(`\${HOST}/places`);
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
                html: `<svg width="24" height="34" viewBox="0 0 24 34" xmlns="http://www.w3.org/2000/svg"><path d="M12 0C5.373 0 0 5.373 0 12c0 8.5 12 22 12 22s12-13.5 12-22C24 5.373 18.627 0 12 0zm0 17c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5z" fill="\${color}"/></svg>`,
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
                    
                    m.bindPopup(`<b>\${place.name}</b><br>\${place.address || ''}<br><small>\${place.category ? place.category.name : ''}</small><br><br><button class="btn btn-danger btn-sm w-100 delete-btn text-white bg-red-600 px-2 py-1 rounded" data-id="\${place.id}">Esborrar</button>`);
                    activeMarkers.push(m);
                    
                    // Stitch List Item
                    const catName = place.category ? place.category.name : 'SENSE CATEGORIA';
                    const iconName = place.category && place.category.icon ? place.category.icon : 'location_on';
                    
                    listContainer.innerHTML += `
                    <div class="grid grid-cols-12 gap-4 items-center bg-surface-container-lowest px-8 py-4 rounded-3xl shadow-sm border border-white hover:border-primary/20 transition-all group">
                        <div class="col-span-4 flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-secondary-container flex items-center justify-center text-on-secondary-container shrink-0">
                                <span class="material-symbols-outlined text-xl">\${iconName}</span>
                            </div>
                            <div class="truncate">
                                <h4 class="font-black text-sm text-on-surface truncate">\${place.name}</h4>
                            </div>
                        </div>
                        <div class="col-span-4 flex items-center gap-2 text-xs text-on-surface-variant font-medium truncate">
                            <span class="material-symbols-outlined text-[16px] text-primary">location_on</span>
                            \${place.address}
                        </div>
                        <div class="col-span-2">
                            <span class="text-[9px] font-black text-primary uppercase tracking-widest bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/10">\${catName}</span>
                        </div>
                        <div class="col-span-2 flex justify-end gap-1">
                            <button class="delete-btn w-9 h-9 flex items-center justify-center hover:bg-error/10 text-error rounded-xl transition-colors" data-id="\${place.id}">
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
                    await fetch(`\${HOST}/places/\${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrf } });
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
            const res = await fetch(`\${HOST}/places`, {
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
            
            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=\${encodeURIComponent(query)}`);
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
</body></html>
JS;

file_put_contents('resources/views/admin/dashboard.blade.php', rtrim($topHtml) . "\n" . $script);
echo "Surgery 2 complete.";
