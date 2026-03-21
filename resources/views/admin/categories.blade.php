@extends('layouts.admin')

@section('title', __('Gestió de Categories'))
@section('header_title', __('Gestió de Categories'))

@section('content')
<div class="grid grid-cols-12 gap-10 items-start">
    <!-- Left Side: Categories List -->
    <div class="col-span-12 lg:col-span-8 space-y-8">
        <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4">
            <div>
                <h3 class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Llistat de Categories') }}</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">{{ __('Visualitza i gestiona l\'estat de les categories existents.') }}</p>
            </div>
            <div class="flex bg-white dark:bg-slate-900 p-1.5 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
                <button class="px-5 py-2 text-xs font-bold rounded-xl bg-primary text-white shadow-lg shadow-primary/20">{{ __('Totes') }}</button>
                <button class="px-5 py-2 text-xs font-bold rounded-xl text-slate-500 dark:text-slate-400 hover:text-primary transition-colors">{{ __('Actives') }}</button>
                <button class="px-5 py-2 text-xs font-bold rounded-xl text-slate-500 dark:text-slate-400 hover:text-primary transition-colors">{{ __('Inactives') }}</button>
            </div>
        </div>

        <div class="space-y-4">
            <!-- List Header -->
            <div class="grid grid-cols-12 gap-4 px-8 py-2 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">
                <div class="col-span-5">{{ __('Categoria') }}</div>
                <div class="col-span-2 text-center">{{ __('Color') }}</div>
                <div class="col-span-1 text-center whitespace-nowrap">{{ __('Llocs') }}</div>
                <div class="col-span-2 text-center">{{ __('Estat') }}</div>
                <div class="col-span-2 text-right">{{ __('Accions') }}</div>
            </div>

            @foreach($categories as $cat)
                <div class="category-item grid grid-cols-12 items-center gap-4 bg-white dark:bg-slate-900 px-8 py-5 rounded-[2rem] shadow-sm border border-slate-50 dark:border-slate-800 hover:border-primary/20 transition-all group {{ !$cat->active ? 'opacity-70 grayscale-[0.5]' : '' }}" data-active="{{ $cat->active ? 'true' : 'false' }}">
                    <div class="col-span-5 flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings: 'FILL' 1;">{{ $cat->icon ?: 'category' }}</span>
                        </div>
                        <div class="truncate">
                            <span class="font-black text-slate-900 dark:text-slate-100 block truncate">{{ $cat->name }}</span>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">{{ __('Categoria de llocs') }}</span>
                        </div>
                    </div>
                    <div class="col-span-2 flex justify-center">
                        <span class="px-3 py-1 bg-slate-50 dark:bg-slate-800 rounded-lg text-[10px] font-black text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-700 font-mono">{{ $cat->color ?: '#5D3FD3' }}</span>
                    </div>
                    <div class="col-span-1 flex justify-center font-black text-sm text-slate-900 dark:text-slate-100 whitespace-nowrap">{{ $cat->places_count }}</div>
                    <div class="col-span-2 flex justify-center">
                        <label class="toggle-switch">
                            <input class="status-toggle" data-id="{{ $cat->id }}" {{ $cat->active ? 'checked' : '' }} type="checkbox"/>
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="col-span-2 flex justify-end gap-2">
                        <button class="w-10 h-10 flex items-center justify-center hover:bg-primary/10 text-primary rounded-xl transition-colors">
                            <span class="material-symbols-outlined text-lg">edit</span>
                        </button>
                        @if($cat->name !== 'Sense categoria')
                        <button class="delete-btn w-10 h-10 flex items-center justify-center hover:bg-red-50 text-red-500 rounded-xl transition-colors" data-id="{{ $cat->id }}">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Right Side: Persistent Form -->
    <div class="col-span-12 lg:col-span-4 sticky top-32">
        <div class="bg-white dark:bg-slate-900 p-10 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm">
            <div class="mb-10">
                <h3 class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Nova Categoria') }}</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">{{ __('Defineix els paràmetres de la nova categoria.') }}</p>
            </div>
            <form id="category-form" class="space-y-8">
                @csrf
                <!-- Category Name -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 ml-1">{{ __('Nom de la Categoria') }}</label>
                    <input id="cat-name" name="name" class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 focus:ring-4 focus:ring-primary/10 outline-none placeholder:text-slate-400 dark:text-slate-100 transition-all font-medium text-sm" placeholder="Ex: Vida Nocturna" type="text" required/>
                </div>

                <!-- Icon Selection -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 ml-1">{{ __('Selecció d\'Icona') }}</label>
                    <input type="hidden" id="cat-icon" name="icon" value="stars">
                    <div class="grid grid-cols-4 gap-3 bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl">
                        @php
                            $icons = ['stars', 'theater_comedy', 'shopping_bag', 'hiking', 'church', 'hotel', 'local_bar', 'more_horiz'];
                        @endphp
                        @foreach($icons as $icon)
                            <button class="icon-opt aspect-square flex items-center justify-center rounded-xl {{ $icon == 'stars' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-white dark:bg-slate-700 text-slate-400 hover:text-primary transition-all border border-slate-100 dark:border-slate-600' }}" type="button" data-icon="{{ $icon }}">
                                <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">{{ $icon }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Color Picker -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 ml-1">{{ __('Color del Marcador') }}</label>
                    <div class="flex items-center gap-4">
                        <input type="color" id="cat-color-picker" class="hidden" value="#5D3FD3">
                        <div id="color-preview" class="w-14 h-14 rounded-2xl bg-primary shadow-lg border border-white/20 cursor-pointer shrink-0"></div>
                        <div class="flex-1 relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">HEX</span>
                            <input id="cat-color" name="color" class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-2xl pl-16 pr-6 py-4 focus:ring-4 focus:ring-primary/10 outline-none font-mono text-sm font-bold text-slate-900 dark:text-slate-100" type="text" value="#5D3FD3"/>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black shadow-xl shadow-primary/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3 mt-10 uppercase tracking-widest text-sm">
                    <span class="material-symbols-outlined text-xl">save</span>
                    {{ __('CREAR CATEGORIA') }}
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-[2.5rem] p-10 shadow-2xl border border-slate-100 dark:border-slate-800 scale-95 transition-transform duration-300">
        <div class="w-20 h-20 bg-red-50 dark:bg-red-500/10 rounded-3xl flex items-center justify-center mb-8 mx-auto">
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
            <button id="confirm-delete" class="w-full bg-red-500 text-white py-4 rounded-2xl font-black shadow-xl shadow-red-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest text-xs">
                {{ __('SÍ, ELIMINAR') }}
            </button>
            <button id="cancel-delete" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 py-4 rounded-2xl font-black hover:bg-slate-100 transition-all uppercase tracking-widest text-xs border border-slate-100 dark:border-slate-700">
                {{ __('CANCEL·LAR') }}
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        // Filter functionality
        const filterBtns = document.querySelectorAll('.flex.bg-white button');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20'));
                filterBtns.forEach(b => b.classList.add('text-slate-500', 'dark:text-slate-400', 'hover:text-primary'));
                this.classList.remove('text-slate-500', 'dark:text-slate-400', 'hover:text-primary');
                this.classList.add('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20');

                const filter = this.textContent.trim();
                const items = document.querySelectorAll('.category-item');
                
                items.forEach(item => {
                    const isActive = item.dataset.active === 'true';
                    if (filter === '{{ __("Totes") }}') {
                        item.classList.remove('hidden');
                    } else if (filter === '{{ __("Actives") }}') {
                        isActive ? item.classList.remove('hidden') : item.classList.add('hidden');
                    } else if (filter === '{{ __("Inactives") }}') {
                        !isActive ? item.classList.remove('hidden') : item.classList.add('hidden');
                    }
                });
            });
        });

        // Status Toggle
        document.querySelectorAll('.status-toggle').forEach(toggle => {
            toggle.addEventListener('change', async function() {
                const id = this.dataset.id;
                const container = this.closest('.category-item');
                
                try {
                    const res = await fetch(`/admin/categories/${id}/toggle`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        }
                    });
                    const data = await res.json();
                    if (data.success) {
                        container.dataset.active = data.active ? 'true' : 'false';
                        if (!data.active) {
                            container.classList.add('opacity-70', 'grayscale-[0.5]');
                        } else {
                            container.classList.remove('opacity-70', 'grayscale-[0.5]');
                        }
                    }
                } catch (e) {
                    console.error("Failed to toggle status", e);
                    this.checked = !this.checked;
                }
            });
        });

        // Icon Selection
        const iconOpts = document.querySelectorAll('.icon-opt');
        const iconInput = document.getElementById('cat-icon');
        iconOpts.forEach(opt => {
            opt.addEventListener('click', function() {
                iconOpts.forEach(o => o.classList.remove('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20'));
                iconOpts.forEach(o => o.classList.add('bg-white', 'dark:bg-slate-700', 'text-slate-400'));
                this.classList.remove('bg-white', 'dark:bg-slate-700', 'text-slate-400');
                this.classList.add('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20');
                iconInput.value = this.dataset.icon;
            });
        });

        // Color Picker
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

        // Form Submit
        const form = document.getElementById('category-form');
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const payload = Object.fromEntries(formData.entries());
            
            try {
                const res = await fetch('/admin/categories', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                if (data.success) {
                    window.location.reload(); // Simple reload to show new cat with count
                }
            } catch (err) {
                console.error("Failed to save category", err);
                alert("Error guardant la categoria");
            }
        });

        // Deletion logic
        const deleteModal = document.getElementById('delete-modal');
        const confirmDeleteBtn = document.getElementById('confirm-delete');
        const cancelDeleteBtn = document.getElementById('cancel-delete');
        let categoryToDelete = null;

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                categoryToDelete = this.dataset.id;
                deleteModal.classList.remove('hidden');
                setTimeout(() => {
                    deleteModal.classList.remove('opacity-0');
                    deleteModal.querySelector('div').classList.remove('scale-95');
                }, 10);
            });
        });

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
                    alert(data.message || "Error eliminant la categoria");
                    closeModal();
                }
            } catch (err) {
                console.error("Failed to delete category", err);
                alert("Error de xarxa al eliminar la categoria");
                closeModal();
            }
        });
    });
</script>
@endpush
@endsection