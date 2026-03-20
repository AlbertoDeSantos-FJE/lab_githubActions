<!DOCTYPE html>

<html class="light" lang="ca"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Admin Panel - Guia de l'Hospitalet</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "surface-variant": "#e7d6ff",
              "on-primary-container": "#230076",
              "on-secondary-fixed-variant": "#665500",
              "secondary-container": "#ffd709",
              "surface": "#fcf4ff",
              "surface-container": "#f0e3ff",
              "inverse-on-surface": "#a795c3",
              "on-surface": "#36274e",
              "on-secondary": "#fff2cd",
              "on-primary-fixed": "#000000",
              "primary-dim": "#5130c6",
              "inverse-primary": "#937dff",
              "tertiary-fixed-dim": "#ff7a7b",
              "on-error": "#ffefef",
              "on-tertiary-container": "#680011",
              "on-error-container": "#510017",
              "tertiary": "#b71029",
              "on-background": "#36274e",
              "on-secondary-container": "#5b4b00",
              "on-secondary-fixed": "#453900",
              "secondary-fixed": "#ffd709",
              "tertiary-dim": "#a30021",
              "surface-container-lowest": "#ffffff",
              "surface-bright": "#fcf4ff",
              "primary-container": "#a391ff",
              "surface-container-high": "#ecdcff",
              "tertiary-container": "#ff9190",
              "on-primary": "#f6f0ff",
              "on-tertiary-fixed": "#3a0006",
              "background": "#fcf4ff",
              "inverse-surface": "#14052b",
              "error-container": "#f74b6d",
              "secondary-dim": "#5e4e00",
              "primary": "#5d3fd3",
              "surface-container-low": "#f7edff",
              "outline": "#806f9b",
              "primary-fixed-dim": "#9680ff",
              "outline-variant": "#b7a5d4",
              "tertiary-fixed": "#ff9190",
              "surface-tint": "#5d3fd3",
              "on-primary-fixed-variant": "#2c008f",
              "secondary": "#6c5a00",
              "surface-container-highest": "#e7d6ff",
              "on-surface-variant": "#64547e",
              "surface-dim": "#e0cbff",
              "on-tertiary": "#ffefee",
              "primary-fixed": "#a391ff",
              "error": "#b41340",
              "error-dim": "#a70138",
              "secondary-fixed-dim": "#efc900",
              "on-tertiary-fixed-variant": "#790016"
            },
            fontFamily: {
              "headline": ["Plus Jakarta Sans"],
              "body": ["Inter"],
              "label": ["Inter"]
            },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #dcd0ef; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #5d3fd3; }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen flex overflow-hidden">
