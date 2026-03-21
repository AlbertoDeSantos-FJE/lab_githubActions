// Tailwind Configuration
if (typeof tailwind !== 'undefined') {
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
                borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
            },
        },
    };
}

// Dark Mode Initialization & Logic
document.addEventListener('DOMContentLoaded', () => {
    const html = document.documentElement;
    const themeToggle = document.getElementById('theme-toggle') || document.querySelectorAll('[id^="theme_"]');
    
    // Initial check
    if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
        if (document.getElementById('theme_dark')) document.getElementById('theme_dark').checked = true;
    } else {
        html.classList.remove('dark');
        if (document.getElementById('theme_light')) document.getElementById('theme_light').checked = true;
    }

    // Theme toggle listeners
    const lightRadio = document.getElementById('theme_light');
    const darkRadio = document.getElementById('theme_dark');

    if (lightRadio && darkRadio) {
        lightRadio.addEventListener('change', () => {
            if (lightRadio.checked) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        });
        darkRadio.addEventListener('change', () => {
            if (darkRadio.checked) {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });
    }

    // Single button toggle (for other views)
    const toggleBtn = document.getElementById('theme-toggle');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        });
    }
});
