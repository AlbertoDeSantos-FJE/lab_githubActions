<!DOCTYPE html>

<html class="light" lang="ca"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Gestió de Gimcanes - Admin Panel</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "on-surface-variant": "#64547e",
              "tertiary-dim": "#a30021",
              "primary-fixed-dim": "#9680ff",
              "surface": "#fcf4ff",
              "secondary-fixed-dim": "#efc900",
              "on-primary-fixed-variant": "#2c008f",
              "tertiary": "#b71029",
              "inverse-surface": "#14052b",
              "inverse-primary": "#937dff",
              "surface-container-lowest": "#ffffff",
              "secondary-dim": "#5e4e00",
              "surface-container-low": "#f7edff",
              "secondary-fixed": "#ffd709",
              "on-secondary": "#fff2cd",
              "on-secondary-fixed-variant": "#665500",
              "on-background": "#36274e",
              "outline-variant": "#b7a5d4",
              "primary-dim": "#5130c6",
              "primary-container": "#a391ff",
              "on-tertiary": "#ffefee",
              "error-container": "#f74b6d",
              "secondary-container": "#ffd709",
              "on-surface": "#36274e",
              "on-tertiary-fixed": "#3a0006",
              "on-primary": "#f6f0ff",
              "outline": "#806f9b",
              "background": "#fcf4ff",
              "surface-dim": "#e0cbff",
              "on-tertiary-fixed-variant": "#790016",
              "on-secondary-container": "#5b4b00",
              "surface-variant": "#e7d6ff",
              "surface-container-high": "#ecdcff",
              "surface-bright": "#fcf4ff",
              "secondary": "#6c5a00",
              "on-primary-fixed": "#000000",
              "on-primary-container": "#230076",
              "surface-container": "#f0e3ff",
              "on-secondary-fixed": "#453900",
              "error": "#b41340",
              "surface-container-highest": "#e7d6ff",
              "on-error-container": "#510017",
              "tertiary-fixed-dim": "#ff7a7b",
              "on-error": "#ffefef",
              "on-tertiary-container": "#680011",
              "tertiary-container": "#ff9190",
              "surface-tint": "#5d3fd3",
              "inverse-on-surface": "#a795c3",
              "tertiary-fixed": "#ff9190",
              "primary": "#5d3fd3",
              "primary-fixed": "#a391ff",
              "error-dim": "#a70138"
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
            vertical-align: middle;
        }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen flex overflow-hidden">
