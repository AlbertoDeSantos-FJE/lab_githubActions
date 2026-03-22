<div class="space-y-4">
    <!-- List Header -->
    <div class="grid grid-cols-12 gap-4 px-8 py-2 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">
        <div class="col-span-5">{{ __('Categoria') }}</div>
        <div class="col-span-2 text-center">{{ __('Color') }}</div>
        <div class="col-span-1 text-center whitespace-nowrap">{{ __('Llocs') }}</div>
        <div class="col-span-2 text-center">{{ __('Estat') }}</div>
        <div class="col-span-2 text-right">{{ __('Accions') }}</div>
    </div>

    @forelse($categories as $cat)
        <div class="category-item grid grid-cols-12 items-center gap-4 bg-white dark:bg-slate-900 px-8 py-5 rounded-[10px] shadow-sm border border-slate-50 dark:border-slate-800 hover:border-primary/20 transition-all group {{ !$cat->active ? 'opacity-70 grayscale-[0.5]' : '' }}" data-active="{{ $cat->active ? 'true' : 'false' }}">
            <div class="col-span-5 flex items-center gap-5">
                <div class="w-14 h-14 rounded-[10px] bg-primary/10 flex items-center justify-center shrink-0">
                    @if($cat->icon && str_starts_with($cat->icon, 'category-icons/'))
                        <img src="{{ asset('storage/' . $cat->icon) }}" alt="{{ $cat->name }}" class="w-8 h-8 object-contain filter-primary">
                    @else
                        <span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings: 'FILL' 1;">{{ $cat->icon ?: 'category' }}</span>
                    @endif
                </div>
                <div class="truncate">
                    <span class="font-black text-slate-900 dark:text-slate-100 block truncate">{{ $cat->name }}</span>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">{{ $cat->description ?: __('Categoria de llocs') }}</span>
                </div>
            </div>
            <div class="col-span-2 flex justify-center">
                <div class="w-8 h-8 rounded-[10px] shadow-md" style="background-color: {{ $cat->color ?: '#5D3FD3' }}; border: 1px solid rgba(255,255,255,0.3);"></div>
            </div>
            <div class="col-span-1 flex justify-center font-black text-sm text-slate-900 dark:text-slate-100 whitespace-nowrap">{{ $cat->places_count }}</div>
            <div class="col-span-2 flex justify-center">
                <label class="toggle-switch">
                    <input class="status-toggle" data-id="{{ $cat->id }}" {{ $cat->active ? 'checked' : '' }} type="checkbox"/>
                    <span class="slider"></span>
                </label>
            </div>
            <div class="col-span-2 flex justify-end gap-2">
                <button class="edit-btn w-10 h-10 flex items-center justify-center hover:bg-primary/10 text-primary rounded-[10px] transition-colors"
                    data-id="{{ $cat->id }}"
                    data-name="{{ $cat->name }}"
                    data-description="{{ $cat->description }}"
                    data-color="{{ $cat->color ?: '#5D3FD3' }}"
                    data-icon="{{ $cat->icon }}">
                    <span class="material-symbols-outlined text-lg">edit</span>
                </button>
                @if($cat->name !== 'Sense categoria')
                <button class="delete-btn w-10 h-10 flex items-center justify-center hover:bg-red-50 text-red-500 rounded-[10px] transition-colors" data-id="{{ $cat->id }}">
                    <span class="material-symbols-outlined text-lg">delete</span>
                </button>
                @endif
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-slate-900 px-8 py-12 rounded-[10px] border border-slate-50 dark:border-slate-800 text-center">
            <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-700 mb-4">search_off</span>
            <p class="text-slate-500 dark:text-slate-400 font-medium">{{ __('No s\'han trobat categories que coincideixin amb la cerca.') }}</p>
        </div>
    @endforelse
</div>

<!-- Pagination Links -->
@if ($categories->hasPages())
<div class="mt-10">
    {{ $categories->links('admin.pagination') }}
</div>
@endif