<!-- Sidebar Navigation -->
<aside class="hidden md:flex flex-col h-screen w-64 bg-[#f7edff] dark:bg-slate-900 border-r-0 py-6 shrink-0 z-40 font-['Plus_Jakarta_Sans'] text-sm font-medium">
<div class="mb-10 px-6 flex justify-center">
<img alt="Logo" class="h-10 w-auto" src="https://lh3.googleusercontent.com/aida/ADBb0ugZMK3wAYFw6LvogaW0ILthSpwSbN0kXe0YTI0YFDHHjj0PU36bi8iMQOszguZo5rHYIAVm7cbLT7sINDeFmqz7FxzrdKn5GM8aNkVOThTLGkvhxTaaUMXomEqBBc0C0TC7vEnrh6GKqq-NDIQb0kjINpnsdLB2i6YMCISCtXoGVxIhHUmklC2Dq6GqMzNvkFubXbRblirqj7eJnZckgR0Uf-uE_0cj2ICRvvwCgMjXDZQmOmCt5Md1E5NfTDMDeo-c93-N7qfhEQ"/>
</div>
<nav class="flex flex-col space-y-2">
<a class="bg-[#5d3fd3] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 transition-all active:translate-x-1 duration-200 shadow-lg shadow-[#5d3fd3]/30" href="#">
<span class="material-symbols-outlined text-xl" data-icon="location_on" style="font-variation-settings: 'FILL' 1;">location_on</span>
<span>Llocs</span>
</a>
<a class="text-slate-600 dark:text-slate-400 mx-2 my-1 px-4 py-3 flex items-center gap-3 hover:bg-[#a391ff]/20 dark:hover:bg-[#5d3fd3]/20 rounded-lg transition-all active:translate-x-1 duration-200" href="#">
<span class="material-symbols-outlined text-xl" data-icon="extension">extension</span>
<span>Gimcanes</span>
</a>
<a class="text-slate-600 dark:text-slate-400 mx-2 my-1 px-4 py-3 flex items-center gap-3 hover:bg-[#a391ff]/20 dark:hover:bg-[#5d3fd3]/20 rounded-lg transition-all active:translate-x-1 duration-200" href="#">
<span class="material-symbols-outlined text-xl" data-icon="category">category</span>
<span>Categories</span>
</a>
<a class="text-slate-600 dark:text-slate-400 mx-2 my-1 px-4 py-3 flex items-center gap-3 hover:bg-[#a391ff]/20 dark:hover:bg-[#5d3fd3]/20 rounded-lg transition-all active:translate-x-1 duration-200" href="#">
<span class="material-symbols-outlined text-xl" data-icon="group">group</span>
<span>Usuaris</span>
</a>
</nav>
</aside>
<!-- Main Content Canvas -->
<main class="flex-1 flex flex-col relative overflow-hidden h-screen">
<!-- TopAppBar -->
<header class="sticky top-0 z-50 flex justify-between items-center w-full px-6 py-3 bg-[#fcf4ff] dark:bg-slate-950 border-b border-[#f7edff] dark:border-slate-900 font-['Plus_Jakarta_Sans'] antialiased">
<div class="flex items-center gap-6">
<h2 class="text-[#5d3fd3] dark:text-[#a391ff] font-black tracking-tight text-xl">Gestió de Llocs</h2>
<div class="hidden lg:flex items-center bg-[#f7edff] dark:bg-slate-900 px-4 py-2 rounded-2xl w-80 group focus-within:ring-2 focus-within:ring-[#5d3fd3]/20 transition-all">
<span class="material-symbols-outlined text-lg text-slate-600 dark:text-slate-400 mr-3" data-icon="search">search</span>
<input class="bg-transparent border-none text-sm focus:ring-0 p-0 w-full placeholder:text-slate-600/50" placeholder="Cerca llocs o rutes..." type="text"/>
</div>
</div>
<div class="flex items-center gap-2">
<div class="relative group">
<button class="flex items-center gap-1 px-3 py-1.5 rounded-lg hover:bg-[#f7edff] dark:hover:bg-slate-800 transition-all text-xs font-bold text-[#5d3fd3] dark:text-[#a391ff] active:opacity-80 active:scale-95">
<span class="material-symbols-outlined text-sm" data-icon="language">language</span>
<span>CA</span>
<span class="material-symbols-outlined text-[14px]" data-icon="expand_more">expand_more</span>
</button>
<div class="absolute right-0 top-full mt-1 w-32 bg-white dark:bg-slate-800 rounded-lg shadow-xl border border-outline-variant/20 hidden group-hover:block overflow-hidden z-50">
<a class="block px-4 py-2 text-xs hover:bg-[#f7edff] dark:hover:bg-slate-700 text-on-surface" href="#">Català</a>
<a class="block px-4 py-2 text-xs hover:bg-[#f7edff] dark:hover:bg-slate-700 text-on-surface" href="#">Español</a>
<a class="block px-4 py-2 text-xs hover:bg-[#f7edff] dark:hover:bg-slate-700 text-on-surface" href="#">English</a>
</div>
</div>
<div class="h-6 w-[1px] bg-surface-container-highest mx-1"></div>
<button class="p-2.5 dark:text-slate-400 hover:bg-[#f7edff] dark:hover:bg-slate-800 transition-colors rounded-2xl active:opacity-80 active:scale-95 transition-all text-[#5d3fd3]" id="dark-mode-toggle">
<span class="material-symbols-outlined" data-icon="dark_mode">dark_mode</span>
</button>
<button class="p-2.5 text-[#5d3fd3] hover:bg-[#5d3fd3]/10 transition-colors rounded-2xl active:opacity-80 active:scale-95 transition-all">
<span class="material-symbols-outlined" data-icon="logout">logout</span>
</button>
<div class="ml-2 w-8 h-8 rounded-full bg-surface-container-highest overflow-hidden border border-[#5d3fd3]/20 cursor-pointer">
<img alt="Admin user profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDfto521M3O06b0GivjHze8HMXvDGY7ht3tlg_RdfE0iQXyngCB4RRMxdKSNT_W6rHs9VMnHchQqzi4y2mDB_aKh0MXn7fKMEfWORBX7SQL3gD2vaEY-BlQQFLzzCze-zDt110_NdnCYzQDgMFvVVTKSojsSKCQIitgoD8V3TRLZIcHQ4E2566DV6sOocLYOxCC4FLC8JcQVR4Iyiy68IOZJ2EGHKQZNM-563gyzkPW8HB3E-uKN0p-QgOYUvuOxj2nhS-qCN6Zyd8"/>
</div>
</div>
</header>
<!-- Dashboard Layout -->
<div class="flex-1 overflow-y-auto p-8 flex flex-col gap-8 bg-surface/50">
<!-- Top Section: Map and Add Place -->
<div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-stretch shrink-0">
<!-- Central Map Section -->
<div class="xl:col-span-8 flex flex-col gap-4">
<div class="h-full min-h-[500px] bg-surface-container-lowest rounded-[2rem] overflow-hidden relative shadow-[0_24px_48px_-12px_rgba(54,39,78,0.1)] group border border-white">
<div class="absolute inset-0 z-0">
<img class="w-full h-full object-cover filter contrast-[0.8] brightness-[0.95] grayscale-[0.1]" data-alt="Map of Barcelona Hospitalet district with modern minimalist markers" data-location="L'Hospitalet de Llobregat" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAZw2IbpsHOXGQyptoA9KqmpdORlewKLcEgnPnkjPOGCliFhhw-O5s2QqiQTl59dZtmQ2tIqSUJ3_MZzgGIG-SMMUOblKfv4dWW10krU-IMr7Wqy1WIz3Mqe076sXnxJOeQoz-Rh1cf3xUkpFd6VsqJVX_mkCe-5GE_lifqc4YamcuSLPVFJ35HRsCaHHpmE0qfDdM7x4vwNkkSKLKbGbmuTutj3-fQpftVT3XSuNacCGESjz7et_B4IxDN5_Pywj4m3ctcOo5MFxg"/>
</div>
<div class="absolute top-6 left-6 flex gap-2 z-10">
<span class="px-4 py-2 bg-white/90 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-widest text-primary flex items-center gap-2 shadow-sm border border-primary/10">
<span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Visualització En Viu
                        </span>
