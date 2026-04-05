@extends('layouts.admin')

@section('title', __('Gestió de Gimcanes'))
@section('header_title', __('Gestió de Gimcanes'))
@section('search_placeholder', __('Cercar gimcanes...'))

@section('content')

{{-- ══ MOBILE-ONLY LAYOUT ═══════════════════════════════════════════════ --}}
<div class="flex flex-col gap-4 md:hidden">

    {{-- 1. "Nova Gimcana" button pinned right below the nav --}}
    <a href="{{ route('admin.gymkhanas.create') }}" class="bg-primary text-white px-6 py-3 rounded-[10px] font-black flex items-center justify-center gap-2 shadow-xl shadow-primary/30 active:scale-[0.98] transition-all uppercase tracking-widest text-sm w-full">
        <span class="material-symbols-outlined">add</span>
        {{ __('Nova Gimcana') }}
    </a>

    {{-- 2. Collapsible "Dades Gimcanes" stats section --}}
    <div class="bg-white dark:bg-slate-900 rounded-[10px] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        {{-- Trigger header --}}
        <div id="toggle-stats-mobile" class="flex items-center justify-between cursor-pointer px-5 py-3.5 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
            <div>
                <h3 class="font-black text-lg text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Dades Gimcanes') }}</h3>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ __('Estadístiques generals') }}</p>
            </div>
            <span class="material-symbols-outlined text-3xl text-primary transition-transform duration-300" id="stats-mobile-icon">expand_more</span>
        </div>

        {{-- Collapsible 2×2 grid --}}
        <div id="stats-mobile-content" class="overflow-hidden transition-all duration-400" style="max-height:0;opacity:0;">
            <div class="grid grid-cols-2 gap-3 px-4 pb-4 pt-1">
                @php
                    $stats = [
                        ['label' => 'Total Rutes',       'value' => $globals['totalRutes'],    'icon' => 'route',   'color' => 'text-primary',   'bg' => 'bg-primary/5'],
                        ['label' => 'Participants Avui', 'value' => $globals['usersToday'],    'icon' => 'groups',  'color' => 'text-primary',   'bg' => 'bg-primary/5'],
                        ['label' => 'Temps Mitjà',       'value' => $globals['avgGlobalTime'], 'icon' => 'timer',   'color' => 'text-primary',   'bg' => 'bg-primary/5'],
                        ['label' => 'Valoració Mitjana', 'value' => $globals['avgRating'],     'icon' => 'star',    'color' => 'text-secondary', 'bg' => 'bg-secondary/10'],
                    ];
                @endphp
                @foreach($stats as $stat)
                    <div class="bg-slate-50 dark:bg-slate-800/60 p-3 rounded-[10px] border border-slate-100 dark:border-slate-700">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-slate-500 dark:text-slate-400 text-[9px] font-black uppercase tracking-widest leading-tight">{{ __($stat['label']) }}</p>
                            <div class="w-7 h-7 rounded-[8px] {{ $stat['bg'] }} flex items-center justify-center {{ $stat['color'] }} shrink-0">
                                <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">{{ $stat['icon'] }}</span>
                            </div>
                        </div>
                        <div class="flex items-end gap-1">
                            <p class="text-2xl font-black text-slate-900 dark:text-slate-100">{{ $stat['value'] }}</p>
                            @if($stat['icon'] == 'star')
                                <span class="material-symbols-outlined text-secondary text-base mb-0.5" style="font-variation-settings: 'FILL' 1;">star</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- 3. "Gimcanes Actives" heading above the list --}}
    <div class="space-y-1 pt-1">
        <span class="text-primary font-black tracking-[0.2em] text-[10px] uppercase bg-primary/10 px-3 py-1.5 rounded-[10px] border border-primary/10 inline-block">{{ __('Exploració Urbana') }}</span>
        <h3 class="text-2xl font-black tracking-tight text-slate-900 dark:text-slate-100">{{ __('Gimcanes Actives') }}</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">{{ __('Gestiona i supervisa les rutes i experiències interactives.') }}</p>
    </div>
