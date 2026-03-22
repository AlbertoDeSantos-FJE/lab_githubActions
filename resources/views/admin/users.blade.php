@extends('layouts.admin')

@section('title', __('Gestió d\'Usuaris'))
@section('header_title', __('Gestió d\'Usuaris'))

@section('content')
<div class="flex flex-col gap-4">

    {{-- ── Stats Cards ─────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Total Usuaris --}}
        <div class="bg-white dark:bg-slate-900 rounded-[10px] p-6 shadow-sm border border-slate-50 dark:border-slate-800 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 mb-1">{{ __('Total Usuaris') }}</p>
                <p class="text-4xl font-black text-slate-900 dark:text-slate-100">{{ number_format($totalUsers) }}</p>
                <p class="text-xs text-primary font-bold mt-1">
                    <span class="material-symbols-outlined text-sm align-middle" style="font-variation-settings: 'FILL' 1;">trending_up</span>
                    {{ __('Participants actius') }}
                </p>
            </div>
            <div class="w-14 h-14 rounded-[10px] bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-300 dark:text-slate-600">
                <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">group</span>
            </div>
        </div>

        {{-- Grups Actius --}}
        <div class="bg-primary rounded-[10px] p-6 shadow-lg shadow-primary/30 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/70 mb-1">{{ __('Grups Actius') }}</p>
                <p class="text-4xl font-black text-white">{{ $totalGroups }}</p>
                <p class="text-xs text-white/70 font-bold mt-1">
                    <span class="material-symbols-outlined text-sm align-middle" style="font-variation-settings: 'FILL' 1;">explore</span>
                    {{ __('Explorant la ciutat') }}
                </p>
            </div>
            <div class="w-14 h-14 rounded-[10px] bg-white/20 flex items-center justify-center text-white/60">
                <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">groups</span>
            </div>
        </div>

        {{-- Gimcanes en Curs --}}
        <div class="bg-white dark:bg-slate-900 rounded-[10px] p-6 shadow-sm border border-slate-50 dark:border-slate-800 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 mb-1">{{ __('Gimcanes en Curs') }}</p>
                <p class="text-4xl font-black text-slate-900 dark:text-slate-100">{{ $totalGymkhanas }}</p>
                <p class="text-xs text-orange-500 font-bold mt-1">
                    <span class="material-symbols-outlined text-sm align-middle" style="font-variation-settings: 'FILL' 1;">schedule</span>
                    {{ __('Reptes disponibles') }}
                </p>
            </div>
            <div class="w-14 h-14 rounded-[10px] bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-300 dark:text-slate-600">
                <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">map</span>
            </div>
        </div>
    </div>

    {{-- ── Main Content Block ───────────────────────────────────────────── --}}
    <div class="bg-white dark:bg-slate-900 rounded-[10px] shadow-sm border border-slate-50 dark:border-slate-800 overflow-hidden">

        {{-- Block Header --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h2 class="text-xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Gestió d\'Usuaris') }}</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">{{ __('Llista detallada de participants i administradors') }}</p>
            </div>
            <button id="btn-add-user"
                class="flex items-center gap-2 bg-primary text-white px-5 py-3 rounded-[10px] text-sm font-black shadow-lg shadow-primary/25 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest">
                <span class="material-symbols-outlined text-lg">add</span>
                {{ __('Afegir Nou Usuari') }}
            </button>
        </div>

        {{-- Search + Filters --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 px-6 py-4 border-b border-slate-100 dark:border-slate-800">
            <div class="flex bg-slate-50 dark:bg-slate-800 rounded-[10px] p-1 text-xs font-black gap-1">
                <button data-role="" class="filter-btn px-4 py-2 rounded-[10px] bg-primary text-white shadow-lg shadow-primary/20 transition-all">{{ __('Tots') }}</button>
                <button data-role="admin" class="filter-btn px-4 py-2 rounded-[10px] text-slate-500 dark:text-slate-400 hover:text-primary transition-all">{{ __('Admins') }}</button>
                <button data-role="user" class="filter-btn px-4 py-2 rounded-[10px] text-slate-500 dark:text-slate-400 hover:text-primary transition-all">{{ __('Usuaris') }}</button>
            </div>
            <div class="relative w-full sm:w-72">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none">search</span>
                <input id="search-input" type="text" placeholder="{{ __('Cerca per nom o email...') }}"
                    class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-[10px] text-sm pl-10 pr-4 py-3 focus:ring-4 focus:ring-primary/10 outline-none transition-all dark:text-slate-100 font-medium"
                    value="{{ $search ?? '' }}">
            </div>
        </div>

        {{-- User Table --}}
        <div id="users-container">
            @include('admin.partials.users-list', ['users' => $users, 'search' => $search, 'roleFilter' => $roleFilter])
        </div>
    </div>

    {{-- ── Info Panels ──────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-slate-900 rounded-[10px] p-5 shadow-sm border border-slate-50 dark:border-slate-800 flex gap-4 items-start">
            <div class="w-10 h-10 rounded-[10px] bg-primary/10 flex items-center justify-center text-primary shrink-0">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">info</span>
            </div>
            <div>
                <h4 class="text-sm font-black text-slate-900 dark:text-slate-100">{{ __('Actualització de dades') }}</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-1 leading-relaxed">{{ __('Les estadístiques d\'activitat dels usuaris s\'actualitzen cada 15 minuts. Les modificacions de rol tenen efecte immediat.') }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-[10px] p-5 shadow-sm border border-slate-50 dark:border-slate-800 flex gap-4 items-start">
            <div class="w-10 h-10 rounded-[10px] bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">verified_user</span>
            </div>
            <div>
                <h4 class="text-sm font-black text-slate-900 dark:text-slate-100">{{ __('Política de Privacitat') }}</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-1 leading-relaxed">{{ __('Recordeu seguir les directives RGPD en la gestió de les dades personals dels usuaris de Guia de l\'Hospitalet.') }}</p>
            </div>
        </div>
    </div>
</div>

{{-- ── Add User Modal ───────────────────────────────────────────────────── --}}
<div id="add-user-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-[10px] p-8 shadow-2xl border border-slate-100 dark:border-slate-800 scale-95 transition-transform duration-300">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Nou Usuari') }}</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ __('Afegeix un nou participant o administrador') }}</p>
            </div>
            <button id="close-add-user-modal" class="w-10 h-10 flex items-center justify-center rounded-[10px] bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-primary transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="add-user-form" class="space-y-4">
            <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] px-1">{{ __('Nom Complet') }}</label>
                <input id="new-name" type="text" required
                    class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-4 py-3 focus:ring-4 focus:ring-primary/10 outline-none font-medium dark:text-slate-100">
            </div>
            <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] px-1">{{ __('Email') }}</label>
                <input id="new-email" type="email" required
                    class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-4 py-3 focus:ring-4 focus:ring-primary/10 outline-none font-medium dark:text-slate-100">
            </div>
            <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] px-1">{{ __('Contrasenya') }}</label>
                <input id="new-password" type="password" required
                    class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-4 py-3 focus:ring-4 focus:ring-primary/10 outline-none font-medium dark:text-slate-100">
            </div>
            <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] px-1">{{ __('Rol') }}</label>
                <select id="new-role"
                    class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-4 py-3 focus:ring-4 focus:ring-primary/10 outline-none font-medium dark:text-slate-100 appearance-none cursor-pointer">
                    <option value="user">{{ __('Usuari') }}</option>
                    <option value="admin">{{ __('Administrador') }}</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-primary text-white py-4 rounded-[10px] font-black shadow-xl shadow-primary/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 mt-2 uppercase tracking-widest text-sm">
                <span class="material-symbols-outlined text-lg">person_add</span>
                {{ __('Crear Usuari') }}
            </button>
        </form>
    </div>
</div>

{{-- ── Edit User Modal ──────────────────────────────────────────────────── --}}
<div id="edit-user-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-[10px] p-8 shadow-2xl border border-slate-100 dark:border-slate-800 scale-95 transition-transform duration-300">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Editar Usuari') }}</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ __('Modifica les dades d\'aquest usuari') }}</p>
            </div>
            <button id="close-edit-user-modal" class="w-10 h-10 flex items-center justify-center rounded-[10px] bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-primary transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="edit-user-form" class="space-y-4">
            <input type="hidden" id="edit-user-id">
            <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] px-1">{{ __('Nom Complet') }}</label>
                <input id="edit-name" type="text" required
                    class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-4 py-3 focus:ring-4 focus:ring-primary/10 outline-none font-medium dark:text-slate-100">
            </div>
            <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] px-1">{{ __('Email') }}</label>
                <input id="edit-email" type="email" required
                    class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-4 py-3 focus:ring-4 focus:ring-primary/10 outline-none font-medium dark:text-slate-100">
            </div>
            <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] px-1">{{ __('Rol') }}</label>
                <select id="edit-role"
                    class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-4 py-3 focus:ring-4 focus:ring-primary/10 outline-none font-medium dark:text-slate-100 appearance-none cursor-pointer">
                    <option value="user">{{ __('Usuari') }}</option>
                    <option value="admin">{{ __('Administrador') }}</option>
                </select>
            </div>
            <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] px-1">{{ __('Nova Contrasenya') }} <span class="normal-case font-medium">({{ __('deixa en blanc per no canviar') }})</span></label>
                <input id="edit-password" type="password"
                    class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-4 py-3 focus:ring-4 focus:ring-primary/10 outline-none font-medium dark:text-slate-100">
            </div>
            <button type="submit" class="w-full bg-primary text-white py-4 rounded-[10px] font-black shadow-xl shadow-primary/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 mt-2 uppercase tracking-widest text-sm">
                <span class="material-symbols-outlined text-lg">save</span>
                {{ __('Guardar Canvis') }}
            </button>
        </form>
    </div>