</div>
<!-- Markers -->
<div class="absolute top-1/3 left-1/4 z-10 group/marker cursor-pointer">
<div class="bg-tertiary text-on-tertiary p-2.5 rounded-2xl shadow-xl scale-100 group-hover/marker:scale-125 transition-all duration-300">
<span class="material-symbols-outlined text-sm" data-icon="restaurant" style="font-variation-settings: 'FILL' 1;">restaurant</span>
</div>
</div>
<div class="absolute top-1/2 left-1/2 z-10 group/marker cursor-pointer">
<div class="bg-secondary text-on-secondary p-2.5 rounded-2xl shadow-xl scale-100 group-hover/marker:scale-125 transition-all duration-300">
<span class="material-symbols-outlined text-sm" data-icon="museum" style="font-variation-settings: 'FILL' 1;">museum</span>
</div>
</div>
<div class="absolute bottom-1/4 right-1/3 z-10 group/marker cursor-pointer">
<div class="bg-primary text-on-primary p-2.5 rounded-2xl shadow-xl scale-100 group-hover/marker:scale-125 transition-all duration-300">
<span class="material-symbols-outlined text-sm" data-icon="location_city" style="font-variation-settings: 'FILL' 1;">location_city</span>
</div>
</div>
<div class="absolute bottom-8 left-8 right-8 flex justify-between items-end z-10">
<div class="bg-white/95 backdrop-blur-xl p-5 rounded-3xl shadow-2xl w-72 border border-white/50">
<h4 class="font-black text-sm mb-1 text-on-surface">Centre d'Art Tecla Sala</h4>
<p class="text-[11px] text-on-surface-variant leading-relaxed mb-4 opacity-80">Museu i espai cultural de referència a l'Hospitalet de Llobregat.</p>
<div class="flex gap-2">
<span class="bg-secondary-container text-on-secondary-container text-[9px] px-2.5 py-1 rounded-lg font-black uppercase tracking-tighter">CULTURA</span>
<span class="bg-primary-container/30 text-primary text-[9px] px-2.5 py-1 rounded-lg font-black uppercase tracking-tighter">MUSEU</span>
</div>
</div>
<div class="flex flex-col gap-3">
<button class="bg-white/90 backdrop-blur-md p-3 rounded-2xl shadow-lg text-on-surface hover:bg-primary hover:text-on-primary transition-all active:scale-90">
<span class="material-symbols-outlined" data-icon="add">add</span>
</button>
<button class="bg-white/90 backdrop-blur-md p-3 rounded-2xl shadow-lg text-on-surface hover:bg-primary hover:text-on-primary transition-all active:scale-90">
<span class="material-symbols-outlined" data-icon="remove">remove</span>
</button>
<button class="bg-primary text-on-primary p-4 rounded-3xl shadow-xl hover:shadow-primary/40 transition-all active:scale-90">
<span class="material-symbols-outlined" data-icon="my_location">my_location</span>
</button>
</div>
</div>
</div>
</div>
<!-- Add Place Form -->
<div class="xl:col-span-4 bg-surface-container-lowest rounded-[2rem] p-8 shadow-[0_24px_48px_-12px_rgba(54,39,78,0.06)] flex flex-col gap-6 border border-white">
<div>
<h3 class="font-black text-xl text-on-surface tracking-tight">Afegir Nou Lloc</h3>
<p class="text-xs text-on-surface-variant mt-1">Dades del nou punt d'interès per a la ruta.</p>
</div>
<div class="space-y-4 flex-1">
<div class="space-y-1.5">
<label class="text-[10px] font-black text-on-surface-variant uppercase tracking-[0.15em] px-1">Nom del Lloc</label>
<input class="w-full bg-surface-container-low border border-surface-container-highest/20 rounded-2xl text-sm px-5 py-3 focus:ring-4 focus:ring-primary/10 transition-all placeholder:text-outline-variant outline-none" placeholder="Ex: Restaurant L'H" type="text"/>
</div>
<div class="space-y-1.5">
<label class="text-[10px] font-black text-on-surface-variant uppercase tracking-[0.15em] px-1">Adreça</label>
<div class="relative">
<input class="w-full bg-surface-container-low border border-surface-container-highest/20 rounded-2xl text-sm px-5 py-3 focus:ring-4 focus:ring-primary/10 transition-all placeholder:text-outline-variant outline-none" placeholder="Carrer de l'Hospitalet, 42" type="text"/>
<span class="material-symbols-outlined absolute right-4 top-2.5 text-outline text-xl" data-icon="map">map</span>
</div>
</div>
<div class="grid grid-cols-2 gap-4">
<div class="space-y-1.5">
<label class="text-[10px] font-black text-on-surface-variant uppercase tracking-[0.15em] px-1">Latitud</label>
<input class="w-full bg-surface-container-low border border-surface-container-highest/20 rounded-2xl text-sm px-5 py-3 outline-none" placeholder="41.3597" type="text"/>
</div>
<div class="space-y-1.5">
<label class="text-[10px] font-black text-on-surface-variant uppercase tracking-[0.15em] px-1">Longitud</label>
<input class="w-full bg-surface-container-low border border-surface-container-highest/20 rounded-2xl text-sm px-5 py-3 outline-none" placeholder="2.1003" type="text"/>
</div>
</div>
<div class="space-y-2">
<label class="text-[10px] font-black text-on-surface-variant uppercase tracking-[0.15em] px-1">Categories</label>
<div class="bg-surface-container-low border border-surface-container-highest/20 rounded-2xl p-4 max-h-[160px] overflow-y-auto space-y-2">
<label class="flex items-center gap-3 p-2 hover:bg-white rounded-xl cursor-pointer transition-colors group">
<input checked="" class="rounded-lg border-outline-variant text-primary focus:ring-primary h-5 w-5" type="checkbox"/>
<span class="text-sm font-semibold text-on-surface-variant group-hover:text-primary transition-colors">Restaurant</span>
</label>
<label class="flex items-center gap-3 p-2 hover:bg-white rounded-xl cursor-pointer transition-colors group">
<input class="rounded-lg border-outline-variant text-primary focus:ring-primary h-5 w-5" type="checkbox"/>
<span class="text-sm font-semibold text-on-surface-variant group-hover:text-primary transition-colors">Museu</span>
</label>
<label class="flex items-center gap-3 p-2 hover:bg-white rounded-xl cursor-pointer transition-colors group">
<input class="rounded-lg border-outline-variant text-primary focus:ring-primary h-5 w-5" type="checkbox"/>
<span class="text-sm font-semibold text-on-surface-variant group-hover:text-primary transition-colors">Monument</span>
</label>
</div>
</div>
</div>
<button class="w-full bg-primary text-on-primary font-black py-4 rounded-2xl flex items-center justify-center gap-2 hover:bg-primary-dim shadow-xl shadow-primary/30 transition-all active:scale-95 text-sm uppercase tracking-widest mt-auto">
<span class="material-symbols-outlined" data-icon="add_location">add_location</span>
                    Guardar Punt
                </button>