</div>

{{-- ══ DESKTOP-ONLY LAYOUT (unchanged) ════════════════════════════════════ --}}
<div class="hidden md:flex flex-col gap-5">
    <!-- Hero / Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="space-y-2">
            <span class="text-primary font-black tracking-[0.2em] text-[10px] uppercase bg-primary/10 px-3 py-1.5 rounded-[10px] border border-primary/10">{{ __('Exploració Urbana') }}</span>
            <h3 class="text-4xl font-black tracking-tight text-slate-900 dark:text-slate-100">{{ __('Gimcanes Actives') }}</h3>
            <p class="text-slate-500 dark:text-slate-400 font-medium">{{ __('Gestiona i supervisa les rutes i experiències interactives.') }}</p>
        </div>
        <a href="{{ route('admin.gymkhanas.create') }}" class="bg-primary text-white px-8 py-4 rounded-[10px] font-black flex items-center gap-2 shadow-xl shadow-primary/30 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest text-sm">
            <span class="material-symbols-outlined">add</span>
            {{ __('Nova Gimcana') }}
        </a>
    </div>


    <!-- Bento-style Data Stats (desktop only) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $statsDesktop = [
                ['label' => 'Total Rutes',       'value' => $globals['totalRutes'],    'icon' => 'route',   'color' => 'text-primary',   'bg' => 'bg-primary/5'],
                ['label' => 'Participants Avui', 'value' => $globals['usersToday'],    'icon' => 'groups',  'color' => 'text-primary',   'bg' => 'bg-primary/5'],
                ['label' => 'Temps Mitjà',       'value' => $globals['avgGlobalTime'], 'icon' => 'timer',   'color' => 'text-primary',   'bg' => 'bg-primary/5'],
                ['label' => 'Valoració Mitjana', 'value' => $globals['avgRating'],     'icon' => 'star',    'color' => 'text-secondary', 'bg' => 'bg-secondary/10'],
            ];
        @endphp
        @foreach($statsDesktop as $stat)
            <div class="bg-white dark:bg-slate-900 p-8 rounded-[10px] border border-slate-50 dark:border-slate-800 shadow-sm hover:border-primary/20 transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-black uppercase tracking-widest">{{ __($stat['label']) }}</p>
                    <div class="w-10 h-10 rounded-[10px] {{ $stat['bg'] }} flex items-center justify-center {{ $stat['color'] }}">
                        <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">{{ $stat['icon'] }}</span>
                    </div>
                </div>
                <div class="flex items-end gap-2">
                    <p class="text-4xl font-black text-slate-900 dark:text-slate-100">{{ $stat['value'] }}</p>
                    @if($stat['icon'] == 'star')
                        <span class="material-symbols-outlined text-secondary text-2xl mb-1" style="font-variation-settings: 'FILL' 1;">star</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>{{-- END desktop-only wrapper --}}