<!-- SideNavBar -->
<aside class="h-screen w-64 border-r-0 bg-violet-50 dark:bg-slate-950 flex flex-col h-full py-6 px-4 shrink-0">
<div class="mb-10 px-2 flex items-center gap-3">
<div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-on-primary">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">location_city</span>
</div>
<div>
<h1 class="text-xl font-bold text-[#5D3FD3] tracking-tight">Guia de l'Hospitalet</h1>
<p class="font-['Plus_Jakarta_Sans'] text-xs font-semibold text-slate-500 uppercase tracking-widest">Admin Panel</p>
</div>
</div>
<nav class="flex-1 space-y-2">
<a class="flex items-center gap-3 px-4 py-3 text-slate-600 dark:text-slate-400 hover:text-[#5D3FD3] hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-colors font-['Plus_Jakarta_Sans'] text-sm font-semibold" href="#">
<span class="material-symbols-outlined">location_on</span>
<span>Llocs</span>
</a>
<!-- ACTIVE TAB: Gimcanes -->
<a class="flex items-center gap-3 px-4 py-3 dark:bg-violet-900/30 font-bold rounded-xl transition-all font-['Plus_Jakarta_Sans'] text-sm text-primary bg-primary/10" href="#">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">explore</span>
<span>Gimcanes</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-600 dark:text-slate-400 hover:text-[#5D3FD3] hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-colors font-['Plus_Jakarta_Sans'] text-sm font-semibold" href="#">
<span class="material-symbols-outlined">category</span>
<span>Categories</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-600 dark:text-slate-400 hover:text-[#5D3FD3] hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-colors font-['Plus_Jakarta_Sans'] text-sm font-semibold" href="#">
<span class="material-symbols-outlined">group</span>
<span>Usuaris</span>
</a>
</nav>
<div class="mt-auto p-4 bg-violet-100 dark:bg-violet-900/30 rounded-2xl flex items-center gap-3">
<img alt="User profile avatar" class="w-10 h-10 rounded-full border-2 border-primary-container" data-alt="Admin user profile avatar thumbnail" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAAK6UzqLQVIwuIUBlIBfsb4Ywqm8ndM_rLpGTApvyjxib5UAeaW5-fOqmjnCtqmM6NwQ-4qES3RWbBwcCYxL9nyupJEynTU68jV5ZgAd8PMa52otdmrAyJd1w3PPHb25K4E3aB0Gm5oH5xygFEsFA3rW3MfyDQGy03WpypNa-N89XOw5GJAIVP0BwciIPN3uiB8E185NW-6F6MCjU-ASBy6FPfN7_zQYfToaYL-u0cMp2oyg9T5ni_jeFv2PkybxV51HgB4vi_mbg"/>
<div class="overflow-hidden">
<p class="text-xs font-bold truncate text-[#5D3FD3]">Admin Central</p>
<p class="text-[10px] text-on-surface-variant truncate">admin@lhospitalet.cat</p>
</div>
</div>
</aside>
<main class="flex-1 flex flex-col min-w-0 overflow-hidden relative">
<!-- TopNavBar - Unified Style -->
<header class="flex justify-between items-center w-full px-8 py-4 sticky top-0 z-50 bg-white dark:bg-slate-900 border-b border-violet-100 dark:border-violet-900/20">
<h2 class="font-['Plus_Jakarta_Sans'] text-lg font-bold text-[#5D3FD3]">Gestió de Gimcanes</h2>
<div class="flex items-center gap-4">
<div class="flex items-center gap-2 px-3 py-1.5 bg-violet-100 dark:bg-violet-900/30 rounded-full cursor-pointer active:scale-95 duration-200 text-[#5D3FD3]">
<span class="material-symbols-outlined text-sm">language</span>
<span class="text-xs font-bold">CA</span>
</div>
<button class="bg-violet-100 dark:bg-violet-900/30 hover:bg-violet-200 dark:hover:bg-violet-900/50 rounded-full p-2 cursor-pointer active:scale-95 duration-200 text-[#5D3FD3]">
<span class="material-symbols-outlined">dark_mode</span>
</button>
<button class="bg-violet-100 dark:bg-violet-900/30 hover:bg-violet-200 dark:hover:bg-violet-900/50 rounded-full p-2 cursor-pointer active:scale-95 duration-200 text-[#5D3FD3]">
<span class="material-symbols-outlined">logout</span>
</button>
<div class="ml-2 w-10 h-10 rounded-full border-2 border-[#5D3FD3]/20 overflow-hidden">
<img alt="Admin profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAAK6UzqLQVIwuIUBlIBfsb4Ywqm8ndM_rLpGTApvyjxib5UAeaW5-fOqmjnCtqmM6NwQ-4qES3RWbBwcCYxL9nyupJEynTU68jV5ZgAd8PMa52otdmrAyJd1w3PPHb25K4E3aB0Gm5oH5xygFEsFA3rW3MfyDQGy03WpypNa-N89XOw5GJAIVP0BwciIPN3uiB8E185NW-6F6MCjU-ASBy6FPfN7_zQYfToaYL-u0cMp2oyg9T5ni_jeFv2PkybxV51HgB4vi_mbg"/>
</div>
</div>
</header>
<!-- Main Content Area -->
<div class="flex-1 overflow-y-auto p-8 bg-surface">
<!-- Hero / Header Section -->
<div class="flex justify-between items-end mb-10">
<div class="space-y-2">
<span class="text-primary font-bold tracking-widest text-xs uppercase">Exploració Urbana</span>
<h3 class="text-4xl font-extrabold tracking-tight text-on-background">Gimcanes Actives</h3>
</div>
<button class="bg-primary text-on-primary px-6 py-3 rounded-full font-bold flex items-center gap-2 shadow-lg shadow-primary/20 hover:scale-105 transition-transform active:scale-95">
<span class="material-symbols-outlined">add</span>
                    Nova Gimcana
                </button>
</div>
<!-- Bento-style Data Stats -->
<div class="grid grid-cols-4 gap-6 mb-10">
<div class="bg-surface-container-low p-6 rounded-3xl border border-transparent hover:border-primary/10 transition-colors">
<p class="text-on-surface-variant text-sm font-medium mb-1">Total Rutes</p>
<p class="text-3xl font-extrabold text-[#5D3FD3]">24</p>
</div>
<div class="bg-surface-container-low p-6 rounded-3xl border border-transparent hover:border-primary/10 transition-colors">
<p class="text-on-surface-variant text-sm font-medium mb-1">Participants Avui</p>
<p class="text-3xl font-extrabold text-[#5D3FD3]">142</p>
</div>
<div class="bg-surface-container-low p-6 rounded-3xl border border-transparent hover:border-primary/10 transition-colors">
<p class="text-on-surface-variant text-sm font-medium mb-1">Temps Mitjà</p>
<p class="text-3xl font-extrabold text-[#5D3FD3]">45m</p>
</div>
<div class="bg-surface-container-low p-6 rounded-3xl border border-transparent hover:border-primary/10 transition-colors">
<p class="text-on-surface-variant text-sm font-medium mb-1">Valoració Mitjana</p>
<div class="flex items-center gap-1">
<p class="text-3xl font-extrabold text-[#5D3FD3]">4.8</p>
<span class="material-symbols-outlined text-secondary text-xl" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
</div>
</div>
<!-- Table Container -->
<div class="bg-surface-container-lowest rounded-3xl shadow-sm overflow-hidden">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low/50">
<th class="px-8 py-5 text-sm font-bold text-on-surface-variant uppercase tracking-wider">Scavenger Hunt Name</th>
<th class="px-8 py-5 text-sm font-bold text-on-surface-variant uppercase tracking-wider">Number of Stages</th>
<th class="px-8 py-5 text-sm font-bold text-on-surface-variant uppercase tracking-wider">Average Duration</th>
<th class="px-8 py-5 text-sm font-bold text-on-surface-variant uppercase tracking-wider text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container-low">
<tr class="hover:bg-violet-50/30 transition-colors group">
<td class="px-8 py-6">
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-2xl bg-primary-container/20 flex items-center justify-center text-primary overflow-hidden">
<img alt="Icona Gimcana" class="w-full h-full object-cover" data-alt="Aerial view of city street for scavenger hunt icon" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAj-VhJgDXb2ozghp4SAG4o40fjVvYMuL1QxsyWko2-HZbSIq4MN9SrX_Px1eoUONgfxu1Oa1i_JDPquPf4jDW76c9VnWZ8dbZ6BO53ZC4wsdvEloddgjXsW9ca-iL5mZTPnDbKqw7gbAd_Tc3MN83FYpN3ywxNjthcNIo6umWD-wIHjHUkGi-mK_34Z2_wS0fDz3iVTAJI7zTgsn0jxOJ1NB2e1CTXwtUM9Ob44tLJi2EMjMiJXj4n5BIQNQMHfmygY9wsaaF1Eyw"/>
</div>
<div>
<p class="font-bold text-on-surface group-hover:text-primary transition-colors">Misteris de Bellvitge</p>
<p class="text-xs text-on-surface-variant">Arquitectura Moderna</p>
</div>
</div>
</td>
<td class="px-8 py-6">
<span class="px-3 py-1 bg-surface-container-high rounded-full text-xs font-bold text-on-surface">8 Etapes</span>
</td>
<td class="px-8 py-6">
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-sm">schedule</span>
<span class="text-sm font-medium">55 min</span>
</div>
</td>
<td class="px-8 py-6 text-right">
<div class="flex justify-end gap-2">
<button class="w-10 h-10 rounded-full flex items-center justify-center text-primary hover:bg-primary/10 transition-colors">
<span class="material-symbols-outlined">edit</span>
</button>
<button class="w-10 h-10 rounded-full flex items-center justify-center text-error hover:bg-error/10 transition-colors">
<span class="material-symbols-outlined">delete</span>
</button>
</div>
</td>
</tr>
<tr class="hover:bg-violet-50/30 transition-colors group">
<td class="px-8 py-6">
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-2xl bg-secondary-container/20 flex items-center justify-center text-secondary overflow-hidden">
<img alt="Icona Gimcana" class="w-full h-full object-cover" data-alt="Historic building facade for heritage tour" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCNlHmnN2vzjWauDAsyBwi0XYlcrvvkkCBPVyB9A4hX66m45fH4nlmjr9d8-YCblLA4gFVNPL-6DYUnr7I9qToJRQcSKglOFPo_9bWpbkNQJfJVy7c3AXz4zgti0u1EVtkh-4w4pslXYCAEIJQjbGBHDYvo8A2DabCNP4n1wg6L7Y4GMRJCLZrKhyv7yGq5-3KsRBNLpcG3JGty5A8Fe7oUPksaqX5CpIvplP3bqe7yWkcggjdYKjWSjwYF5oCPXD8UanCPiDNs_YM"/>
</div>
<div>
<p class="font-bold text-on-surface group-hover:text-primary transition-colors">Ruta del Patrimoni</p>
<p class="text-xs text-on-surface-variant">Història i Tradició</p>
</div>
</div>
</td>
<td class="px-8 py-6">
<span class="px-3 py-1 bg-surface-container-high rounded-full text-xs font-bold text-on-surface">12 Etapes</span>
</td>
<td class="px-8 py-6">
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-sm">schedule</span>
<span class="text-sm font-medium">1h 20m</span>
</div>
</td>
<td class="px-8 py-6 text-right">
<div class="flex justify-end gap-2">
<button class="w-10 h-10 rounded-full flex items-center justify-center text-primary hover:bg-primary/10 transition-colors">
<span class="material-symbols-outlined">edit</span>
</button>
<button class="w-10 h-10 rounded-full flex items-center justify-center text-error hover:bg-error/10 transition-colors">
<span class="material-symbols-outlined">delete</span>
</button>
</div>
</td>
</tr>
<tr class="hover:bg-violet-50/30 transition-colors group">
<td class="px-8 py-6">
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-2xl bg-tertiary-container/20 flex items-center justify-center text-tertiary overflow-hidden">
<img alt="Icona Gimcana" class="w-full h-full object-cover" data-alt="Gourmet food dish representing gastronomic scavenger hunt" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCLmUgaIzrgp9_PmYLriir6wxPH7lMEaQr-d-BcS0HNMQTOT89iXRFoNLewoDilOHJ0m4vEDfheWLfUXtVweScZZg9_g3r4V5yz6Cu3p8efdRW8B4nRplHBbRJ4imZacbE_7SEgex7MyDzFS3Q0no_nc99Xm4lXIjZSzPMHTOSfOQ9MkvLpXfC8zMmYf9Rx-gfpRnLkNWwSQ9VuTBe1CvKNKql4gMSSZcnuhWf47Q6dmdiOgUYqLEgt0wf8NdqbtwFWwSnuB0ZRP5c"/>
</div>
<div>
<p class="font-bold text-on-surface group-hover:text-primary transition-colors">Hospitalet Gastronòmic</p>
<p class="text-xs text-on-surface-variant">Tapes i Cuina de Barri</p>
</div>
</div>
</td>
<td class="px-8 py-6">
<span class="px-3 py-1 bg-surface-container-high rounded-full text-xs font-bold text-on-surface">6 Etapes</span>
</td>
<td class="px-8 py-6">
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-sm">schedule</span>
<span class="text-sm font-medium">40 min</span>
</div>
</td>
<td class="px-8 py-6 text-right">
<div class="flex justify-end gap-2">
<button class="w-10 h-10 rounded-full flex items-center justify-center text-primary hover:bg-primary/10 transition-colors">
<span class="material-symbols-outlined">edit</span>
</button>
<button class="w-10 h-10 rounded-full flex items-center justify-center text-error hover:bg-error/10 transition-colors">
<span class="material-symbols-outlined">delete</span>
</button>
</div>
</td>
</tr>
<tr class="hover:bg-violet-50/30 transition-colors group">
<td class="px-8 py-6">
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-2xl bg-primary-container/20 flex items-center justify-center text-primary overflow-hidden">
<img alt="Icona Gimcana" class="w-full h-full object-cover" data-alt="Public art sculpture for street art walk" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDQif1-lddDzRwK9MfjOf_BvpSi26mXULZGwDJgvJBTIG5NOA9xdza866P3rp6gregJKpxF4o-9F8ygPX-KftwyWuJVz8S1XXUT_kQ1Z-ywCZYstz8jYRTDWp10obrUo4lpzDyuNpa2olY6_3YCBqP0FYwhlkFEfpbxmzRQFf6YkDE0RNUnzKkMueewHId2UnIUiIW-ylTps_D_Hxv3h8ZwOkN7SzjrXpIpDswc5RPUNsRJzo_37un3CZah_0gCKQKH2MH7IUNkspM"/>
</div>
<div>
<p class="font-bold text-on-surface group-hover:text-primary transition-colors">Street Art Walk</p>
<p class="text-xs text-on-surface-variant">Cultura Urbana</p>
</div>
</div>
</td>
<td class="px-8 py-6">
<span class="px-3 py-1 bg-surface-container-high rounded-full text-xs font-bold text-on-surface">15 Etapes</span>
</td>
<td class="px-8 py-6">
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-sm">schedule</span>
<span class="text-sm font-medium">1h 45m</span>
</div>
</td>
<td class="px-8 py-6 text-right">
<div class="flex justify-end gap-2">
<button class="w-10 h-10 rounded-full flex items-center justify-center text-primary hover:bg-primary/10 transition-colors">
<span class="material-symbols-outlined">edit</span>
</button>
<button class="w-10 h-10 rounded-full flex items-center justify-center text-error hover:bg-error/10 transition-colors">
<span class="material-symbols-outlined">delete</span>
</button>
</div>
</td>
</tr>
</tbody>
</table>
<div class="p-6 bg-surface-container-low/30 flex justify-between items-center">
<p class="text-xs font-medium text-on-surface-variant">Mostrant 4 de 24 gimcanes</p>
<div class="flex gap-2">
<button class="w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-primary hover:text-on-primary transition-all text-xs font-bold">1</button>
<button class="w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-primary hover:text-on-primary transition-all text-xs font-bold">2</button>
<button class="w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-primary hover:text-on-primary transition-all text-xs font-bold">3</button>
<button class="w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-primary hover:text-on-primary transition-all">
<span class="material-symbols-outlined text-sm">chevron_right</span>
</button>
</div>
</div>
</div>
</div>
<!-- Floating Abstract Decoration -->
<div class="absolute -bottom-24 -right-24 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
<div class="absolute -top-24 -left-24 w-96 h-96 bg-secondary/5 rounded-full blur-3xl pointer-events-none"></div>
</main>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleSpans = document.querySelectorAll('span[data-icon="dark_mode"], span[data-icon="light_mode"]');
    
    toggleSpans.forEach(span => {
        const target = span.closest('button') || span;
        target.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            
            // update all icons
            toggleSpans.forEach(s => {
                s.textContent = isDark ? 'light_mode' : 'dark_mode';
                s.setAttribute('data-icon', isDark ? 'light_mode' : 'dark_mode');
            });
            
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    });
    
    // Check preference
    if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        toggleSpans.forEach(s => {
            s.textContent = 'light_mode';
            s.setAttribute('data-icon', 'light_mode');
        });
    } else {
        document.documentElement.classList.remove('dark');
    }
});
</script>
</body></html>