</div>
</div>
<!-- Expanded Places List Section -->
<div class="flex flex-col gap-6">
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
<div>
<h3 class="font-black text-2xl text-on-surface tracking-tight">Llistat de Llocs</h3>
<p class="text-sm text-on-surface-variant font-medium">Gestiona els elements existents a la base de dades.</p>
</div>
<div class="flex items-center gap-3 w-full md:w-auto">
<div class="relative group w-full md:w-48">
<button class="w-full px-4 py-2.5 bg-surface-container-lowest text-on-surface font-bold rounded-2xl text-xs flex items-center justify-between gap-2 hover:bg-surface-container-highest transition-all border border-white shadow-sm">
<span class="flex items-center gap-2">
<span class="material-symbols-outlined text-lg text-primary" data-icon="filter_alt">filter_alt</span>
                                Filtrar per Categoria
                            </span>
<span class="material-symbols-outlined text-lg" data-icon="expand_more">expand_more</span>
</button>
<div class="absolute right-0 top-full mt-2 w-full bg-white rounded-2xl shadow-xl border border-outline-variant/10 hidden group-hover:block overflow-hidden z-20">
<a class="block px-4 py-3 text-xs font-bold hover:bg-[#f7edff] text-on-surface" href="#">Totes</a>
<a class="block px-4 py-3 text-xs font-bold hover:bg-[#f7edff] text-on-surface" href="#">Cultura</a>
<a class="block px-4 py-3 text-xs font-bold hover:bg-[#f7edff] text-on-surface" href="#">Gastronomia</a>
</div>
</div>
<button class="px-6 py-2.5 bg-primary text-on-primary font-black rounded-2xl text-xs flex items-center gap-2 hover:bg-primary-dim transition-all shadow-sm">
<span class="material-symbols-outlined text-lg" data-icon="download">download</span>
                        Exportar
                    </button>
