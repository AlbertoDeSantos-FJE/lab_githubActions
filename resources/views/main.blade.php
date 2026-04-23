<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Benvingut - Guia de l'Hospitalet</title>
    
    <!-- Tailwind & Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <style>
        body { background-color: #fcf4ff; color: #14052b; min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif;}
        .dark body { background-color: #020617; color: #f8fafc; }
    </style>
</head>
<body class="bg-violet-50 dark:bg-slate-900 flex items-center justify-center min-h-screen p-4 transition-colors duration-300">

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-violet-100 dark:border-slate-700 p-8 w-full max-w-md text-center">
        
        <div class="w-16 h-16 bg-violet-600 rounded-2xl mx-auto flex items-center justify-center text-white mb-6 shadow-lg shadow-violet-600/30">
            <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">waving_hand</span>
        </div>

        <h1 class="text-3xl font-extrabold mb-2 text-violet-900 dark:text-violet-100">Bienvenido</h1>
        
        <p class="text-lg font-medium text-slate-600 dark:text-slate-400 mb-8">
            {{ Auth::user()->name }}
        </p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-500/10 dark:hover:bg-red-500/20 dark:text-red-400 py-3 rounded-xl transition-all font-bold group border border-red-100 dark:border-red-900/30 hover:scale-[1.02] active:scale-95">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">logout</span>
                <span>Cerrar sesión</span>
            </button>
        </form>
        
    </div>

</body>
</html>