</div>

{{-- ── Delete Confirmation Modal ────────────────────────────────────────── --}}
<div id="delete-user-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-[10px] p-10 shadow-2xl border border-slate-100 dark:border-slate-800 scale-95 transition-transform duration-300">
        <div class="w-20 h-20 bg-red-50 dark:bg-red-500/10 rounded-[10px] flex items-center justify-center mb-6 mx-auto">
            <span class="material-symbols-outlined text-4xl text-red-500">warning</span>
        </div>
        <div class="text-center mb-8">
            <h3 class="text-xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Eliminar Usuari') }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-3 leading-relaxed">
                {{ __('Estàs a punt d\'eliminar l\'usuari') }} <strong id="delete-user-name" class="text-slate-900 dark:text-slate-100"></strong>.<br><br>
                {{ __('Estàs segur que vols continuar?') }}
            </p>
        </div>
        <div class="flex flex-col gap-3">
            <button id="confirm-delete-user" class="w-full bg-red-500 text-white py-4 rounded-[10px] font-black shadow-xl shadow-red-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest text-xs">
                {{ __('SÍ, ELIMINAR') }}
            </button>
            <button id="cancel-delete-user" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 py-4 rounded-[10px] font-black hover:bg-slate-100 transition-all uppercase tracking-widest text-xs border border-slate-100 dark:border-slate-700">
                {{ __('CANCEL·LAR') }}
            </button>
        </div>
    </div>