</div>
</div>
<!-- Header Row -->
<div class="grid grid-cols-12 gap-4 px-8 py-3 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">
<div class="col-span-4">Nom i Localització</div>
<div class="col-span-4">Adreça</div>
<div class="col-span-2">Categoria</div>
<div class="col-span-2 text-right">Accions</div>
</div>
<!-- List of Items (Extended) -->
<div class="flex flex-col gap-3">
<!-- Row Template -->
<div class="grid grid-cols-12 gap-4 items-center bg-surface-container-lowest px-8 py-4 rounded-3xl shadow-sm border border-white hover:border-primary/20 transition-all group">
<div class="col-span-4 flex items-center gap-4">
<div class="w-10 h-10 rounded-xl bg-secondary-container flex items-center justify-center text-on-secondary-container shrink-0">
<span class="material-symbols-outlined text-xl" data-icon="museum" style="font-variation-settings: 'FILL' 1;">museum</span>
</div>
<div class="truncate">
<h4 class="font-black text-sm text-on-surface truncate">Museu de L'Hospitalet</h4>
<span class="text-[10px] font-bold text-on-surface-variant opacity-60">Afegit ahir</span>
</div>
</div>
<div class="col-span-4 flex items-center gap-2 text-xs text-on-surface-variant font-medium truncate">
<span class="material-symbols-outlined text-[16px] text-primary" data-icon="location_on">location_on</span>
                        Carrer del Xipreret, 27
                    </div>
