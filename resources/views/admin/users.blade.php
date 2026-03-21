@extends('layouts.admin')

@section('title', __('Gestió d\'Usuaris'))
@section('header_title', __('Gestió d\'Usuaris'))

@section('content')
<div class="flex flex-col gap-8">
    <div class="space-y-2">
        <span class="text-primary font-black tracking-[0.2em] text-[10px] uppercase bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/10">{{ __('Comunitat') }}</span>
        <h3 class="text-4xl font-black tracking-tight text-slate-900 dark:text-slate-100">{{ __('Usuaris i Permisos') }}</h3>
        <p class="text-slate-500 dark:text-slate-400 font-medium">{{ __('Gestiona els perfils i els rols dels administradors i participants.') }}</p>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-12 shadow-sm border border-slate-50 dark:border-slate-800 flex flex-col items-center text-center gap-6">
        <div class="w-24 h-24 rounded-[2rem] bg-primary/5 flex items-center justify-center text-primary mb-2">
            <span class="material-symbols-outlined text-5xl" style="font-variation-settings: 'FILL' 1;">construction</span>
        </div>
        <div>
            <h3 class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ __('Pròximament') }}</h3>
            <p class="text-slate-500 dark:text-slate-400 font-medium mt-2 max-w-md mx-auto">{{ __('La gestió d\'usuaris i permisos estarà disponible en la propera actualització del panell d\'administració.') }}</p>
        </div>
        <div class="flex gap-4 mt-4">
            <div class="px-6 py-3 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">
                {{ __('Versió 1.2') }}
            </div>
            <div class="px-6 py-3 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">
                {{ __('Abril 2024') }}
            </div>
        </div>
    </div>
</div>
@endsection