</div>

{{-- ── Alert Modal ──────────────────────────────────────────────────────── --}}
<div id="user-info-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 w-full max-w-sm rounded-[10px] p-10 shadow-2xl border border-slate-100 dark:border-slate-800 scale-95 transition-transform duration-300">
        <div class="w-16 h-16 bg-primary/10 rounded-[10px] flex items-center justify-center mb-6 mx-auto">
            <span id="user-info-icon" class="material-symbols-outlined text-3xl text-primary">info</span>
        </div>
        <div class="text-center mb-8">
            <h3 id="user-info-title" class="text-xl font-black text-slate-900 dark:text-slate-100 tracking-tight mb-2">{{ __('Avís') }}</h3>
            <p id="user-info-msg" class="text-sm text-slate-500 dark:text-slate-400 font-medium leading-relaxed"></p>
        </div>
        <button id="user-info-close" class="w-full bg-primary text-white py-4 rounded-[10px] font-black hover:bg-primary/90 transition-all uppercase tracking-widest text-xs shadow-lg shadow-primary/20">
            {{ __('D\'acord') }}
        </button>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    let userToDelete = null;
    let searchTimeout;
    let currentRole = '';

    // ── Alert Helper ─────────────────────────────────────────────────────
    const infoModal      = document.getElementById('user-info-modal');
    const infoModalInner = infoModal.querySelector('div');
    const infoMsg        = document.getElementById('user-info-msg');
    const infoTitle      = document.getElementById('user-info-title');
    const infoIcon       = document.getElementById('user-info-icon');

    function showAlert(title, message, type = 'info') {
        infoTitle.textContent = title;
        infoMsg.textContent   = message;
        const icons = { info: 'info', warning: 'warning', error: 'error', success: 'check_circle' };
        infoIcon.textContent  = icons[type] || 'info';
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

    document.getElementById('user-info-close').addEventListener('click', closeInfoModal);
    infoModal.addEventListener('click', e => { if (e.target === infoModal) closeInfoModal(); });

    // ── Modal helpers ─────────────────────────────────────────────────────
    function openModal(modal) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('div').classList.remove('scale-95');
        }, 10);
    }

    function closeModal(modal) {
        modal.classList.add('opacity-0');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    // ── AJAX Fetch ────────────────────────────────────────────────────────
    function fetchUsers(search = '', role = '', page = 1) {
        const container = document.getElementById('users-container');
        container.style.opacity = '0.5';

        const url = new URL("{{ route('admin.users') }}");
        if (search) url.searchParams.set('search', search);
        if (role)   url.searchParams.set('role', role);
        if (page)   url.searchParams.set('page', page);

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => {
                container.innerHTML = html;
                container.style.opacity = '1';
                window.history.pushState({}, '', url);
                bindListEvents();
            })
            .catch(() => { container.style.opacity = '1'; });
    }

    // ── Search ────────────────────────────────────────────────────────────
    const searchInput = document.getElementById('search-input');
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => fetchUsers(this.value, currentRole, 1), 400);
    });

    // ── Role Filters ──────────────────────────────────────────────────────
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20');
                b.classList.add('text-slate-500', 'dark:text-slate-400', 'hover:text-primary');
            });
            this.classList.remove('text-slate-500', 'dark:text-slate-400', 'hover:text-primary');
            this.classList.add('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20');
            currentRole = this.dataset.role;
            fetchUsers(searchInput.value, currentRole, 1);
        });
    });

    // ── Add User Modal ────────────────────────────────────────────────────
    const addUserModal = document.getElementById('add-user-modal');
    document.getElementById('btn-add-user').addEventListener('click', () => openModal(addUserModal));
    document.getElementById('close-add-user-modal').addEventListener('click', () => closeModal(addUserModal));
    addUserModal.addEventListener('click', e => { if (e.target === addUserModal) closeModal(addUserModal); });

    document.getElementById('add-user-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        try {
            const res = await fetch('/admin/users', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: JSON.stringify({
                    name:     document.getElementById('new-name').value,
                    email:    document.getElementById('new-email').value,
                    password: document.getElementById('new-password').value,
                    role:     document.getElementById('new-role').value,
                })
            });
            const data = await res.json();
            if (data.success) {
                closeModal(addUserModal);
                this.reset();
                fetchUsers(searchInput.value, currentRole, 1);
                showAlert('{{ __("Èxit") }}', '{{ __("Usuari creat correctament") }}', 'success');
            } else {
                const errors = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || '{{ __("Error al crear l\'usuari") }}');
                showAlert('{{ __("Error") }}', errors, 'error');
            }
        } catch {
            showAlert('{{ __("Error") }}', '{{ __("Error de xarxa") }}', 'error');
        }
    });

    // ── Edit User Modal ───────────────────────────────────────────────────
    const editUserModal = document.getElementById('edit-user-modal');
    document.getElementById('close-edit-user-modal').addEventListener('click', () => closeModal(editUserModal));
    editUserModal.addEventListener('click', e => { if (e.target === editUserModal) closeModal(editUserModal); });

    window.openEditUser = function(data) {
        document.getElementById('edit-user-id').value    = data.id;
        document.getElementById('edit-name').value       = data.name;
        document.getElementById('edit-email').value      = data.email;
        document.getElementById('edit-role').value       = data.role;
        document.getElementById('edit-password').value   = '';
        openModal(editUserModal);
    };

    document.getElementById('edit-user-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        const id = document.getElementById('edit-user-id').value;
        try {
            const res = await fetch(`/admin/users/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: JSON.stringify({
                    name:     document.getElementById('edit-name').value,
                    email:    document.getElementById('edit-email').value,
                    role:     document.getElementById('edit-role').value,
                    password: document.getElementById('edit-password').value,
                })
            });
            const data = await res.json();
            if (data.success) {
                closeModal(editUserModal);
                fetchUsers(searchInput.value, currentRole, 1);
                showAlert('{{ __("Èxit") }}', '{{ __("Usuari actualitzat correctament") }}', 'success');
            } else {
                const errors = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || '{{ __("Error al actualitzar") }}');
                showAlert('{{ __("Error") }}', errors, 'error');
            }
        } catch {
            showAlert('{{ __("Error") }}', '{{ __("Error de xarxa") }}', 'error');
        }
    });

    // ── Delete Modal ──────────────────────────────────────────────────────
    const deleteUserModal = document.getElementById('delete-user-modal');
    document.getElementById('cancel-delete-user').addEventListener('click', () => closeModal(deleteUserModal));
    deleteUserModal.addEventListener('click', e => { if (e.target === deleteUserModal) closeModal(deleteUserModal); });

    window.openDeleteUser = function(id, name) {
        userToDelete = id;
        document.getElementById('delete-user-name').textContent = name;
        openModal(deleteUserModal);
    };

    document.getElementById('confirm-delete-user').addEventListener('click', async function () {
        if (!userToDelete) return;
        try {
            const res = await fetch(`/admin/users/${userToDelete}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.success) {
                closeModal(deleteUserModal);
                fetchUsers(searchInput.value, currentRole, 1);
                showAlert('{{ __("Èxit") }}', '{{ __("Usuari eliminat correctament") }}', 'success');
            } else {
                closeModal(deleteUserModal);
                showAlert('{{ __("Error") }}', data.message || '{{ __("Error al eliminar") }}', 'error');
            }
        } catch {
            showAlert('{{ __("Error") }}', '{{ __("Error de xarxa") }}', 'error');
        }
        userToDelete = null;
    });

    // ── AJAX Pagination ───────────────────────────────────────────────────
    function bindListEvents() {
        document.querySelectorAll('#users-container nav a').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const url  = new URL(this.href);
                const page = url.searchParams.get('page');
                fetchUsers(searchInput.value, currentRole, page);
            });
        });
    }

    bindListEvents();
});
</script>
@endpush
@endsection