<div class="col-span-2">
<span class="text-[9px] font-black text-primary uppercase tracking-widest bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/10">CULTURA</span>
</div>
<div class="col-span-2 flex justify-end gap-1">
<button class="w-9 h-9 flex items-center justify-center hover:bg-primary/10 text-primary rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="edit">edit</span>
</button>
<button class="w-9 h-9 flex items-center justify-center hover:bg-error/10 text-error rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="delete">delete</span>
</button>
</div>
</div>
<!-- Item 2 -->
<div class="grid grid-cols-12 gap-4 items-center bg-surface-container-lowest px-8 py-4 rounded-3xl shadow-sm border border-white hover:border-primary/20 transition-all group">
<div class="col-span-4 flex items-center gap-4">
<div class="w-10 h-10 rounded-xl bg-tertiary-container/30 flex items-center justify-center text-tertiary shrink-0">
<span class="material-symbols-outlined text-xl" data-icon="restaurant" style="font-variation-settings: 'FILL' 1;">restaurant</span>
</div>
<div class="truncate">
<h4 class="font-black text-sm text-on-surface truncate">El Racó de la Plaça</h4>
<span class="text-[10px] font-bold text-on-surface-variant opacity-60">Afegit fa 2 dies</span>
</div>
</div>
<div class="col-span-4 flex items-center gap-2 text-xs text-on-surface-variant font-medium truncate">
<span class="material-symbols-outlined text-[16px] text-primary" data-icon="location_on">location_on</span>
                        Plaça de l'Ajuntament, 5
                    </div>
<div class="col-span-2">
<span class="text-[9px] font-black text-primary uppercase tracking-widest bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/10">GASTRONOMIA</span>
</div>
<div class="col-span-2 flex justify-end gap-1">
<button class="w-9 h-9 flex items-center justify-center hover:bg-primary/10 text-primary rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="edit">edit</span>
</button>
<button class="w-9 h-9 flex items-center justify-center hover:bg-error/10 text-error rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="delete">delete</span>
</button>
</div>
</div>
<!-- Item 3 -->
<div class="grid grid-cols-12 gap-4 items-center bg-surface-container-lowest px-8 py-4 rounded-3xl shadow-sm border border-white hover:border-primary/20 transition-all group">
<div class="col-span-4 flex items-center gap-4">
<div class="w-10 h-10 rounded-xl bg-primary-container/30 flex items-center justify-center text-primary shrink-0">
<span class="material-symbols-outlined text-xl" data-icon="park" style="font-variation-settings: 'FILL' 1;">park</span>
</div>
<div class="truncate">
<h4 class="font-black text-sm text-on-surface truncate">Parc de Can Boixeres</h4>
<span class="text-[10px] font-bold text-on-surface-variant opacity-60">Afegit fa 1 setmana</span>
</div>
</div>
<div class="col-span-4 flex items-center gap-2 text-xs text-on-surface-variant font-medium truncate">
<span class="material-symbols-outlined text-[16px] text-primary" data-icon="location_on">location_on</span>
                        Camí de Can Boixeres, s/n
                    </div>