{{-- ══ TABLE — shared, visible on all screen sizes ═══════════════════════ --}}
<div class="bg-white dark:bg-slate-900 rounded-[10px] shadow-sm overflow-hidden border border-slate-50 dark:border-slate-800 mt-4 md:mt-0">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="gymkhanas-table">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-4 md:px-10 py-4 md:py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Scavenger Hunt Name') }}</th>
                    <th class="hidden md:table-cell px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Number of Stages') }}</th>
                    <th class="hidden md:table-cell px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Average Duration') }}</th>
                    <th class="px-4 md:px-10 py-4 md:py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Estat') }}</th>
                    <th class="px-4 md:px-10 py-4 md:py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @foreach($gymkhanas as $gym)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                        <td class="px-3 md:px-10 py-4 md:py-8">
                            <div class="flex items-center gap-3 md:gap-5">
                                <div class="w-12 h-12 md:w-16 md:h-16 rounded-[10px] bg-primary/5 flex items-center justify-center overflow-hidden border border-slate-100 dark:border-slate-800 shrink-0">
                                    <img alt="{{ $gym->name }}" class="w-full h-full object-cover" src="{{ $gym->image ? asset('storage/' . $gym->image) : asset('images/placeholder-poi.png') }}"/>
                                </div>
                                <div class="truncate">
                                    <p class="font-black text-xs md:text-sm text-slate-900 dark:text-slate-100 group-hover:text-primary transition-colors truncate">{{ $gym->name }}</p>
                                    <p class="text-[9px] md:text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest truncate max-w-[120px] md:max-w-[200px]">{{ $gym->description ?: __('Sense descripció') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="hidden md:table-cell px-10 py-8">
                            <span class="px-4 py-1.5 bg-primary/10 dark:bg-slate-800 rounded-[10px] text-[10px] font-black text-primary dark:text-primary-fixed uppercase tracking-widest border border-primary/10">
                                {{ $gym->points_count }} {{ __('Etapes') }}
                            </span>
                        </td>
                        <td class="hidden md:table-cell px-10 py-8">
                            <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                <span class="material-symbols-outlined text-sm">schedule</span>
                                <span class="text-xs font-bold">{{ $gym->real_duration ? $gym->real_duration : __('Mai completada') }}</span>
                            </div>
                        </td>
                        <td class="px-3 md:px-10 py-4 md:py-8">
                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" class="sr-only peer" {{ $gym->active ? 'checked' : '' }} onchange="toggleGymkhanaStatus({{ $gym->id }}, this)">
                                <div class="w-9 h-5 md:w-11 md:h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 md:after:h-5 md:after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                            </label>
                        </td>
                        <td class="px-3 md:px-10 py-4 md:py-8 text-right">
                            <div class="flex justify-end gap-1.5 md:gap-3">
                                <a href="{{ route('admin.gymkhanas.edit', $gym->id) }}" class="w-8 h-8 md:w-10 md:h-10 rounded-[10px] flex items-center justify-center text-primary bg-primary/5 hover:bg-primary/10 transition-colors">
                                    <span class="material-symbols-outlined text-base md:text-lg">edit</span>
                                </a>
                                <button onclick="deleteGymkhana({{ $gym->id }}, '{{ addslashes($gym->name) }}')" class="w-8 h-8 md:w-10 md:h-10 rounded-[10px] flex items-center justify-center text-red-500 bg-red-50 dark:bg-red-950/30 hover:bg-red-100 dark:hover:bg-red-950/50 transition-colors">
                                    <span class="material-symbols-outlined text-base md:text-lg">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-4 md:px-10 py-5 md:py-8 bg-slate-50 dark:bg-slate-800/30 flex justify-between items-center gap-4">
        <p id="gym-count-text" class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Mostrant') }} {{ $gymkhanas->count() }} {{ __('gimcanes') }}</p>
        @if($gymkhanas->count() > 5)
        <div class="flex gap-2">
            @for($i = 1; $i <= 3; $i++)
                <button class="w-10 h-10 rounded-[10px] flex items-center justify-center {{ $i == 1 ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-white dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:text-primary transition-all' }} text-xs font-black">{{ $i }}</button>
            @endfor
            <button class="w-10 h-10 rounded-[10px] flex items-center justify-center bg-white dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:text-primary transition-all">
                <span class="material-symbols-outlined text-sm">chevron_right</span>
            </button>
        </div>
        @endif
    </div>
</div>

{{-- ── Delete Confirmation Modal ────────────────────────────────────────── --}}
<div id="delete-gymkhana-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-[10px] p-10 shadow-2xl border border-slate-100 dark:border-slate-800 scale-95 transition-transform duration-300">
        <div class="w-20 h-20 bg-red-50 dark:bg-red-500/10 rounded-[10px] flex items-center justify-center mb-6 mx-auto">
            <span class="material-symbols-outlined text-4xl text-red-500">warning</span>
        </div>
        <div class="text-center mb-8">
            <h3 class="text-xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Eliminar Gimcana') }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-3 leading-relaxed">
                {{ __('Estàs a punt d\'eliminar la gimcana') }} <strong id="delete-gymkhana-name" class="text-slate-900 dark:text-slate-100"></strong>.<br><br>
                {{ __('Estàs segur que vols continuar?') }}
            </p>
        </div>
        <div class="flex flex-col gap-3">
            <button id="confirm-delete-gymkhana" class="w-full bg-red-500 text-white py-4 rounded-[10px] font-black shadow-xl shadow-red-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest text-xs flex items-center justify-center gap-2">
                {{ __('SÍ, ELIMINAR') }}
            </button>
            <button id="cancel-delete-gymkhana" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 py-4 rounded-[10px] font-black hover:bg-slate-100 dark:hover:bg-slate-700 transition-all uppercase tracking-widest text-xs border border-slate-100 dark:border-slate-700">
                {{ __('CANCEL·LAR') }}
            </button>
        </div>
    </div>
</div>

<script>
    // ── Mobile stats collapsible ─────────────────────────────────────────
    (function() {
        const toggle  = document.getElementById('toggle-stats-mobile');
        const content = document.getElementById('stats-mobile-content');
        const icon    = document.getElementById('stats-mobile-icon');
        if (!toggle || !content) return;

        let collapsed = true;

        toggle.addEventListener('click', function() {
            collapsed = !collapsed;
            if (!collapsed) {
                content.style.maxHeight  = content.scrollHeight + 'px';
                content.style.opacity    = '1';
                icon.style.transform     = 'rotate(0deg)';
            } else {
                content.style.maxHeight  = '0px';
                content.style.opacity    = '0';
                icon.style.transform     = 'rotate(-90deg)';
            }
        });
    })();

    let gymkhanaToDeleteId = null;
    const deleteModal = document.getElementById('delete-gymkhana-modal');
    const deleteModalInner = deleteModal.querySelector('div');
    const deleteNameEl = document.getElementById('delete-gymkhana-name');

    window.deleteGymkhana = function(id, name) {
        gymkhanaToDeleteId = id;
        deleteNameEl.textContent = name;
        
        deleteModal.classList.remove('hidden');
        setTimeout(() => {
            deleteModal.classList.remove('opacity-0');
            deleteModalInner.classList.remove('scale-95');
        }, 10);
    };

    function closeDeleteModal() {
        gymkhanaToDeleteId = null;
        deleteModal.classList.add('opacity-0');
        deleteModalInner.classList.add('scale-95');
        setTimeout(() => {
            deleteModal.classList.add('hidden');
        }, 300);
    }

    document.getElementById('cancel-delete-gymkhana').addEventListener('click', closeDeleteModal);

    document.getElementById('confirm-delete-gymkhana').addEventListener('click', function() {
        if (!gymkhanaToDeleteId) return;

        const btn = this;
        btn.innerHTML = '<span class="material-symbols-outlined text-lg animate-spin">progress_activity</span> {{ __("ELIMINANT...") }}';
        btn.disabled = true;

        fetch(`/admin/gymkhanas/${gymkhanaToDeleteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('{{ __("Error a l\'eliminar la gimcana") }}');
                btn.innerHTML = '{{ __("SÍ, ELIMINAR") }}';
                btn.disabled = false;
                closeDeleteModal();
            }
        })
        .catch(e => {
            console.error(e);
            alert('{{ __("Error de xarxa. Torna-ho a intentar.") }}');
            btn.innerHTML = '{{ __("SÍ, ELIMINAR") }}';
            btn.disabled = false;
            closeDeleteModal();
        });
    });

    window.toggleGymkhanaStatus = function(id, checkbox) {
        checkbox.disabled = true;
        fetch(`/admin/gymkhanas/${id}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                checkbox.checked = !checkbox.checked;
                alert('{{ __("Error al canviar l\'estat") }}');
            }
        })
        .catch(e => {
            checkbox.checked = !checkbox.checked;
            alert('{{ __("Error de xarxa") }}');
        })
        .finally(() => {
            checkbox.disabled = false;
        });
    }
</script>
@endsection