{{-- users-list partial — rendered by AJAX and initial page load --}}
@php $currentUserId = auth()->id(); @endphp

<table class="w-full text-left">
    <thead>
        <tr class="border-b border-slate-100 dark:border-slate-800">
            <th class="text-[10px] font-black uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500 px-6 py-3">{{ __('ID') }}</th>
            <th class="text-[10px] font-black uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500 px-6 py-3">{{ __('Usuari') }}</th>
            <th class="text-[10px] font-black uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500 px-6 py-3">{{ __('Email') }}</th>
            <th class="text-[10px] font-black uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500 px-6 py-3">{{ __('Rol') }}</th>
            <th class="text-[10px] font-black uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500 px-6 py-3">{{ __('Grups') }}</th>
            <th class="text-[10px] font-black uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500 px-6 py-3 text-right">{{ __('Accions') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        @php
            $initials = collect(explode(' ', $user->name))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');
            $colors   = ['#5D3FD3','#8b5cf6','#06b6d4','#10b981','#f59e0b','#ef4444','#ec4899'];
            $color    = $colors[crc32($user->email) % count($colors)];
        @endphp
        <tr class="border-b border-slate-50 dark:border-slate-800/60 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
            {{-- ID --}}
            <td class="px-6 py-4">
                <span class="text-xs font-black text-primary/60 dark:text-primary/40">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
            </td>

            {{-- Avatar + Name --}}
            <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/'.$user->profile_photo) }}" alt="{{ $user->name }}"
                            class="w-9 h-9 rounded-[10px] object-cover border-2 border-white dark:border-slate-700 shadow-sm">
                    @else
                        <div class="w-9 h-9 rounded-[10px] flex items-center justify-center text-white text-xs font-black shadow-sm shrink-0"
                            style="background-color: {{ $color }}">{{ $initials }}</div>
                    @endif
                    <div>
                        <p class="text-sm font-black text-slate-900 dark:text-slate-100 leading-tight">{{ $user->name }}</p>
                        @if($user->id === $currentUserId)
                            <span class="text-[9px] font-black text-primary uppercase tracking-widest">{{ __('Tu') }}</span>
                        @endif
                    </div>
                </div>
            </td>

            {{-- Email --}}
            <td class="px-6 py-4">
                <span class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $user->email }}</span>
            </td>

            {{-- Role badge --}}
            <td class="px-6 py-4">
                @if($user->role === 'admin')
                    <span class="inline-flex items-center px-3 py-1 rounded-[10px] text-[10px] font-black uppercase tracking-widest bg-primary text-white shadow-sm shadow-primary/25">ADMIN</span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-[10px] text-[10px] font-black uppercase tracking-widest bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">USUARI</span>
                @endif
            </td>

            {{-- Groups count --}}
            <td class="px-6 py-4">
                <div class="flex items-center gap-2">
                    @php $groupCount = $user->groups_count; $maxGroups = 10; $pct = min(100, ($groupCount/$maxGroups)*100); @endphp
                    <div class="w-20 h-1.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full transition-all" style="width: {{ $pct }}%"></div>
                    </div>
                    <span class="text-xs font-black text-slate-600 dark:text-slate-300">{{ $groupCount }}</span>
                </div>
            </td>

            {{-- Actions --}}
            <td class="px-6 py-4">
                <div class="flex items-center justify-end gap-2">
                    <button type="button"
                        class="edit-user-btn w-8 h-8 flex items-center justify-center rounded-[10px] bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-primary hover:bg-primary/10 transition-all"
                        data-id="{{ $user->id }}"
                        data-name="{{ $user->name }}"
                        data-email="{{ $user->email }}"
                        data-role="{{ $user->role }}"
                        title="{{ __('Editar') }}">
                        <span class="material-symbols-outlined text-base">edit</span>
                    </button>
                    @if($user->id !== $currentUserId)
                    <button type="button"
                        class="delete-user-btn w-8 h-8 flex items-center justify-center rounded-[10px] bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all"
                        data-id="{{ $user->id }}"
                        data-name="{{ $user->name }}"
                        title="{{ __('Eliminar') }}">
                        <span class="material-symbols-outlined text-base">delete</span>
                    </button>
                    @else
                    <div class="w-8 h-8 flex items-center justify-center rounded-[10px] text-slate-200 dark:text-slate-700 cursor-not-allowed" title="{{ __('No pots eliminar el teu propi compte') }}">
                        <span class="material-symbols-outlined text-base">delete</span>
                    </div>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center py-16 text-slate-400 dark:text-slate-500">
                <div class="flex flex-col items-center gap-3">
                    <span class="material-symbols-outlined text-5xl" style="font-variation-settings: 'FILL' 1;">group_off</span>
                    <p class="text-sm font-bold">{{ __('No s\'han trobat usuaris') }}</p>
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- Footer: count + pagination --}}
<div class="flex items-center justify-between px-6 py-4 border-t border-slate-100 dark:border-slate-800">
    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
        {{ __('Mostrant') }} <strong class="text-slate-900 dark:text-slate-100">{{ $users->count() }}</strong>
        {{ __('de') }} <strong class="text-slate-900 dark:text-slate-100">{{ $users->total() }}</strong>
        {{ __('usuaris') }}
    </p>
    {{ $users->appends(['search' => $search, 'role' => $roleFilter])->links('admin.pagination') }}
</div>

{{-- Bind row events for AJAX-rendered content --}}
<script>
(function() {
    document.querySelectorAll('.edit-user-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            window.openEditUser({
                id:    this.dataset.id,
                name:  this.dataset.name,
                email: this.dataset.email,
                role:  this.dataset.role,
            });
        });
    });

    document.querySelectorAll('.delete-user-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            window.openDeleteUser(this.dataset.id, this.dataset.name);
        });
    });
})();
</script>