<div class="col-span-2">
<span class="text-[9px] font-black text-primary uppercase tracking-widest bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/10">NATURA</span>
</div>
<div class="col-span-2 flex justify-end gap-1">
<button class="w-9 h-9 flex items-center justify-center hover:bg-primary/10 text-primary rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="edit">edit</span>
</button>
<button class="w-9 h-9 flex items-center justify-center hover:bg-error/10 text-error rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="delete">delete</span>
</button>
</div>
</div>
<!-- Item 4 -->
<div class="grid grid-cols-12 gap-4 items-center bg-surface-container-lowest px-8 py-4 rounded-3xl shadow-sm border border-white hover:border-primary/20 transition-all group">
<div class="col-span-4 flex items-center gap-4">
<div class="w-10 h-10 rounded-xl bg-surface-container-highest flex items-center justify-center text-on-surface-variant shrink-0">
<span class="material-symbols-outlined text-xl" data-icon="church" style="font-variation-settings: 'FILL' 1;">church</span>
</div>
<div class="truncate">
<h4 class="font-black text-sm text-on-surface truncate">Església de Santa Eulàlia</h4>
<span class="text-[10px] font-bold text-on-surface-variant opacity-60">Afegit fa 1 mes</span>
</div>
</div>
<div class="col-span-4 flex items-center gap-2 text-xs text-on-surface-variant font-medium truncate">
<span class="material-symbols-outlined text-[16px] text-primary" data-icon="location_on">location_on</span>
                        Plaça de Santa Eulàlia, 1
                    </div>
<div class="col-span-2">
<span class="text-[9px] font-black text-primary uppercase tracking-widest bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/10">HISTÒRIA</span>
</div>
<div class="col-span-2 flex justify-end gap-1">
<button class="w-9 h-9 flex items-center justify-center hover:bg-primary/10 text-primary rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="edit">edit</span>
</button>
<button class="w-9 h-9 flex items-center justify-center hover:bg-error/10 text-error rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="delete">delete</span>
</button>
</div>
</div>
<!-- Item 5 -->
<div class="grid grid-cols-12 gap-4 items-center bg-surface-container-lowest px-8 py-4 rounded-3xl shadow-sm border border-white hover:border-primary/20 transition-all group">
<div class="col-span-4 flex items-center gap-4">
<div class="w-10 h-10 rounded-xl bg-on-secondary flex items-center justify-center text-secondary shrink-0">
<span class="material-symbols-outlined text-xl" data-icon="shopping_basket" style="font-variation-settings: 'FILL' 1;">shopping_basket</span>
</div>
<div class="truncate">
<h4 class="font-black text-sm text-on-surface truncate">Mercat de Bellvitge</h4>
<span class="text-[10px] font-bold text-on-surface-variant opacity-60">Afegit fa 1 mes</span>
</div>
</div>
<div class="col-span-4 flex items-center gap-2 text-xs text-on-surface-variant font-medium truncate">
<span class="material-symbols-outlined text-[16px] text-primary" data-icon="location_on">location_on</span>
                        Avinguda d'Amèrica, 25
                    </div>
<div class="col-span-2">
<span class="text-[9px] font-black text-primary uppercase tracking-widest bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/10">COMERÇ</span>
</div>
<div class="col-span-2 flex justify-end gap-1">
<button class="w-9 h-9 flex items-center justify-center hover:bg-primary/10 text-primary rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="edit">edit</span>
</button>
<button class="w-9 h-9 flex items-center justify-center hover:bg-error/10 text-error rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="delete">delete</span>
</button>
</div>
</div>
<!-- Item 6 -->
<div class="grid grid-cols-12 gap-4 items-center bg-surface-container-lowest px-8 py-4 rounded-3xl shadow-sm border border-white hover:border-primary/20 transition-all group">
<div class="col-span-4 flex items-center gap-4">
<div class="w-10 h-10 rounded-xl bg-tertiary-fixed-dim/30 flex items-center justify-center text-tertiary-dim shrink-0">
<span class="material-symbols-outlined text-xl" data-icon="theater_comedy" style="font-variation-settings: 'FILL' 1;">theater_comedy</span>
</div>
<div class="truncate">
<h4 class="font-black text-sm text-on-surface truncate">Teatre Joventut</h4>
<span class="text-[10px] font-bold text-on-surface-variant opacity-60">Afegit fa 2 mesos</span>
</div>
</div>
<div class="col-span-4 flex items-center gap-2 text-xs text-on-surface-variant font-medium truncate">
<span class="material-symbols-outlined text-[16px] text-primary" data-icon="location_on">location_on</span>
                        Carrer de la Joventut, 10
                    </div>
