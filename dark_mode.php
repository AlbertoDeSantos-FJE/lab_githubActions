<?php
$files = [
    'resources/views/admin/dashboard.blade.php',
    'resources/views/admin/categories.blade.php',
    'resources/views/admin/gymkhanas.blade.php',
    'resources/views/welcome.blade.php',
    'resources/views/auth/login.blade.php'
];

$script = <<<JS
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
</body>
JS;

foreach ($files as $file) {
    if (file_exists($file)) {
        $html = file_get_contents($file);
        // Only insert if not already there
        if (strpos($html, 'toggleSpans') === false) {
            $html = str_replace('</body>', $script, $html);
            file_put_contents($file, $html);
        }
    }
}
echo "Dark mode injected.";
