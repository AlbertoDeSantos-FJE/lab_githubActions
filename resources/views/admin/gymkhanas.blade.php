@extends('layouts.admin')

@section('title', __('Gestió de Gimcanes'))
@section('header_title', __('Gestió de Gimcanes'))
@section('search_placeholder', __('Cercar gimcanes...'))

@section('content')
<div class="flex flex-col gap-5">
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

    <!-- Bento-style Data Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Rutes', 'value' => $globals['totalRutes'], 'icon' => 'route', 'color' => 'text-primary', 'bg' => 'bg-primary/5'],
                ['label' => 'Participants Avui', 'value' => $globals['usersToday'], 'icon' => 'groups', 'color' => 'text-primary', 'bg' => 'bg-primary/5'],
                ['label' => 'Temps Mitjà', 'value' => $globals['avgGlobalTime'], 'icon' => 'timer', 'color' => 'text-primary', 'bg' => 'bg-primary/5'],
                ['label' => 'Valoració Mitjana', 'value' => $globals['avgRating'], 'icon' => 'star', 'color' => 'text-secondary', 'bg' => 'bg-secondary/10'],
            ];
        @endphp
        @foreach($stats as $stat)
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

    <!-- Table Container -->
    <div class="bg-white dark:bg-slate-900 rounded-[10px] shadow-sm overflow-hidden border border-slate-50 dark:border-slate-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="gymkhanas-table">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Scavenger Hunt Name') }}</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Number of Stages') }}</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Average Duration') }}</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @foreach($gymkhanas as $gym)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-5">
                                    <div class="w-16 h-16 rounded-[10px] bg-primary/5 flex items-center justify-center overflow-hidden border border-slate-100 dark:border-slate-800 shrink-0">
                                        <img alt="{{ $gym->name }}" class="w-full h-full object-cover" src="{{ $gym->image ? asset('storage/' . $gym->image) : asset('images/placeholder-poi.png') }}"/>
                                    </div>
                                    <div class="truncate">
                                        <p class="font-black text-slate-900 dark:text-slate-100 group-hover:text-primary transition-colors truncate">{{ $gym->name }}</p>
                                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest truncate max-w-[200px]">{{ $gym->description ?: __('Sense descripció') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="px-4 py-1.5 bg-primary/10 dark:bg-slate-800 rounded-[10px] text-[10px] font-black text-primary dark:text-primary-fixed uppercase tracking-widest border border-primary/10">
                                    {{ $gym->points_count }} {{ __('Etapes') }}
                                </span>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                    <span class="material-symbols-outlined text-sm">schedule</span>
                                    <span class="text-xs font-bold">{{ $gym->real_duration ? $gym->real_duration : __('Mai completada') }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.gymkhanas.edit', $gym->id) }}" class="w-10 h-10 rounded-[10px] flex items-center justify-center text-primary bg-primary/5 hover:bg-primary/10 transition-colors">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>
                                    <button onclick="deleteGymkhana({{ $gym->id }}, '{{ addslashes($gym->name) }}')" class="w-10 h-10 rounded-[10px] flex items-center justify-center text-red-500 bg-red-50 dark:bg-red-950/30 hover:bg-red-100 dark:hover:bg-red-950/50 transition-colors">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-10 py-8 bg-slate-50 dark:bg-slate-800/30 flex justify-between items-center gap-4">
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
</div>
<script>
    document.getElementById('search-input')?.addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#gymkhanas-table tbody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            if (text.includes(term)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        document.getElementById('gym-count-text').innerText = '{{ __("Mostrant") }} ' + visibleCount + ' {{ __("gimcanes") }}';
    });

    function deleteGymkhana(id, name) {
        if (!confirm('{{ __("N\'estàs segur que vols eliminar la gimcana") }} "' + name + '"? {{ __("Aquesta acció no es pot desfer.") }}')) return;
        
        fetch(`/admin/gymkhanas/${id}`, {
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
            }
        })
        .catch(e => {
            console.error(e);
            alert('{{ __("Error de xarxa. Torna-ho a intentar.") }}');
        });
    }
</script>
@endsection