<div class="col-span-2">
<span class="text-[9px] font-black text-primary uppercase tracking-widest bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/10">CULTURA</span>
</div>
<div class="col-span-2 flex justify-end gap-1">
<button class="w-9 h-9 flex items-center justify-center hover:bg-primary/10 text-primary rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="edit">edit</span>
</button>
<button class="w-9 h-9 flex items-center justify-center hover:bg-error/10 text-error rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="delete">delete</span>
</button>
</div>
</div>
<!-- Item 7 -->
<div class="grid grid-cols-12 gap-4 items-center bg-surface-container-lowest px-8 py-4 rounded-3xl shadow-sm border border-white hover:border-primary/20 transition-all group">
<div class="col-span-4 flex items-center gap-4">
<div class="w-10 h-10 rounded-xl bg-primary-container/20 flex items-center justify-center text-primary-dim shrink-0">
<span class="material-symbols-outlined text-xl" data-icon="fitness_center" style="font-variation-settings: 'FILL' 1;">fitness_center</span>
</div>
<div class="truncate">
<h4 class="font-black text-sm text-on-surface truncate">Poliesportiu Municipal</h4>
<span class="text-[10px] font-bold text-on-surface-variant opacity-60">Afegit fa 2 mesos</span>
</div>
</div>
<div class="col-span-4 flex items-center gap-2 text-xs text-on-surface-variant font-medium truncate">
<span class="material-symbols-outlined text-[16px] text-primary" data-icon="location_on">location_on</span>
                        Carrer de l'Esport, 5
                    </div>
<div class="col-span-2">
<span class="text-[9px] font-black text-primary uppercase tracking-widest bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/10">ESPORT</span>
</div>
<div class="col-span-2 flex justify-end gap-1">
<button class="w-9 h-9 flex items-center justify-center hover:bg-primary/10 text-primary rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="edit">edit</span>
</button>
<button class="w-9 h-9 flex items-center justify-center hover:bg-error/10 text-error rounded-xl transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="delete">delete</span>
</button>
</div>
</div>
</div>
</div>
<!-- Spacer for bottom padding -->
<!-- Pagination Component -->
<div class="flex justify-end items-center gap-2 mt-4 px-2">
<button class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest border border-white text-on-surface-variant hover:bg-primary hover:text-on-primary hover:border-primary transition-all shadow-sm active:scale-90 disabled:opacity-50 disabled:pointer-events-none">
<span class="material-symbols-outlined text-xl">chevron_left</span>
</button>
<div class="flex items-center gap-2">
<button class="w-10 h-10 flex items-center justify-center rounded-xl bg-primary text-on-primary font-black text-xs shadow-lg shadow-primary/20 transition-all">1</button>
<button class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest border border-white text-on-surface-variant font-black text-xs hover:bg-surface-container-highest transition-all shadow-sm active:scale-90">2</button>
<button class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest border border-white text-on-surface-variant font-black text-xs hover:bg-surface-container-highest transition-all shadow-sm active:scale-90">3</button>
<span class="text-on-surface-variant font-black px-1 text-xs">...</span>
<button class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest border border-white text-on-surface-variant font-black text-xs hover:bg-surface-container-highest transition-all shadow-sm active:scale-90">10</button>
</div>
<button class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest border border-white text-on-surface-variant hover:bg-primary hover:text-on-primary hover:border-primary transition-all shadow-sm active:scale-90">
<span class="material-symbols-outlined text-xl">chevron_right</span>
</button>
</div><div class="h-12 shrink-0"></div>
</div>
</main>
</body></html>