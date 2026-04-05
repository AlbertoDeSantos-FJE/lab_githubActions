@extends('layouts.admin')

@section('title', __('Gestió de Categories'))
@section('header_title', __('Gestió de Categories'))

@push('head')
<style>
    /* CSS Filters for custom icons */
    .filter-primary {
        filter: invert(31%) sepia(80%) saturate(3061%) hue-rotate(242deg) brightness(91%) contrast(92%);
    }
    .filter-slate-400 {
        filter: invert(74%) sepia(10%) saturate(625%) hue-rotate(174deg) brightness(89%) contrast(86%);
    }
    .filter-white {
        filter: brightness(0) invert(1);
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 10px;
        height: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #5D3FD3;
        border-radius: 5px;
    }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #8b5cf6;
    }
    /* Collapsible styles */
    #category-form-content {
        transition: all 0.4s ease-in-out;
    }
    @media (min-width: 1024px) {
        #category-form-content {
            max-height: none !important;
            opacity: 1 !important;
            margin-top: 0 !important;
        }
    }
</style>
@endpush

@section('content')
<div class="flex flex-col lg:grid lg:grid-cols-12 gap-10 items-start">
    <!-- Categories List -->
    <div class="order-2 lg:order-none col-span-12 lg:col-span-8 space-y-4 w-full">
        <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4">
            <div>
                <h3 class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Llistat de Categories') }}</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">{{ __('Visualitza i gestiona l\'estat de les categories existents.') }}</p>
            </div>
            <div class="flex bg-white dark:bg-slate-900 p-1.5 rounded-[10px] border border-slate-100 dark:border-slate-800 shadow-sm">
                <button class="px-5 py-2 text-xs font-bold rounded-[10px] bg-primary text-white shadow-lg shadow-primary/20">{{ __('Totes') }}</button>
                <button class="px-5 py-2 text-xs font-bold rounded-[10px] text-slate-500 dark:text-slate-400 hover:text-primary transition-colors">{{ __('Actives') }}</button>
                <button class="px-5 py-2 text-xs font-bold rounded-[10px] text-slate-500 dark:text-slate-400 hover:text-primary transition-colors">{{ __('Inactives') }}</button>
            </div>
        </div>

        <div id="categories-container" class="space-y-4">
            @include('admin.partials.categories-list')
        </div>
    </div>

    <!-- Persistent Form -->
    <div class="order-1 lg:order-none col-span-12 lg:col-span-4 lg:sticky lg:top-32 w-full">
        <div class="bg-white dark:bg-slate-900 rounded-[10px] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
            <!-- Mobile Toggle Header -->
            <div id="toggle-nova-categoria" class="flex lg:hidden items-center justify-between cursor-pointer group px-8 py-4 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                <div>
                    <h3 class="font-black text-xl text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Nova Categoria') }}</h3>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ __('Defineix els paràmetres de la nova categoria.') }}</p>
                </div>
                <span class="material-symbols-outlined text-3xl text-primary transition-transform duration-300 transform" id="nova-categoria-icon">expand_more</span>
            </div>

            <div id="category-form-content" class="px-10 py-5 lg:pt-8 transition-all duration-300">
                <div class="mb-5 hidden lg:block">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Nova Categoria') }}</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">{{ __('Defineix els paràmetres de la nova categoria.') }}</p>
                </div>
                <form id="category-form" class="space-y-4">
                @csrf
                <!-- Category Name -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 ml-1">{{ __('Nom de la Categoria') }}</label>
                    <input id="cat-name" name="name" class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] px-6 py-4 focus:ring-4 focus:ring-primary/10 outline-none placeholder:text-slate-400 dark:text-slate-100 transition-all font-medium text-sm" placeholder="Ex: Vida Nocturna" type="text" required/>
                </div>

                <!-- Description -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 ml-1">{{ __('Descripció (opcional)') }}</label>
                    <textarea id="cat-description" name="description" rows="2" class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] px-6 py-3 focus:ring-4 focus:ring-primary/10 outline-none placeholder:text-slate-400 dark:text-slate-100 transition-all font-medium text-sm resize-none" placeholder="Ex: Monuments històrics i patrimoni cultural"></textarea>
                </div>

                <!-- Color Picker -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 ml-1">{{ __('Color del Marcador') }}</label>
                    <div class="flex items-center gap-4">
                        <input type="color" id="cat-color-picker" class="hidden" value="#5D3FD3">
                        <div id="color-preview" class="w-14 h-14 rounded-[10px] bg-primary shadow-lg border border-white/20 cursor-pointer shrink-0"></div>
                        <div class="flex-1 relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">HEX</span>
                            <input id="cat-color" name="color" class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] pl-16 pr-6 py-4 focus:ring-4 focus:ring-primary/10 outline-none font-mono text-sm font-bold text-slate-900 dark:text-slate-100" type="text" value="#5D3FD3"/>
                        </div>
                    </div>
                </div>

                <!-- Icon Selection -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 ml-1">{{ __('Selecció d\'Icona') }}</label>
                    <input type="hidden" id="cat-icon" name="icon" value="stars">
                    <input type="file" id="custom-icon-file" accept=".svg,image/svg+xml" class="hidden">
                    @php
                        $icons = [
                            /* -- used by existing categories -- */
                            'account_balance', 'park', 'museum', 'restaurant', 'sports_gymnastics',
                            /* -- general POI -- */
                            'stars', 'location_on', 'place', 'map', 'explore',
                            /* -- culture & leisure -- */
                            'theater_comedy', 'movie', 'music_note', 'palette', 'sports_esports',
                            /* -- nature & sport -- */
                            'hiking', 'directions_bike', 'pool', 'fitness_center', 'sports_soccer',
                            /* -- food & drink -- */
                            'local_bar', 'local_cafe', 'local_pizza', 'bakery_dining', 'brunch_dining',
                            /* -- commerce & services -- */
                            'shopping_bag', 'store', 'local_pharmacy', 'local_hospital', 'school',
                            /* -- accommodation & transport -- */
                            'hotel', 'bed', 'directions_car', 'train', 'flight',
                            /* -- religion & heritage -- */
                            'church', 'synagogue', 'mosque', 'castle', 'fort',
                            /* -- misc -- */
                            'photo_camera', 'wb_sunny', 'night_shelter', 'anchor', 'forest',
                        ];

                        // Extract existing custom icons from categories (globally to bypass pagination)
                        $customIcons = \App\Models\Category::pluck('icon')
                            ->filter(fn($icon) => $icon && str_starts_with($icon, 'category-icons/'))
                            ->unique();
                    @endphp
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-[10px] p-3">
                        <div class="grid grid-cols-6 gap-2 max-h-52 overflow-y-auto pr-1 icon-grid-scroll custom-scrollbar">
                            @foreach($icons as $icon)
                            <button class="icon-opt aspect-square flex items-center justify-center rounded-[10px] {{ $icon == 'stars' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-white dark:bg-slate-700 text-slate-400 hover:text-primary hover:border-primary/30 transition-all border border-slate-100 dark:border-slate-600' }}" type="button" data-icon="{{ $icon }}" title="{{ $icon }}">
                                <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">{{ $icon }}</span>
                            </button>
                            @endforeach

                            @foreach($customIcons as $cIcon)
                            <button class="icon-opt aspect-square flex items-center justify-center rounded-[10px] bg-white dark:bg-slate-700 text-slate-400 hover:text-primary hover:border-primary/30 transition-all border border-slate-100 dark:border-slate-600 overflow-hidden" type="button" data-icon="{{ $cIcon }}" title="{{ $cIcon }}">
                                <img src="{{ asset('storage/' . $cIcon) }}" class="w-1/2 h-1/2 object-contain filter-slate-400" alt="custom icon">
                            </button>
                            @endforeach
                            <!-- Custom upload slot -->
                            <button id="btn-custom-icon" type="button" title="{{ __('Pujar icona pròpia') }}"
                                class="aspect-square flex items-center justify-center rounded-[10px] bg-white dark:bg-slate-700 text-slate-400 hover:text-primary hover:border-primary/30 transition-all border border-dashed border-slate-300 dark:border-slate-500 relative">
                                <span id="custom-icon-preview-thumb" class="hidden absolute inset-0 flex items-center justify-center">
                                     <img id="custom-icon-img" class="w-1/2 h-1/2 object-contain" src="" alt="">
                                </span>
                                <span id="custom-icon-placeholder" class="material-symbols-outlined text-lg">add_photo_alternate</span>
                            </button>
                        </div>
                    </div>
                    <!-- Drag & Drop upload panel (hidden by default) -->
                    <div id="icon-upload-panel" class="hidden">
                        <div id="icon-drop-zone"
                            class="relative flex flex-col items-center justify-center gap-3 border-2 border-dashed border-primary/40 bg-primary/5 dark:bg-primary/10 rounded-[10px] p-6 text-center transition-all cursor-pointer"
                            onclick="document.getElementById('custom-icon-file').click()">
                            <span class="material-symbols-outlined text-4xl text-primary">cloud_upload</span>
                            <div>
                                <p class="text-sm font-black text-slate-700 dark:text-slate-200">{{ __('Arrossega la icona SVG aquí') }}</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ __('o fes clic per explorar') }} &bull; Només format SVG</p>
                            </div>
                            <div id="drop-overlay" class="hidden absolute inset-0 rounded-[10px] bg-primary/20 flex items-center justify-center">
                                <span class="material-symbols-outlined text-5xl text-primary animate-bounce">file_download</span>
                            </div>
                        </div>
                        <p id="custom-icon-filename" class="text-[11px] text-primary font-bold mt-2 ml-1 truncate hidden"></p>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-primary text-white py-5 rounded-[10px] font-black shadow-xl shadow-primary/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3 mt-10 uppercase tracking-widest text-sm">
                    <span class="material-symbols-outlined text-xl">save</span>
                    {{ __('CREAR CATEGORIA') }}
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Info / Error Alert Modal -->
<div id="info-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 w-full max-w-sm rounded-[10px] p-10 shadow-2xl border border-slate-100 dark:border-slate-800 scale-95 transition-transform duration-300">
        <div class="w-16 h-16 bg-primary/10 rounded-[10px] flex items-center justify-center mb-6 mx-auto">
            <span id="info-modal-icon" class="material-symbols-outlined text-3xl text-primary">info</span>
        </div>
        <div class="text-center mb-8">
            <h3 id="info-modal-title" class="text-xl font-black text-slate-900 dark:text-slate-100 tracking-tight mb-2">{{ __('Avís') }}</h3>
            <p id="info-modal-msg" class="text-sm text-slate-500 dark:text-slate-400 font-medium leading-relaxed"></p>
        </div>
        <button id="info-modal-close" class="w-full bg-primary text-white py-4 rounded-[10px] font-black hover:bg-primary-dim transition-all uppercase tracking-widest text-xs shadow-lg shadow-primary/20">
            {{ __('D\'acord') }}
        </button>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-[10px] p-10 shadow-2xl border border-slate-100 dark:border-slate-800 scale-95 transition-transform duration-300">
        <div class="w-20 h-20 bg-red-50 dark:bg-red-500/10 rounded-[10px] flex items-center justify-center mb-8 mx-auto">
            <span class="material-symbols-outlined text-4xl text-red-500">warning</span>
        </div>
        <div class="text-center mb-10">
            <h3 class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Eliminar Categoria') }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-3 leading-relaxed">
                {{ __('Si elimines aquesta categoria, tots els llocs associats passaran a la categoria') }} 
                <b class="text-slate-900 dark:text-slate-100 italic">"Sense categoria"</b>.
                <br><br>
                {{ __('Estàs segur que vols continuar?') }}
            </p>
        </div>
        <div class="flex flex-col gap-4">
            <button id="confirm-delete" class="w-full bg-red-500 text-white py-4 rounded-[10px] font-black shadow-xl shadow-red-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest text-xs">
                {{ __('SÍ, ELIMINAR') }}
            </button>
            <button id="cancel-delete" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 py-4 rounded-[10px] font-black hover:bg-slate-100 transition-all uppercase tracking-widest text-xs border border-slate-100 dark:border-slate-700">
                {{ __('CANCEL·LAR') }}
            </button>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="edit-cat-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 w-full max-w-2xl rounded-[10px] p-10 shadow-2xl border border-slate-100 dark:border-slate-800 scale-95 transition-transform duration-300 overflow-y-auto max-h-[90vh]">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Editar Categoria') }}</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">{{ __('Modifica les dades d\'aquesta categoria.') }}</p>
            </div>
            <button id="close-edit-cat-modal" class="w-12 h-12 flex items-center justify-center rounded-[10px] bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-primary transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form id="edit-category-form" class="space-y-6">
            <input type="hidden" id="edit-cat-id">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name and Description -->
                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] px-1">{{ __('Nom de la Categoria') }}</label>
                        <input class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-5 py-3 focus:ring-4 focus:ring-primary/10 transition-all dark:text-slate-100 outline-none font-medium" id="edit-cat-name" type="text" required/>
                    </div>
                    <div class="space-y-1.5 focus-within:z-10 relative">
                        <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] px-1">{{ __('Descripció') }}</label>
                        <textarea class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-5 py-3 focus:ring-4 focus:ring-primary/10 transition-all dark:text-slate-100 outline-none font-medium resize-none" id="edit-cat-description" rows="3"></textarea>
                    </div>
                </div>

                <!-- Color and Icon Preview -->
                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] px-1">{{ __('Color') }}</label>
                        <div class="flex gap-3">
                            <div id="edit-color-preview" class="w-12 h-12 rounded-[10px] shadow-lg border-4 border-white dark:border-slate-800 cursor-pointer transition-transform hover:scale-110 active:scale-95 shrink-0" style="background-color: #5D3FD3;"></div>
                            <input class="flex-1 bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-5 py-3 focus:ring-4 focus:ring-primary/10 transition-all dark:text-slate-100 outline-none font-mono font-bold" id="edit-cat-color" type="text" value="#5D3FD3" maxlength="7"/>
                            <input class="hidden" id="edit-cat-color-picker" type="color" value="#5D3FD3"/>
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] px-1">{{ __('Icona Seleccionada') }}</label>
                        <div class="flex items-center gap-4 bg-[#f0e3ff] dark:bg-slate-800/50 rounded-[10px] px-5 py-2.5">
                            <div id="edit-icon-preview-box" class="w-10 h-10 rounded-[10px] bg-white dark:bg-slate-700 flex items-center justify-center text-primary shadow-sm overflow-hidden">
                                <span class="material-symbols-outlined text-2xl">category</span>
                            </div>
                            <span id="edit-icon-name" class="text-xs font-bold text-slate-500 dark:text-slate-400 truncate">{{ __('Cap icona seleccionada') }}</span>
                            <input type="hidden" id="edit-cat-icon">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Icon Selection Grid -->
            <div class="space-y-3">
                <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] px-1">{{ __('Canviar Icona') }}</label>
                <div class="bg-slate-50 dark:bg-slate-800/50 rounded-[10px] p-4">
                    <div class="flex flex-row gap-3 overflow-x-auto pb-4 edit-icon-grid icon-grid-scroll custom-scrollbar pr-2">
                        @php
                            $materialIcons = [
                                'account_balance', 'park', 'museum', 'restaurant', 'sports_gymnastics',
                                'stars', 'location_on', 'place', 'map', 'explore',
                                'theater_comedy', 'movie', 'music_note', 'palette', 'sports_esports',
                                'hiking', 'directions_bike', 'pool', 'fitness_center', 'sports_soccer',
                                'local_bar', 'local_cafe', 'local_pizza', 'bakery_dining', 'brunch_dining',
                                'shopping_bag', 'store', 'local_pharmacy', 'local_hospital', 'school',
                                'hotel', 'bed', 'directions_car', 'train', 'flight',
                                'church', 'synagogue', 'mosque', 'castle', 'fort',
                                'photo_camera', 'wb_sunny', 'night_shelter', 'anchor', 'forest',
                            ];
                            // Extract existing custom icons from categories (globally to bypass pagination)
                            $editCustomIcons = \App\Models\Category::pluck('icon')
                                ->filter(fn($icon) => $icon && str_starts_with($icon, 'category-icons/'))
                                ->unique();
                        @endphp
                        @foreach($materialIcons as $icon)
                            <button type="button" class="edit-icon-opt aspect-square h-12 flex items-center justify-center rounded-[10px] bg-white dark:bg-slate-700 text-slate-400 hover:text-primary hover:border-primary/30 transition-all border border-slate-100 dark:border-slate-600 shrink-0" data-icon="{{ $icon }}" title="{{ $icon }}">
                                <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">{{ $icon }}</span>
                            </button>
                        @endforeach

                        @foreach($editCustomIcons as $cIcon)
                            <button type="button" class="edit-icon-opt aspect-square h-12 flex items-center justify-center rounded-[10px] bg-white dark:bg-slate-700 text-slate-400 hover:text-primary hover:border-primary/30 transition-all border border-slate-100 dark:border-slate-600 shrink-0 overflow-hidden" data-icon="{{ $cIcon }}" title="{{ $cIcon }}">
                                <img src="{{ asset('storage/' . $cIcon) }}" class="w-1/2 h-1/2 object-contain filter-slate-400" alt="custom icon">
                            </button>
                        @endforeach
                        
                        <!-- Upload Slot -->
                        <div class="relative shrink-0">
                            <input type="file" id="edit-custom-icon-file" class="hidden" accept=".svg,image/svg+xml">
                            <button type="button" id="edit-btn-custom-icon" class="aspect-square h-12 flex items-center justify-center rounded-[10px] bg-white dark:bg-white/10 border-2 border-dashed border-slate-200 dark:border-slate-700 text-slate-400 hover:text-primary hover:border-primary/50 transition-all group overflow-hidden" title="{{ __('Pujar icona personalitzada') }}">
                                <div id="edit-custom-icon-placeholder" class="flex items-center justify-center">
                                    <span class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">add_a_photo</span>
                                </div>
                                <div id="edit-custom-icon-preview-thumb" class="hidden w-full h-full flex items-center justify-center">
                                    <img id="edit-custom-icon-img" src="" class="w-1/2 h-1/2 object-contain filter-primary" alt="custom">
                                </div>
                            </button>
                        </div>
                    </div>
                    <p id="edit-custom-icon-filename" class="text-[9px] text-primary font-bold mt-2 px-2 hidden truncate"></p>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-primary text-white py-5 rounded-[10px] font-black shadow-xl shadow-primary/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3 uppercase tracking-widest text-sm">
                    <span class="material-symbols-outlined text-xl">save</span>
                    {{ __('GUARDAR CANVIS') }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Collapsible Logic ---
        const isMobile = () => window.innerWidth < 1024;
        let isCollapsed = isMobile();

        function setupCollapsible() {
            const toggle = document.getElementById('toggle-nova-categoria');
            const content = document.getElementById('category-form-content');
            const icon = document.getElementById('nova-categoria-icon');

            if (!toggle || !content) return;

            // Initial state based on screen size
            if (isMobile()) {
                content.style.maxHeight = '0px';
                content.style.opacity = '0';
                content.style.marginTop = '0px';
                icon.style.transform = 'rotate(-90deg)';
                isCollapsed = true;
            } else {
                content.style.maxHeight = 'none';
                content.style.opacity = '1';
                content.style.marginTop = '0px';
                icon.style.transform = 'rotate(0deg)';
                isCollapsed = false;
            }

            toggle.addEventListener('click', () => {
                if (!isMobile()) return;

                isCollapsed = !isCollapsed;
                if (!isCollapsed) {
                    content.style.maxHeight = content.scrollHeight + '60px'; // Buffer
                    content.style.opacity = '1';
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    content.style.maxHeight = '0px';
                    content.style.opacity = '0';
                    icon.style.transform = 'rotate(-90deg)';
                }
            });
        }

        setupCollapsible();
        window.addEventListener('resize', () => {
            const content = document.getElementById('category-form-content');
            const icon = document.getElementById('nova-categoria-icon');
            if (!isMobile()) {
                content.style.maxHeight = 'none';
                content.style.opacity = '1';
                icon.style.transform = 'rotate(0deg)';
            } else if (!isCollapsed) {
                content.style.maxHeight = content.scrollHeight + 'px';
            }
        });

        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const categoriesContainer = document.getElementById('categories-container');
        let searchTimeout;

        // --- AJAX Search and Pagination ---
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.placeholder = "{{ __('Cerca categories...') }}";
            @if($search)
                searchInput.value = "{{ $search }}";
            @endif

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    fetchCategories(this.value, 1);
                }, 400);
            });
        }

        async function fetchCategories(search = '', page = 1) {
            categoriesContainer.style.opacity = '0.5';
            
            const url = new URL("{{ route('admin.categories') }}");
            if (search) url.searchParams.set('search', search);
            if (page) url.searchParams.set('page', page);
            
            try {
                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                categoriesContainer.innerHTML = html;
                categoriesContainer.style.opacity = '1';
                
                window.history.pushState({}, '', url);
                bindListEvents();
            } catch (error) {
                console.error('Error fetching categories:', error);
                categoriesContainer.style.opacity = '1';
            }
        }

        // --- Event Binding ---
        function bindListEvents() {
            // Status Toggle
            document.querySelectorAll('.status-toggle').forEach(toggle => {
                toggle.onchange = async function() {
                    const id = this.dataset.id;
                    const container = this.closest('.category-item');
                    try {
                        const res = await fetch(`/admin/categories/${id}/toggle`, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
                        });
                        const data = await res.json();
                        if (data.success) {
                            container.dataset.active = data.active ? 'true' : 'false';
                            container.classList.toggle('opacity-70', !data.active);
                            container.classList.toggle('grayscale-[0.5]', !data.active);
                        }
                    } catch (e) {
                        this.checked = !this.checked;
                    }
                };
            });

            // Delete buttons
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.onclick = function() {
                    categoryToDelete = this.dataset.id;
                    deleteModal.classList.remove('hidden');
                    setTimeout(() => {
                        deleteModal.classList.remove('opacity-0');
                        deleteModal.querySelector('div').classList.remove('scale-95');
                    }, 10);
                };
            });

            // Edit buttons
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.onclick = function() {
                    const data = this.dataset;
                    openEditCatModal(data);
                };
            });

            // AJAX Pagination
            document.querySelectorAll('#categories-container nav a').forEach(link => {
                link.onclick = function(e) {
                    e.preventDefault();
                    const url = new URL(this.href);
                    const page = url.searchParams.get('page');
                    const search = url.searchParams.get('search') || '';
                    fetchCategories(search, page);
                };
            });

            // Filter functionality (Local filtering on top of AJAX)
            const filterBtns = document.querySelectorAll('.flex.bg-white button');
            filterBtns.forEach(btn => {
                btn.onclick = function() {
                    filterBtns.forEach(b => b.classList.remove('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20'));
                    filterBtns.forEach(b => b.classList.add('text-slate-500', 'dark:text-slate-400', 'hover:text-primary'));
                    this.classList.remove('text-slate-500', 'dark:text-slate-400', 'hover:text-primary');
                    this.classList.add('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20');

                    const filterText = this.textContent.trim();
                    const items = document.querySelectorAll('.category-item');
                    
                    items.forEach(item => {
                        const isActive = item.dataset.active === 'true';
                        if (filterText === '{{ __("Totes") }}') {
                            item.classList.remove('hidden');
                        } else if (filterText === '{{ __("Actives") }}') {
                            isActive ? item.classList.remove('hidden') : item.classList.add('hidden');
                        } else if (filterText === '{{ __("Inactives") }}') {
                            !isActive ? item.classList.remove('hidden') : item.classList.add('hidden');
                        }
                    });
                };
            });
        }

        // Initial Bind
        bindListEvents();

        // ── Color Picker ────────────────────────────────────────────────
        const colorInput = document.getElementById('cat-color');
        const colorPicker = document.getElementById('cat-color-picker');
        const colorPreview = document.getElementById('color-preview');
        
        colorPreview.addEventListener('click', () => colorPicker.click());
        colorPicker.addEventListener('input', (e) => {
            colorInput.value = e.target.value.toUpperCase();
            colorPreview.style.backgroundColor = e.target.value;
        });
        colorInput.addEventListener('input', (e) => {
            if (/^#[0-9A-F]{6}$/i.test(e.target.value)) {
                colorPreview.style.backgroundColor = e.target.value;
                colorPicker.value = e.target.value;
            }
        });

        // ── Icon Selection ──────────────────────────────────────────────
        const iconOpts = document.querySelectorAll('.icon-opt:not(#btn-custom-icon)');
        const iconInput = document.getElementById('cat-icon');

        function selectIconBtn(btn) {
            document.querySelectorAll('.icon-opt').forEach(o => {
                o.classList.remove('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20');
                o.classList.add('bg-white', 'dark:bg-slate-700', 'text-slate-400');
                // Reset custom icon filters
                const img = o.querySelector('img');
                if (img) {
                    img.classList.remove('filter-white');
                    img.classList.add('filter-slate-400');
                }
            });
            btn.classList.remove('bg-white', 'dark:bg-slate-700', 'text-slate-400');
            btn.classList.add('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20');
            // Apply selected filter to custom icon image
            const img = btn.querySelector('img');
            if (img) {
                img.classList.remove('filter-slate-400');
                img.classList.add('filter-white');
            }
        }

        iconOpts.forEach(opt => {
            opt.addEventListener('click', function() {
                selectIconBtn(this);
                iconInput.value = this.dataset.icon;
                // If a material icon is chosen, clear any custom file
                customIconFile = null;
                document.getElementById('icon-upload-panel').classList.add('hidden');
                document.getElementById('custom-icon-preview-thumb').classList.add('hidden');
                document.getElementById('custom-icon-placeholder').classList.remove('hidden');
                document.getElementById('custom-icon-filename').classList.add('hidden');
            });
        });

        // ── Custom icon upload ──────────────────────────────────────────
        let customIconFile = null;
        const uploadPanel = document.getElementById('icon-upload-panel');
        const dropZone    = document.getElementById('icon-drop-zone');
        const fileInput   = document.getElementById('custom-icon-file');
        const dropOverlay = document.getElementById('drop-overlay');
        const fileNameEl  = document.getElementById('custom-icon-filename');
        const thumbWrap   = document.getElementById('custom-icon-preview-thumb');
        const thumbImg    = document.getElementById('custom-icon-img');
        const placeholder = document.getElementById('custom-icon-placeholder');
        const btnCustom   = document.getElementById('btn-custom-icon');

        btnCustom.addEventListener('click', function() {
            uploadPanel.classList.toggle('hidden');
        });

        function applyCustomIcon(file) {
            if (file.type !== 'image/svg+xml' && !file.name.toLowerCase().endsWith('.svg')) {
                showAlert('{{ __("Format Incorrecte") }}', '{{ __("Només s\\'accepten fitxers SVGs per a les icones.") }}', 'error');
                return;
            }
            customIconFile = file;
            iconInput.value = '__custom__';
            const reader = new FileReader();
            reader.onload = (ev) => {
                const dataUrl = ev.target.result;

                // 1. Show thumbnail in the upload slot button
                thumbImg.src = dataUrl;
                thumbWrap.classList.remove('hidden');
                placeholder.classList.add('hidden');

                // 2. Insert (or update) a real selectable button in the grid
                const grid = document.querySelector('.icon-grid-scroll');
                let existing = document.getElementById('custom-uploaded-icon-btn');
                if (!existing) {
                    existing = document.createElement('button');
                    existing.id = 'custom-uploaded-icon-btn';
                    existing.type = 'button';
                    existing.title = file.name;
                    existing.dataset.icon = '__custom__';
                    existing.className = 'icon-opt aspect-square flex items-center justify-center rounded-[10px] bg-white dark:bg-slate-700 text-slate-400 hover:text-primary hover:border-primary/30 transition-all border border-slate-100 dark:border-slate-600 overflow-hidden p-0.5';
                    // Insert before the upload slot button at the end
                    grid.insertBefore(existing, document.getElementById('btn-custom-icon'));
                    // Make it selectable like any other icon-opt
                    existing.addEventListener('click', function() {
                        selectIconBtn(this);
                        iconInput.value = '__custom__';
                    });
                }
                existing.innerHTML = `<img src="${dataUrl}" class="w-1/2 h-1/2 object-contain filter-white" alt="custom icon">`;
                // Auto-select the newly added button
                selectIconBtn(existing);
            };
            reader.readAsDataURL(file);
            fileNameEl.textContent = file.name;
            fileNameEl.classList.remove('hidden');
            uploadPanel.classList.add('hidden');
        }

        fileInput.addEventListener('change', function() {
            if (this.files[0]) applyCustomIcon(this.files[0]);
        });

        // Drag & drop events
        ['dragenter','dragover'].forEach(ev => {
            dropZone.addEventListener(ev, function(e) {
                e.preventDefault();
                dropOverlay.classList.remove('hidden');
                dropZone.classList.add('border-primary');
            });
        });
        ['dragleave','dragend'].forEach(ev => {
            dropZone.addEventListener(ev, function() {
                dropOverlay.classList.add('hidden');
                dropZone.classList.remove('border-primary');
            });
        });
        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            dropOverlay.classList.add('hidden');
            dropZone.classList.remove('border-primary');
            const file = e.dataTransfer.files[0];
            if (file && (file.type === 'image/svg+xml' || file.name.toLowerCase().endsWith('.svg'))) applyCustomIcon(file);
            else if (file) showAlert('{{ __("Format no vàlid") }}', '{{ __("Tria una icona en format SVG.") }}', 'warning');
        });

        // --- Edit Modal Logic ---
        const editModal = document.getElementById('edit-cat-modal');
        const editForm = document.getElementById('edit-category-form');
        const editIdInput = document.getElementById('edit-cat-id');
        const editNameInput = document.getElementById('edit-cat-name');
        const editDescInput = document.getElementById('edit-cat-description');
        const editColorInput = document.getElementById('edit-cat-color');
        const editColorPicker = document.getElementById('edit-cat-color-picker');
        const editColorPreview = document.getElementById('edit-color-preview');
        const editIconInput = document.getElementById('edit-cat-icon');
        const editIconPreviewBox = document.getElementById('edit-icon-preview-box');
        const editIconNameDisp = document.getElementById('edit-icon-name');

        function openEditCatModal(data) {
            editIdInput.value = data.id;
            editNameInput.value = data.name;
            editDescInput.value = data.description == 'null' ? '' : (data.description || '');
            editColorInput.value = data.color;
            editColorPicker.value = data.color;
            editColorPreview.style.backgroundColor = data.color;
            editIconInput.value = data.icon;
            
            updateEditIconPreview(data.icon);

            editModal.classList.remove('hidden');
            setTimeout(() => {
                editModal.classList.remove('opacity-0');
                editModal.querySelector('div').classList.remove('scale-95');
            }, 10);
        }

        function updateEditIconPreview(icon) {
            if (icon && icon.startsWith('category-icons/')) {
                editIconPreviewBox.innerHTML = `<img src="/storage/${icon}" class="w-1/2 h-1/2 object-contain filter-primary">`;
                editIconNameDisp.textContent = icon.split('/').pop();
            } else {
                editIconPreviewBox.innerHTML = `<span class="material-symbols-outlined text-2xl">${icon || 'category'}</span>`;
                editIconNameDisp.textContent = icon || 'category';
            }
            
            // Highlight in grid
            document.querySelectorAll('.edit-icon-opt').forEach(opt => {
                if (opt.dataset.icon === icon) {
                    opt.classList.add('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20');
                    opt.classList.remove('bg-white', 'dark:bg-slate-700', 'text-slate-400');
                } else {
                    opt.classList.remove('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20');
                    opt.classList.add('bg-white', 'dark:bg-slate-700', 'text-slate-400');
                }
            });
        }

        document.getElementById('close-edit-cat-modal').onclick = () => {
            editModal.classList.add('opacity-0');
            editModal.querySelector('div').classList.add('scale-95');
            setTimeout(() => editModal.classList.add('hidden'), 300);
        };

        // Color Picker for Edit
        editColorPreview.onclick = () => editColorPicker.click();
        editColorPicker.oninput = (e) => {
            editColorInput.value = e.target.value.toUpperCase();
            editColorPreview.style.backgroundColor = e.target.value;
        };
        editColorInput.oninput = (e) => {
            if (/^#[0-9A-F]{6}$/i.test(e.target.value)) {
                editColorPreview.style.backgroundColor = e.target.value;
                editColorPicker.value = e.target.value;
            }
        };

        // Icon Selection for Edit
        document.querySelectorAll('.edit-icon-opt').forEach(opt => {
            opt.onclick = function() {
                const icon = this.dataset.icon;
                editIconInput.value = icon;
                editCustomIconFileEdit = null;
                updateEditIconPreview(icon);
                // Clear custom upload preview in edit modal if any
                document.getElementById('edit-custom-icon-preview-thumb').classList.add('hidden');
                document.getElementById('edit-custom-icon-placeholder').classList.remove('hidden');
                document.getElementById('edit-custom-icon-filename').classList.add('hidden');
            };
        });

        // Custom Icon for Edit
        let editCustomIconFileEdit = null;
        const editFileInput = document.getElementById('edit-custom-icon-file');
        document.getElementById('edit-btn-custom-icon').onclick = () => editFileInput.click();
        
        editFileInput.onchange = function() {
            if (this.files[0]) {
                const file = this.files[0];
                if (file.type !== 'image/svg+xml' && !file.name.toLowerCase().endsWith('.svg')) {
                    showAlert('{{ __("Format Incorrecte") }}', '{{ __("Només s\\'accepten fitxers SVGs.") }}', 'error');
                    return;
                }
                editCustomIconFileEdit = file;
                editIconInput.value = '__custom__';
                
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('edit-custom-icon-img').src = e.target.result;
                    document.getElementById('edit-custom-icon-preview-thumb').classList.remove('hidden');
                    document.getElementById('edit-custom-icon-placeholder').classList.add('hidden');
                    editIconPreviewBox.innerHTML = `<img src="${e.target.result}" class="w-1/2 h-1/2 object-contain filter-primary">`;
                    editIconNameDisp.textContent = file.name;
                    document.getElementById('edit-custom-icon-filename').textContent = file.name;
                    document.getElementById('edit-custom-icon-filename').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        };

        // Edit Form Submit
        editForm.onsubmit = async function(e) {
            e.preventDefault();
            const id = editIdInput.value;
            const fd = new FormData();
            fd.append('_method', 'PUT');
            fd.append('name', editNameInput.value);
            fd.append('description', editDescInput.value);
            fd.append('color', editColorInput.value);
            
            if (editCustomIconFileEdit) {
                fd.append('icon_image', editCustomIconFileEdit);
            } else {
                fd.append('icon', editIconInput.value);
            }

            try {
                const res = await fetch(`/admin/categories/${id}`, {
                    method: 'POST', // POST with _method=PUT
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: fd
                });
                const data = await res.json();
                if (data.success) {
                    document.getElementById('close-edit-cat-modal').onclick();
                    fetchCategories(searchInput ? searchInput.value : '', 1); // Refresh list
                    showAlert('{{ __("Èxit") }}', '{{ __("Categoria actualitzada correctament") }}', 'success');
                } else {
                    showAlert('{{ __("Error") }}', data.message || '{{ __("Error al actualitzar") }}', 'error');
                }
            } catch (err) {
                showAlert('{{ __("Error") }}', '{{ __("Error de xarxa") }}', 'error');
            }
        };

        // ── Styled alert helper ──────────────────────────────────────────
        const infoModal      = document.getElementById('info-modal');
        const infoModalInner = infoModal.querySelector('div');
        const infoModalMsg   = document.getElementById('info-modal-msg');
        const infoModalTitle = document.getElementById('info-modal-title');
        const infoModalIcon  = document.getElementById('info-modal-icon');
        const infoModalClose = document.getElementById('info-modal-close');

        function showAlert(title, message, type = 'info') {
            infoModalTitle.textContent = title;
            infoModalMsg.textContent   = message;
            const icons = { info: 'info', warning: 'warning', error: 'error', success: 'check_circle' };
            infoModalIcon.textContent  = icons[type] || 'info';
            infoModal.classList.remove('hidden');
            setTimeout(() => {
                infoModal.classList.remove('opacity-0');
                infoModalInner.classList.remove('scale-95');
            }, 10);
        }

        function closeInfoModal() {
            infoModal.classList.add('opacity-0');
            infoModalInner.classList.add('scale-95');
            setTimeout(() => infoModal.classList.add('hidden'), 300);
        }

        infoModalClose.addEventListener('click', closeInfoModal);
        infoModal.addEventListener('click', (e) => { if (e.target === infoModal) closeInfoModal(); });

        // ── Form Submit ──────────────────────────────────────────────────
        const form = document.getElementById('category-form');
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            let res;
            if (customIconFile) {
                const fd = new FormData();
                fd.append('name',        document.getElementById('cat-name').value);
                fd.append('description', document.getElementById('cat-description').value);
                fd.append('color',       document.getElementById('cat-color').value);
                fd.append('icon',        '');
                fd.append('icon_image',  customIconFile);
                res = await fetch('/admin/categories', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: fd
                });
            } else {
                const payload = {
                    name:        document.getElementById('cat-name').value,
                    description: document.getElementById('cat-description').value,
                    color:       document.getElementById('cat-color').value,
                    icon:        iconInput.value
                };
                res = await fetch('/admin/categories', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
            }

            try {
                const data = await res.json();
                if (data.success) {
                    window.location.reload();
                } else {
                    showAlert('{{ __("Error") }}', data.message || '{{ __("Error guardant la categoria") }}', 'error');
                }
            } catch (err) {
                console.error('Failed to save category', err);
                showAlert('{{ __("Error") }}', '{{ __("Error guardant la categoria") }}', 'error');
            }
        });

        // ── Deletion logic ────────────────────────────────────────────────
        const deleteModal = document.getElementById('delete-modal');
        const confirmDeleteBtn = document.getElementById('confirm-delete');
        const cancelDeleteBtn = document.getElementById('cancel-delete');
        let categoryToDelete = null;

        const closeModal = () => {
            deleteModal.classList.add('opacity-0');
            deleteModal.querySelector('div').classList.add('scale-95');
            setTimeout(() => {
                deleteModal.classList.add('hidden');
                categoryToDelete = null;
            }, 300);
        };

        cancelDeleteBtn.addEventListener('click', closeModal);

        confirmDeleteBtn.addEventListener('click', async function() {
            if (!categoryToDelete) return;

            try {
                const res = await fetch(`/admin/categories/${categoryToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    window.location.reload();
                } else {
                    showAlert('{{ __("Error") }}', data.message || '{{ __("Error eliminant la categoria") }}', 'error');
                    closeModal();
                }
            } catch (err) {
                console.error("Failed to delete category", err);
                showAlert('{{ __("Error") }}', '{{ __("Error de xarxa al eliminar la categoria") }}', 'error');
                closeModal();
            }
        });
    });
</script>
@endpush
@endsection