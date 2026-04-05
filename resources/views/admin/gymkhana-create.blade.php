@extends('layouts.admin')

@section('title', __('Nova Gimcana'))
@section('header_title', __('Nova Gimcana'))

@push('head')
{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
{{-- SortableJS --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<style>
    #poi-map { height: 420px; }

    /* Custom Leaflet popup styling */
    .custom-popup .leaflet-popup-content-wrapper {
        border-radius: 10px;
        padding: 0;
        overflow: hidden;
        box-shadow: 0 20px 40px -8px rgba(0,0,0,.25);
        border: 1px solid #f1f5f9;
        min-width: 240px;
    }
    .custom-popup .leaflet-popup-tip-container { display: none; }
    .custom-popup .leaflet-popup-content { margin: 0; width: auto !important; }

    /* Sortable ghost */
    .sortable-ghost { opacity: .35; background: #f0e3ff !important; }
    .sortable-chosen { cursor: grabbing; }

    /* Dynamic size to fit 3 cards with 2 gap-5 (1.25rem = 20px) */
    .editor-card-width { width: calc((100% - 2.5rem) / 3 - 0.5px); min-width: 240px; }

    /* Horizontal editor scrollbar */
    #editor-strip { scrollbar-width: thin; scrollbar-color: #5D3FD3 transparent; }
    .dark #editor-strip { scrollbar-color: #8b5cf6 transparent; }
    #editor-strip::-webkit-scrollbar { height: 8px; }
    #editor-strip::-webkit-scrollbar-track { background: transparent; }
    #editor-strip::-webkit-scrollbar-thumb { background: #5D3FD3; border-radius: 4px; }
    .dark #editor-strip::-webkit-scrollbar-thumb { background: #8b5cf6; }

    /* Number spinner hide arrows */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; }

    /* MCQ correct-answer checkbox row highlight */
    .opt-row { transition: background .15s; border-radius: 6px; padding: 3px 4px; }
    .opt-row.is-correct { background: #f0fdf4; }
    .dark .opt-row.is-correct { background: rgba(34,197,94,.12); }
</style>
@endpush

@section('content')
<div class="flex flex-col gap-8 min-w-0">

    {{-- ── Breadcrumb / Header ───────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                <a href="{{ route('admin.gymkhanas') }}" class="hover:text-primary transition-colors">{{ __('Gestió de Gimcanes') }}</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-primary">{{ isset($gymkhana) ? __('Editar Gimcana') : __('Nova Gimcana') }}</span>
            </div>
            <h2 class="text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100">{{ isset($gymkhana) ? __('Editar Gimcana') : __('Crear Nova Gimcana') }}</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">{{ __('Configura els punts, les proves i el grup mínim.') }}</p>
        </div>
        <a href="{{ route('admin.gymkhanas') }}"
           class="flex items-center gap-2 px-5 py-3 rounded-[10px] bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-black text-sm hover:bg-slate-200 dark:hover:bg-slate-700 transition-all uppercase tracking-widest w-max">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            {{ __('Tornar') }}
        </a>
    </div>

    {{-- ── Bloc 1: Dades Generals ────────────────────────────────────────── --}}
    <div class="bg-white dark:bg-slate-900 rounded-[10px] border border-slate-100 dark:border-slate-800 shadow-sm p-8">
        <div class="mb-6">
            <h3 class="text-lg font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Dades Generals') }}</h3>
            <p class="text-xs text-slate-400 dark:text-slate-500 font-medium mt-0.5">{{ __('Nom i descripció de la gimcana') }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
            <!-- Left Column: Name & Description -->
            <div class="space-y-4 flex flex-col h-full">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 ml-1">{{ __('Nom de la Gimcana') }} <span class="text-red-400">*</span></label>
                    <input id="gym-name" type="text" placeholder="{{ __('Ex: Misteris de Bellvitge') }}" value="{{ isset($gymkhana) ? $gymkhana->name : '' }}"
                        class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] px-5 py-4 focus:ring-4 focus:ring-primary/10 outline-none placeholder:text-slate-400 dark:text-slate-100 transition-all font-medium text-sm" />
                </div>
                <div class="space-y-2 flex-1 flex flex-col">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 ml-1">{{ __('Descripció') }} <span class="font-normal normal-case">({{ __('opcional') }})</span></label>
                    <textarea id="gym-description" placeholder="{{ __('Breu descripció de la gimcana') }}"
                        class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] px-5 py-4 focus:ring-4 focus:ring-primary/10 outline-none placeholder:text-slate-400 dark:text-slate-100 transition-all font-medium text-sm resize-none flex-1 h-[80px]">{{ isset($gymkhana) ? $gymkhana->description : '' }}</textarea>
                </div>
            </div>

            <!-- Right Column: Image Drop Zone -->
            <div class="space-y-2 flex flex-col h-full">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 ml-1">{{ __('Imatge Principal') }} <span class="font-normal normal-case">({{ __('opcional') }})</span></label>
                <div id="drop-zone-gym" class="relative flex-1 w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-2 border-dashed border-primary/20 rounded-[10px] flex flex-col items-center justify-center p-4 transition-all hover:bg-[#e8d5ff] dark:hover:bg-slate-800 hover:border-primary cursor-pointer group min-h-[140px]">
                    <input type="file" id="gym_image" class="hidden" accept="image/*">
                    <div class="flex flex-col items-center gap-2 pointer-events-none">
                        <span class="material-symbols-outlined text-4xl text-primary animate-bounce-slow">image</span>
                        <div class="text-center">
                            <p id="gym-image-name" class="text-xs font-black text-slate-700 dark:text-slate-200">{{ __('Arrossega o selecciona una imatge') }}</p>
                            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 mt-1 uppercase">{{ __('PNG, JPG fins a 5MB') }}</p>
                        </div>
                    </div>
                    <div id="gym-image-preview" class="{{ isset($gymkhana) && $gymkhana->image ? '' : 'hidden' }} absolute inset-0 rounded-[10px] overflow-hidden bg-white dark:bg-slate-900 border-2 border-primary">
                        <img src="{{ isset($gymkhana) && $gymkhana->image ? asset('storage/' . $gymkhana->image) : '' }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-slate-900/10 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity pointer-events-none">
                            <span class="material-symbols-outlined text-white text-3xl drop-shadow-lg">image</span>
                        </div>
                        <div class="absolute bottom-3 right-3 flex gap-2">
                            <button type="button" id="btn-delete-gym-image" class="w-10 h-10 bg-red-500 text-white flex items-center justify-center rounded-[10px] shadow-lg border border-red-600/20 hover:scale-105 active:scale-95 transition-all">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                            <button type="button" id="btn-change-gym-image" class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm text-primary font-black px-4 py-2 rounded-[10px] text-[10px] uppercase tracking-widest shadow-lg border border-primary/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">cached</span>
                                {{ __('Canviar') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Bloc 2: Selecció de Punts ─────────────────────────────────────── --}}
    <div class="bg-white dark:bg-slate-900 rounded-[10px] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-8 py-5 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-lg font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Selecció de Punts d\'Interès') }}</h3>
                <p class="text-xs text-slate-400 dark:text-slate-500 font-medium mt-0.5">{{ __('Fes clic al marcador per afegir-lo o arrossega\'l a la llista de la dreta') }}</p>
            </div>
            <div class="flex items-center gap-2 bg-primary/10 dark:bg-primary/20 text-primary rounded-[10px] px-4 py-2">
                <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">pin_drop</span>
                <span id="points-count" class="font-black text-sm">0 {{ __('punts') }}</span>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-0">
            {{-- Map --}}
            <div class="flex-1 relative border-r border-slate-100 dark:border-slate-800">
                <div id="poi-map" class="w-full h-full"></div>
                <!-- Map Controls -->
                <div class="absolute bottom-6 right-6 z-[400] flex flex-col gap-2">
                    <button id="btn-locate" type="button" class="w-10 h-10 bg-white dark:bg-slate-800 rounded-[10px] shadow-lg flex items-center justify-center text-slate-600 dark:text-slate-300 hover:text-primary transition-colors border border-slate-100 dark:border-slate-700" title="{{ __('Centrar a la meva ubicació') }}">
                        <span class="material-symbols-outlined text-[20px]">my_location</span>
                    </button>
                    <button id="btn-reset-map" type="button" class="w-10 h-10 bg-white dark:bg-slate-800 rounded-[10px] shadow-lg flex items-center justify-center text-slate-600 dark:text-slate-300 hover:text-primary transition-colors border border-slate-100 dark:border-slate-700" title="{{ __('Restablir zoom i vista') }}">
                        <span class="material-symbols-outlined text-[20px]">zoom_in_map</span>
                    </button>
                </div>
            </div>

            {{-- Selected Points List --}}
            <div class="w-full lg:w-72 flex flex-col" style="min-height:420px">
                <div class="px-5 py-3 bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm text-slate-400">drag_pan</span>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">{{ __('Ordre de la Gimcana') }}</p>
                </div>
                <div id="selected-points-list"
                     class="flex-1 overflow-y-auto p-4 space-y-2"
                     style="max-height:380px">
                    <p id="empty-list-msg" class="text-xs text-slate-400 dark:text-slate-500 text-center font-medium pt-12 px-4 leading-relaxed">
                        <span class="material-symbols-outlined text-4xl block mb-2 text-slate-300 dark:text-slate-700">touch_app</span>
                        {{ __('Fes clic a un punt al mapa per afegir-lo aquí') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Bloc 3: Editor de Proves i Pistes ────────────────────────────── --}}
    <div class="bg-white dark:bg-slate-900 rounded-[10px] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden min-w-0 max-w-full">
        <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-lg font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Editor de Proves i Pistes') }}</h3>
            <p class="text-xs text-slate-400 dark:text-slate-500 font-medium mt-0.5">{{ __('Defineix la pregunta, la resposta i la pista per a cada punt') }}</p>
        </div>

        <div id="editor-strip-wrap" class="px-6 py-6 w-full max-w-full relative">
            <div id="editor-empty" class="text-center py-12 text-slate-300 dark:text-slate-700">
                <span class="material-symbols-outlined text-5xl block mb-2">preview</span>
                <p class="text-sm font-bold text-slate-400 dark:text-slate-600">{{ __('Afegeix punts al mapa per veure els editors') }}</p>
            </div>
            <div id="editor-strip" class="flex gap-5 overflow-x-auto pb-4 hidden w-full custom-scrollbar min-w-0 max-w-full"></div>
        </div>
    </div>

    {{-- ── Bloc 4: Configuració del Grup ─────────────────────────────────── --}}
    <div class="bg-white dark:bg-slate-900 rounded-[10px] border border-slate-100 dark:border-slate-800 shadow-sm p-8">
        <div class="mb-6">
            <h3 class="text-lg font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Configuració del Grup') }}</h3>
            <p class="text-xs text-slate-400 dark:text-slate-500 font-medium mt-0.5">{{ __('Nombre mínim de membres per formar un grup') }}</p>
        </div>
        <div class="max-w-xs space-y-2">
            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 ml-1">{{ __('Membres Mínims') }} <span class="text-red-400">*</span></label>
            <div class="flex items-center gap-3">
                <button id="btn-dec" type="button"
                    class="w-12 h-12 rounded-[10px] bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-black text-xl flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                    −
                </button>
                <input id="gym-min-members" type="number" min="2" max="50" value="{{ isset($gymkhana) ? $gymkhana->min_members : 2 }}"
                    class="w-12 h-12 text-center bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] focus:ring-4 focus:ring-primary/10 outline-none font-black text-xl text-slate-900 dark:text-slate-100" />
                <button id="btn-inc" type="button"
                    class="w-12 h-12 rounded-[10px] bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-black text-xl flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                    +
                </button>
            </div>
            <p class="text-xs text-slate-400 dark:text-slate-500 font-medium ml-1">{{ __('Mínim 2 membres, màxim 50') }}</p>
        </div>
    </div>

    {{-- ── Submit ─────────────────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row gap-4 pb-8">
        <button id="btn-save-gym" type="button"
            class="flex-1 bg-primary text-white py-5 rounded-[10px] font-black shadow-xl shadow-primary/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3 uppercase tracking-widest text-sm">
            <span class="material-symbols-outlined text-xl">save</span>
            <span id="btn-save-text">{{ isset($gymkhana) ? __('Guardar Canvis') : __('Crear Gimcana') }}</span>
        </button>
        <a href="{{ route('admin.gymkhanas') }}"
            class="sm:w-48 py-5 rounded-[10px] font-black bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-sm">
            {{ __('Cancel·lar') }}
        </a>
    </div>
</div>

{{-- ── Alert Modal ──────────────────────────────────────────────────────── --}}
<div id="gym-info-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 w-full max-w-sm rounded-[10px] p-10 shadow-2xl border border-slate-100 dark:border-slate-800 scale-95 transition-transform duration-300">
        <div class="w-16 h-16 bg-primary/10 rounded-[10px] flex items-center justify-center mb-6 mx-auto">
            <span id="gym-info-icon" class="material-symbols-outlined text-3xl text-primary">info</span>
        </div>
        <div class="text-center mb-8">
            <h3 id="gym-info-title" class="text-xl font-black text-slate-900 dark:text-slate-100 tracking-tight mb-2">{{ __('Avís') }}</h3>
            <p id="gym-info-msg" class="text-sm text-slate-500 dark:text-slate-400 font-medium leading-relaxed"></p>
        </div>
        <button id="gym-info-close"
            class="w-full bg-primary text-white py-4 rounded-[10px] font-black hover:bg-primary/90 transition-all uppercase tracking-widest text-xs shadow-lg shadow-primary/20">
            {{ __('D\'acord') }}
        </button>
    </div>
</div>
@endsection

@push('scripts')
{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrf    = document.querySelector('meta[name="csrf-token"]').content;
    const allPlaces = @json($places);

    // ── Alert helper ────────────────────────────────────────────────────────
    const gymInfoModal  = document.getElementById('gym-info-modal');
    const gymInfoInner  = gymInfoModal.querySelector('div');
    const gymInfoMsg    = document.getElementById('gym-info-msg');
    const gymInfoTitle  = document.getElementById('gym-info-title');
    const gymInfoIcon   = document.getElementById('gym-info-icon');

    function showAlert(title, message, type = 'info') {
        const icons = { info:'info', warning:'warning', error:'error', success:'check_circle' };
        gymInfoTitle.textContent = title;
        gymInfoMsg.textContent   = message;
        gymInfoIcon.textContent  = icons[type] || 'info';
        gymInfoIcon.className    = `material-symbols-outlined text-3xl ${type === 'error' ? 'text-red-500' : type === 'success' ? 'text-emerald-500' : 'text-primary'}`;
        gymInfoModal.classList.remove('hidden');
        setTimeout(() => {
            gymInfoModal.classList.remove('opacity-0');
            gymInfoInner.classList.remove('scale-95');
        }, 10);
    }
    function closeAlert() {
        gymInfoModal.classList.add('opacity-0');
        gymInfoInner.classList.add('scale-95');
        setTimeout(() => gymInfoModal.classList.add('hidden'), 300);
    }
    document.getElementById('gym-info-close').addEventListener('click', closeAlert);
    gymInfoModal.addEventListener('click', e => { if (e.target === gymInfoModal) closeAlert(); });

    // ── Selected points state ────────────────────────────────────────────────
    let selectedPoints = []; // Array of place objects

    // ── Image Upload Logic ───────────────────────────────────────────────────
    const dropZone = document.getElementById('drop-zone-gym');
    const gymImageInput = document.getElementById('gym_image');
    const imagePreview = document.getElementById('gym-image-preview');
    const previewImg = imagePreview.querySelector('img');

    function handleGymFiles(files) {
        if (files.length > 0) {
            const file = files[0];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    document.getElementById('gym-image-name').textContent = file.name;
                };
                reader.readAsDataURL(file);
                
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                gymImageInput.files = dataTransfer.files;
            } else {
                showAlert('{{ __("Error") }}', '{{ __("Només s\'accepten imatges.") }}', 'error');
            }
        }
    }

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-primary', 'bg-[#e8d5ff]', 'dark:bg-slate-800');
    });

    ['dragleave', 'dragend'].forEach(type => {
        dropZone.addEventListener(type, () => {
            dropZone.classList.remove('border-primary', 'bg-[#e8d5ff]', 'dark:bg-slate-800');
        });
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-primary', 'bg-[#e8d5ff]', 'dark:bg-slate-800');
        handleGymFiles(e.dataTransfer.files);
    });

    dropZone.addEventListener('click', (e) => {
        if (e.target.closest('#btn-delete-gym-image') || e.target.closest('#btn-change-gym-image')) return;
        gymImageInput.click();
    });

    gymImageInput.addEventListener('change', function() { handleGymFiles(this.files); });

    document.getElementById('btn-delete-gym-image').addEventListener('click', (e) => {
        e.stopPropagation();
        gymImageInput.value = '';
        imagePreview.classList.add('hidden');
        previewImg.src = '';
        document.getElementById('gym-image-name').textContent = '{{ __("Arrossega o selecciona una imatge") }}';
    });

    document.getElementById('btn-change-gym-image').addEventListener('click', (e) => {
        e.stopPropagation();
        gymImageInput.click();
    });

    // ── Leaflet Map ──────────────────────────────────────────────────────────
    const initialCenter = [41.359, 2.099];
    const initialZoom   = 14;

    const map = L.map('poi-map', { zoomControl: true }).setView(initialCenter, initialZoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(map);

    // Map Controls Logic
    document.getElementById('btn-reset-map').addEventListener('click', () => {
        map.setView(initialCenter, initialZoom);
    });

    document.getElementById('btn-locate').addEventListener('click', () => {
        map.locate({setView: true, maxZoom: 16});
    });

    map.on('locationfound', function(e) {
        if (window.userMarker) {
            window.userMarker.setLatLng(e.latlng);
        } else {
            window.userMarker = L.circleMarker(e.latlng, {
                radius: 8,
                fillColor: "#3b82f6",
                color: "#fff",
                weight: 2,
                opacity: 1,
                fillOpacity: 0.8
            }).addTo(map);
        }
    });

    map.on('locationerror', function(e) {
        console.error(e);
        alert("No s'ha pogut obtenir la ubicació.");
    });

    // Build custom marker icon
    function makeMarkerIcon(color = '#5D3FD3', selected = false) {
        const size   = selected ? 38 : 30;
        const shadow = selected ? '0 4px 16px rgba(93,63,211,.5)' : '0 2px 8px rgba(0,0,0,.3)';
        return L.divIcon({
            className: '',
            html: `<div style="width:${size}px;height:${size}px;border-radius:50%;background:${color};border:3px solid white;box-shadow:${shadow};display:flex;align-items:center;justify-content:center;">
                       <span class="material-symbols-outlined" style="font-size:${selected?18:14}px;color:white;font-variation-settings:'FILL' 1;">location_on</span>
                   </div>`,
            iconAnchor: [size/2, size/2],
            popupAnchor: [0, -(size/2 + 4)]
        });
    }

    const leafletMarkers = {}; // place.id → L.marker

    function isSelected(placeId) {
        return selectedPoints.some(p => p.id === placeId);
    }

    function refreshMarkerIcon(place) {
        const marker = leafletMarkers[place.id];
        if (!marker) return;
        const color = place.category?.color || '#5D3FD3';
        marker.setIcon(makeMarkerIcon(color, isSelected(place.id)));
    }

    allPlaces.forEach(place => {
        if (!place.latitude || !place.longitude) return;
        const color  = place.category?.color || '#5D3FD3';
        const marker = L.marker([place.latitude, place.longitude], {
            icon: makeMarkerIcon(color, false)
        }).addTo(map);

        leafletMarkers[place.id] = marker;

        marker.on('click', () => {
            // Close any open popup first, then open this one
            map.closePopup();
            const sel = isSelected(place.id);
            const imgHtml = `<img src="${place.image ? '/storage/' + place.image : '/images/placeholder-poi.png'}" class="w-full h-28 object-cover" />`;

            const catBadge = place.category
                ? `<span style="background:${place.category.color}22;color:${place.category.color}" class="text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-[6px]">${place.category.name}</span>`
                : '';

            const btnLabel = sel
                ? `<span class="material-symbols-outlined text-sm align-middle">check_circle</span> {{ __('Ja afegit') }}`
                : `<span class="material-symbols-outlined text-sm align-middle">add_location</span> {{ __('Afegir punt') }}`;
            const btnClass = sel
                ? 'w-full py-2.5 rounded-[8px] font-black text-xs uppercase tracking-widest flex items-center justify-center gap-1.5 bg-slate-100 text-slate-500 cursor-default'
                : 'w-full py-2.5 rounded-[8px] font-black text-xs uppercase tracking-widest flex items-center justify-center gap-1.5 bg-primary text-white shadow-lg shadow-primary/30 hover:scale-[1.01] transition-all cursor-pointer';

            const popupContent = `
                <div class="overflow-hidden rounded-[10px] bg-white dark:bg-slate-900 shadow-xl border border-slate-100 dark:border-slate-800">
                    <div class="w-full">
                        ${imgHtml}
                    </div>
                    <div class="p-4 space-y-2">
                        <div class="flex items-start justify-between gap-2">
                            <p class="font-black text-slate-900 text-sm leading-tight">${place.name}</p>
                            ${catBadge}
                        </div>
                        ${place.address ? `<p class="text-xs text-slate-500 flex items-center gap-1"><span class="material-symbols-outlined text-sm">location_on</span>${place.address}</p>` : ''}
                        ${place.description ? `<p class="text-xs text-slate-500 leading-relaxed line-clamp-2">${place.description}</p>` : ''}
                        <button id="popup-add-btn-${place.id}" class="${btnClass}" ${sel ? 'disabled' : ''}>
                            ${btnLabel}
                        </button>
                    </div>
                </div>`;

            const popup = L.popup({ className: 'custom-popup', maxWidth: 260, closeButton: true })
                .setContent(popupContent)
                .setLatLng(marker.getLatLng())
                .openOn(map);

            // Bind add button a tick after popup content is in DOM
            setTimeout(() => {
                const btn = document.getElementById(`popup-add-btn-${place.id}`);
                if (btn && !isSelected(place.id)) {
                    btn.addEventListener('click', () => {
                        map.closePopup();
                        addPoint(place);
                    });
                }
            }, 50);
        });
    });

    // Fit bounds if places exist
    const coords = allPlaces.filter(p => p.latitude && p.longitude).map(p => [p.latitude, p.longitude]);
    if (coords.length) {
        try { map.fitBounds(coords, { padding: [30, 30], maxZoom: 15 }); } catch(e) {}
    }

    // ── SortableJS on the list ───────────────────────────────────────────────
    const sortableList = document.getElementById('selected-points-list');
    const sortable = Sortable.create(sortableList, {
        animation: 150,
        handle: '.drag-handle',
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        onEnd: syncEditorOrder
    });

    // ── Add / Remove point logic ─────────────────────────────────────────────
    function addPoint(place) {
        if (isSelected(place.id)) return;
        selectedPoints.push(place);
        renderListItem(place);
        renderEditorCard(place);
        refreshMarkerIcon(place);
        updatePointsCount();
    }

    function removePoint(placeId) {
        selectedPoints = selectedPoints.filter(p => p.id !== placeId);
        const listItem = document.querySelector(`#list-item-${placeId}`);
        if (listItem) listItem.remove();
        const card = document.querySelector(`#editor-card-${placeId}`);
        if (card) card.remove();
        const place = allPlaces.find(p => p.id === placeId);
        if (place) refreshMarkerIcon(place);
        updatePointsCount();
        toggleEditorVisibility();
    }

    function renderListItem(place) {
        const emptyMsg = document.getElementById('empty-list-msg');
        if (emptyMsg) emptyMsg.style.display = 'none';

        const color  = place.category?.color || '#5D3FD3';
        const item   = document.createElement('div');
        item.id      = `list-item-${place.id}`;
        item.dataset.placeId = place.id;
        item.className = 'flex items-center gap-3 bg-slate-50 dark:bg-slate-800 rounded-[10px] px-3 py-2.5 group border border-slate-100 dark:border-slate-700 hover:border-primary/30 transition-all';
        item.innerHTML = `
            <div class="drag-handle cursor-grab text-slate-300 dark:text-slate-600 hover:text-primary transition-colors shrink-0">
                <span class="material-symbols-outlined text-lg">drag_indicator</span>
            </div>
            <div class="w-7 h-7 rounded-[6px] flex items-center justify-center shrink-0" style="background:${color}22;">
                <span class="material-symbols-outlined text-sm" style="color:${color};font-variation-settings:'FILL' 1;">location_on</span>
            </div>
            <p class="flex-1 text-xs font-black text-slate-700 dark:text-slate-200 truncate">${place.name}</p>
            <button onclick="removePointById(${place.id})"
                class="w-6 h-6 flex items-center justify-center rounded-[6px] text-slate-300 hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 transition-all text-sm shrink-0">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>`;
        sortableList.appendChild(item);
    }

    function renderEditorCard(place) {
        const strip = document.getElementById('editor-strip');
        const empty = document.getElementById('editor-empty');
        if (empty) empty.classList.add('hidden');
        strip.classList.remove('hidden');

        const card = document.createElement('div');
        card.id    = `editor-card-${place.id}`;
        card.dataset.placeId = place.id;
        card.className = 'flex-shrink-0 editor-card-width bg-slate-50 dark:bg-slate-800 rounded-[10px] border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col';

        const color   = place.category?.color || '#5D3FD3';
        const imgHtml = `<img src="${place.image ? '/storage/' + place.image : '/images/placeholder-poi.png'}" class="w-full h-24 object-cover" />`;

        // 4-option MCQ: letter badge + text input + right-side checkbox
        const letters = ['A', 'B', 'C', 'D'];
        const optRows = letters.map((l, i) => `
            <div class="opt-row flex items-center gap-2 ${i === 0 ? 'is-correct' : ''}">
                <span class="w-5 h-5 rounded-[4px] flex items-center justify-center text-[9px] font-black shrink-0"
                    style="background:${color}22;color:${color}">${l}</span>
                <input id="opt-${place.id}-${i}" type="text"
                    placeholder="{{ __('Opció') }} ${l}..."
                    class="flex-1 min-w-0 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-700 rounded-[6px] px-2 py-1.5 text-xs font-medium text-slate-700 dark:text-slate-200 outline-none focus:ring-2 focus:ring-primary/20 placeholder:text-slate-300" />
                <input type="checkbox"
                    class="correct-check rounded-[10px] border-slate-300 dark:border-slate-600 text-primary focus:ring-primary h-4 w-4 dark:bg-slate-900 cursor-pointer shrink-0"
                    data-group="place-${place.id}" data-idx="${i}"
                    title="{{ __('Resposta correcta') }}"
                    ${i === 0 ? 'checked' : ''}>
            </div>`).join('');

        card.innerHTML = `
            ${imgHtml}
            <div class="p-4 flex flex-col gap-3 flex-1">
                <div class="flex items-start justify-between gap-2">
                    <p class="font-black text-slate-900 dark:text-slate-100 text-sm leading-tight">${place.name}</p>
                    <span class="text-[9px] font-black uppercase tracking-widest px-2 py-1 rounded-[6px] whitespace-nowrap" style="background:${color}22;color:${color}">${place.category?.name || ''}</span>
                </div>
                <div id="clue-block-${place.id}" class="space-y-1">
                    <label class="text-[9px] font-black uppercase tracking-[0.15em] text-slate-400">{{ __('Pista per trobar el punt') }}</label>
                    <textarea id="c-${place.id}" rows="2" placeholder="{{ __('Pista per trobar aquest punt...') }}"
                        class="w-full bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-700 rounded-[8px] px-3 py-2 text-xs font-medium text-slate-700 dark:text-slate-200 outline-none focus:ring-2 focus:ring-primary/20 resize-none placeholder:text-slate-300"></textarea>
                </div>
                <div class="space-y-1">
                    <label class="text-[9px] font-black uppercase tracking-[0.15em] text-slate-400">{{ __('Pregunta / Prova') }} <span class="text-red-400">*</span></label>
                    <textarea id="q-${place.id}" rows="2" placeholder="{{ __('Escriu la pregunta...') }}"
                        class="w-full bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-700 rounded-[8px] px-3 py-2 text-xs font-medium text-slate-700 dark:text-slate-200 outline-none focus:ring-2 focus:ring-primary/20 resize-none placeholder:text-slate-300"></textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-[9px] font-black uppercase tracking-[0.15em] text-slate-400">{{ __('Opcions de Resposta') }} <span class="text-red-400">*</span> <span class="normal-case font-medium text-slate-400">({{ __('marca la correcta') }})</span></label>
                    <div class="space-y-1.5">${optRows}</div>
                </div>
            </div>`;
        strip.appendChild(card);
    }

    // Sync editor card order to match the drag list
    function syncEditorOrder() {
        const strip   = document.getElementById('editor-strip');
        const listIds = [...sortableList.querySelectorAll('[data-place-id]')].map(el => el.dataset.placeId);
        listIds.forEach(placeId => {
            const card = document.getElementById(`editor-card-${placeId}`);
            if (card) strip.appendChild(card);
        });
        // Rebuild selectedPoints in new order
        selectedPoints = listIds.map(id => allPlaces.find(p => String(p.id) === id)).filter(Boolean);
    }

    function updatePointsCount() {
        document.getElementById('points-count').textContent = `${selectedPoints.length} {{ __('punts') }}`;
    }

    function toggleEditorVisibility() {
        const strip = document.getElementById('editor-strip');
        const empty = document.getElementById('editor-empty');
        if (selectedPoints.length === 0) {
            strip.classList.add('hidden');
            if (empty) empty.classList.remove('hidden');
            const emptyMsg = document.getElementById('empty-list-msg');
            if (emptyMsg) emptyMsg.style.display = '';
        }
    }

    // Expose globally for onclick in list items
    window.removePointById = function(placeId) {
        removePoint(placeId);
    };

    // ── MCQ checkbox mutual exclusion (one correct per card) ─────────────────
    document.getElementById('editor-strip').addEventListener('change', function (e) {
        const cb = e.target;
        if (!cb.classList.contains('correct-check')) return;
        const group = cb.dataset.group;
        if (cb.checked) {
            // Uncheck every other option in the same card and remove highlight
            document.querySelectorAll(`.correct-check[data-group="${group}"]`).forEach(other => {
                if (other !== cb) {
                    other.checked = false;
                    other.closest('.opt-row')?.classList.remove('is-correct');
                }
            });
            cb.closest('.opt-row')?.classList.add('is-correct');
        } else {
            // Prevent unchecking: at least one must be correct
            cb.checked = true;
        }
    });

    // ── Stepper buttons ──────────────────────────────────────────────────────
    const minInput = document.getElementById('gym-min-members');
    document.getElementById('btn-dec').addEventListener('click', () => {
        const v = parseInt(minInput.value) || 2;
        if (v > 2) minInput.value = v - 1;
    });
    document.getElementById('btn-inc').addEventListener('click', () => {
        const v = parseInt(minInput.value) || 2;
        if (v < 50) minInput.value = v + 1;
    });

    // ── Save ─────────────────────────────────────────────────────────────────
    document.getElementById('btn-save-gym').addEventListener('click', async function () {
        const name       = document.getElementById('gym-name').value.trim();
        const descr      = document.getElementById('gym-description').value.trim();
        const minMembers = parseInt(document.getElementById('gym-min-members').value) || 2;

        if (!name) {
            showAlert('{{ __("Camp obligatori") }}', '{{ __("El nom de la gimcana és obligatori.") }}', 'warning');
            return;
        }
        if (selectedPoints.length === 0) {
            showAlert('{{ __("Sense punts") }}', '{{ __("Afegeix almenys un punt d\'interès.") }}', 'warning');
            return;
        }

        // Build ordered points from list DOM order
        const listIds = [...sortableList.querySelectorAll('[data-place-id]')].map(el => parseInt(el.dataset.placeId));
        const points  = listIds.map(placeId => {
            const correctIdx   = parseInt(document.querySelector(`.correct-check[data-group="place-${placeId}"]:checked`)?.dataset.idx ?? 0);
            const answerOptions = [0, 1, 2, 3].map(i => (document.getElementById(`opt-${placeId}-${i}`)?.value || '').trim());
            const clueEl       = document.getElementById(`c-${placeId}`);
            return {
                place_id:       placeId,
                question:       (document.getElementById(`q-${placeId}`)?.value || '').trim(),
                answer_options: answerOptions,
                correct_index:  correctIdx,
                next_clue:      (clueEl?.value || '').trim() || null,
            };
        });

        // Validate required fields per point
        for (const pt of points) {
            const place = allPlaces.find(p => p.id === pt.place_id);
            if (!pt.question) {
                showAlert('{{ __("Camp obligatori") }}', `{{ __("Has d\'escriure la pregunta per al punt") }}: ${place?.name || pt.place_id}`, 'warning');
                return;
            }
            const filledOpts = pt.answer_options.filter(o => o.length > 0);
            if (filledOpts.length < 4) {
                showAlert('{{ __("Camp obligatori") }}', `{{ __("Has d\'omplir les 4 opcions de resposta per al punt") }}: ${place?.name || pt.place_id}`, 'warning');
                return;
            }
        }

        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined text-xl animate-spin">progress_activity</span> {{ __("Guardant...") }}';

        const formData = new FormData();
        formData.append('name', name);
        formData.append('description', descr);
        formData.append('min_members', minMembers);
        if (gymImageInput.files.length > 0) {
            formData.append('image', gymImageInput.files[0]);
        }

        points.forEach((pt, index) => {
            formData.append(`points[${index}][place_id]`, pt.place_id);
            formData.append(`points[${index}][question]`, pt.question);
            formData.append(`points[${index}][correct_index]`, pt.correct_index);
            if (pt.next_clue) {
                formData.append(`points[${index}][next_clue]`, pt.next_clue);
            }
            pt.answer_options.forEach((opt, optIndex) => {
                formData.append(`points[${index}][answer_options][${optIndex}]`, opt);
            });
        });

        try {
            const isEdit = {{ isset($gymkhana) ? 'true' : 'false' }};
            const endpoint = isEdit ? '{{ isset($gymkhana) ? route("admin.gymkhanas.update", $gymkhana->id) : "" }}' : '{{ route("admin.gymkhanas.store") }}';
            const method = isEdit ? 'POST' : 'POST'; // We use POST with _method=PUT or just standard PUT
            
            if (isEdit) {
                formData.append('_method', 'PUT');
            }

            const res  = await fetch(endpoint, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: formData
            });
            const data = await res.json();

            if (data.success) {
                showAlert(@json(__('Gimcana creada!')), @json(__("La gimcana s'ha creat correctament.")), 'success');
                document.getElementById('gym-info-close').addEventListener('click', () => {
                    window.location.href = '{{ route("admin.gymkhanas") }}';
                }, { once: true });
            } else {
                const errorMsg = data.errors
                    ? Object.values(data.errors).flat().join(' ')
                    : (data.message || '{{ __("Error desconegut") }}');
                showAlert('{{ __("Error") }}', errorMsg, 'error');
                btn.disabled = false;
                btn.innerHTML = '<span class="material-symbols-outlined text-xl">save</span> {{ __("Crear Gimcana") }}';
            }
        } catch(e) {
            showAlert('{{ __("Error") }}', '{{ __("Error de xarxa. Torna-ho a intentar.") }}', 'error');
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined text-xl">save</span> {{ __("Crear Gimcana") }}';
        }
    });
    // ── Pre-fill Edit Data ───────────────────────────────────────────────────
    @if(isset($gymkhana))
        const editGymData = @json($gymkhana);
        editGymData.points.forEach(pt => {
            const place = allPlaces.find(p => p.id === pt.place_id);
            if (place) {
                addPoint(place);
                
                const qEl = document.getElementById(`q-${place.id}`);
                if (qEl) qEl.value = pt.question || '';
                
                const cEl = document.getElementById(`c-${place.id}`);
                if (cEl) cEl.value = pt.next_clue || '';
                
                if (pt.answer_options) {
                    pt.answer_options.forEach((opt, idx) => {
                        const optEl = document.getElementById(`opt-${place.id}-${idx}`);
                        if (optEl) optEl.value = opt || '';
                    });
                }
                
                const checkEl = document.querySelector(`.correct-check[data-group="place-${place.id}"][data-idx="${pt.correct_index}"]`);
                if (checkEl) {
                    document.querySelectorAll(`.correct-check[data-group="place-${place.id}"]`).forEach(cb => {
                        cb.checked = false;
                        cb.closest('.opt-row')?.classList.remove('is-correct');
                    });
                    checkEl.checked = true;
                    checkEl.closest('.opt-row')?.classList.add('is-correct');
                }
            }
        });
    @endif
});
</script>
@endpush
