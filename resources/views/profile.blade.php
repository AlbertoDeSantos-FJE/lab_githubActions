@extends('layouts.admin')

@section('title', __('Gestió del perfil'))
@section('header_title', __('Gestió del perfil'))
@section('hide_search', true)

@section('content')
<div class="w-full max-w-[1400px]">
    <!-- Title Section -->
    <div class="mb-10">
        <h1 class="text-5xl font-black text-slate-900 dark:text-slate-50 tracking-tight mb-3">{{ __('Gestió del perfil') }}</h1>
        <p class="text-slate-500 dark:text-slate-400 font-medium text-lg">{{ __('Gestiona la teva identitat i preferències de l\'entorn de treball a la Guia de l\'Hospitalet.') }}</p>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-12 gap-8">
            <!-- Left Column -->
            <div class="col-span-12 lg:col-span-4 space-y-8">
                <!-- User Card -->
                <div class="bg-white dark:bg-slate-900 rounded-[10px] p-10 shadow-sm border border-slate-100 dark:border-slate-800 flex flex-col items-center">
                    <div class="relative mb-6">
                        <div class="w-36 h-36 rounded-full overflow-hidden border-4 border-slate-50 dark:border-slate-800 shadow-lg bg-primary flex items-center justify-center">
                            @if(Auth::user()->profile_photo)
                                <img id="avatar-preview" alt="Avatar" class="w-full h-full object-cover" src="{{ Auth::user()->profile_photo_url }}"/>
                            @else
                                <span id="avatar-placeholder" class="material-symbols-outlined text-white text-6xl">person</span>
                                <img id="avatar-preview" alt="Avatar" class="w-full h-full object-cover hidden" src=""/>
                            @endif
                        </div>
                        <label for="profile_photo" class="absolute bottom-1 right-1 w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center cursor-pointer hover:scale-110 transition-all shadow-md">
                            <span class="material-symbols-outlined text-lg">photo_camera</span>
                            <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*" onchange="previewImage(this)"/>
                        </label>
                    </div>
                    
                    <h3 class="text-2xl font-black text-slate-900 dark:text-slate-50 mb-1 text-center">
                        {{ Auth::user()->name }}
                    </h3>
                    <p class="text-slate-500 dark:text-slate-400 font-bold text-sm mb-4 text-center">Urban Curator Senior</p>
                    
                    <div class="bg-primary/10 text-primary dark:text-primary-container px-5 py-1.5 rounded-full text-xs font-black uppercase tracking-widest flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
                        {{ __('EN LÍNIA') }}
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="bg-white dark:bg-slate-900 rounded-[10px] p-8 shadow-sm border border-slate-100 dark:border-slate-800">
                    <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-6">{{ __('Estadístiques') }}</h4>
                    
                    <div class="space-y-6">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-600 dark:text-slate-400 font-medium">{{ __('Activitats') }}</span>
                            <span class="text-slate-900 dark:text-slate-50 font-black">24</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-600 dark:text-slate-400 font-medium">{{ __('Rutes') }}</span>
                            <span class="text-slate-900 dark:text-slate-50 font-black">12</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-600 dark:text-slate-400 font-medium">{{ __('Darrera sessió') }}</span>
                            <span class="text-slate-900 dark:text-slate-50 font-black">Avui, 09:41</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-span-12 lg:col-span-8 space-y-8">
                <!-- Informació Personal Card -->
                <div class="bg-white dark:bg-slate-900 rounded-[10px] p-10 shadow-sm border border-slate-100 dark:border-slate-800">
                    <h4 class="text-xl font-black text-slate-900 dark:text-slate-50 flex items-center gap-3 mb-10">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">person_edit</span>
                        {{ __('Informació Personal') }}
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Nom -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">{{ __('Nom') }}</label>
                            <input name="name" type="text" value="{{ explode(' ', Auth::user()->name)[0] }}" class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-6 py-4 focus:ring-2 focus:ring-primary/20 transition-all dark:text-slate-100 font-medium"/>
                        </div>
                        <!-- Cognoms -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">{{ __('Cognoms') }}</label>
                            <input name="surname" type="text" value="{{ count(explode(' ', Auth::user()->name)) > 1 ? implode(' ', array_slice(explode(' ', Auth::user()->name), 1)) : 'Vila' }}" class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-6 py-4 focus:ring-2 focus:ring-primary/20 transition-all dark:text-slate-100 font-medium"/>
                        </div>
                        <!-- Correu -->
                        <div class="col-span-1 md:col-span-2 space-y-3">
                            <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">{{ __('Correu Electrònic') }}</label>
                            <div class="relative">
                                <input name="email" type="email" value="{{ Auth::user()->email }}" class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-6 py-4 focus:ring-2 focus:ring-primary/20 transition-all dark:text-slate-100 font-medium"/>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 w-5 h-5 bg-primary text-white rounded-full flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[12px] font-bold">check</span>
                                </div>
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="col-span-1 md:col-span-2 space-y-3">
                            <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">{{ __('Contrasenya') }}</label>
                            <div class="relative flex items-center">
                                <input id="password" name="password" type="password" placeholder="{{ __('Introdueix una nova contrasenya') }}" autocomplete="new-password" class="w-full bg-[#f0e3ff] dark:bg-slate-800/50 border-none rounded-[10px] text-sm px-6 py-4 focus:ring-2 focus:ring-primary/20 transition-all dark:text-slate-100 font-medium"/>
                                <button type="button" id="toggle-password" class="absolute right-5 text-slate-400 hover:text-primary transition-colors hidden h-full flex items-center">
                                    <span class="material-symbols-outlined select-none">visibility</span>
                                </button>
                                <button type="button" id="change-password-btn" onclick="document.getElementById('password').focus()" class="absolute right-5 text-[10px] font-black text-primary uppercase tracking-widest hover:underline">{{ __('Canviar') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preferències Card -->
                <div class="bg-white dark:bg-slate-900 rounded-[10px] p-10 shadow-sm border border-slate-100 dark:border-slate-800">
                    <h4 class="text-xl font-black text-slate-900 dark:text-slate-50 flex items-center gap-3 mb-8">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">tune</span>
                        {{ __('Preferències') }}
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <div class="space-y-6">
                            <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">{{ __('Idioma Preferit') }}</label>
                            
                            <div class="relative group w-full">
                                <button type="button" class="w-full flex items-center justify-between p-4 bg-[#f0e3ff] dark:bg-slate-800/50 rounded-[10px] border-2 border-transparent hover:border-primary/20 transition-all text-sm font-bold text-slate-700 dark:text-slate-200">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-primary">language</span>
                                        <span>{{ app()->getLocale() == 'ca' ? 'Català' : (app()->getLocale() == 'es' ? 'Español' : 'English') }}</span>
                                    </div>
                                    <span class="material-symbols-outlined">expand_more</span>
                                </button>
                                <div class="absolute left-0 top-full w-full h-3 z-40 hidden group-hover:block"></div>
                                <div class="absolute left-0 top-full mt-2 w-full bg-white dark:bg-slate-800 rounded-[10px] shadow-xl border border-slate-100 dark:border-slate-800 hidden group-hover:block overflow-hidden z-50 transition-all duration-300">
                                    <a class="flex items-center gap-3 px-6 py-4 text-sm font-bold hover:bg-[#f7edff] dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition-colors" href="{{ route('lang.switch', 'ca') }}">
                                        <span class="material-symbols-outlined text-primary text-lg">{{ app()->getLocale() == 'ca' ? 'check_circle' : 'circle' }}</span>
                                        Català
                                    </a>
                                    <a class="flex items-center gap-3 px-6 py-4 text-sm font-bold hover:bg-[#f7edff] dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition-colors" href="{{ route('lang.switch', 'es') }}">
                                        <span class="material-symbols-outlined {{ app()->getLocale() == 'es' ? 'text-primary' : 'text-slate-300 dark:text-slate-600' }} text-lg">{{ app()->getLocale() == 'es' ? 'check_circle' : 'circle' }}</span>
                                        Español
                                    </a>
                                    <a class="flex items-center gap-3 px-6 py-4 text-sm font-bold hover:bg-[#f7edff] dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition-colors" href="{{ route('lang.switch', 'en') }}">
                                        <span class="material-symbols-outlined {{ app()->getLocale() == 'en' ? 'text-primary' : 'text-slate-300 dark:text-slate-600' }} text-lg">{{ app()->getLocale() == 'en' ? 'check_circle' : 'circle' }}</span>
                                        English
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Mode Visual -->
                        <div class="space-y-6">
                            <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">{{ __('Mode Visual') }}</label>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="radio" name="theme_select" id="theme_light" value="light" class="hidden radio-card" onchange="updateTheme(false)"/>
                                    <label for="theme_light" id="label_light" class="flex flex-col items-center justify-center p-6 bg-[#f0e3ff] dark:bg-slate-800/50 rounded-[10px] cursor-pointer border-2 border-transparent transition-all h-32 hover:bg-white dark:hover:bg-slate-800">
                                        <div class="w-16 h-10 bg-white rounded-[10px] mb-3 shadow-sm flex items-center justify-center">
                                            <span class="material-symbols-outlined text-amber-500">light_mode</span>
                                        </div>
                                        <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ __('Clar') }}</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" name="theme_select" id="theme_dark" value="dark" class="hidden radio-card" onchange="updateTheme(true)"/>
                                    <label for="theme_dark" id="label_dark" class="flex flex-col items-center justify-center p-6 bg-[#f0e3ff] dark:bg-slate-800/50 rounded-[10px] cursor-pointer border-2 border-transparent transition-all h-32 hover:bg-white dark:hover:bg-slate-800">
                                        <div class="w-16 h-10 bg-slate-900 rounded-[10px] mb-3 shadow-sm flex items-center justify-center">
                                            <span class="material-symbols-outlined text-violet-400">dark_mode</span>
                                        </div>
                                        <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ __('Fosc') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="mt-12 mb-20 flex justify-end items-center gap-6">
            <button type="button" class="px-8 py-3 rounded-[10px] text-sm font-black text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-all uppercase tracking-widest">{{ __('Descartar') }}</button>
            <button type="submit" class="px-10 py-4 bg-primary text-white rounded-[10px] text-sm font-black shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all uppercase tracking-widest">{{ __('Desar canvis') }}</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Image Preview
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                const placeholder = document.getElementById('avatar-placeholder');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Password Visibility Toggle Logic
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.getElementById('toggle-password');
    const toggleIcon = toggleBtn.querySelector('span');
    const changeBtn = document.getElementById('change-password-btn');

    passwordInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            toggleBtn.classList.remove('hidden');
            changeBtn.classList.add('hidden');
        } else {
            toggleBtn.classList.add('hidden');
            changeBtn.classList.remove('hidden');
        }
    });

    toggleBtn.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        toggleIcon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
    });
</script>
@endpush
