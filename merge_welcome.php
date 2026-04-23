<?php
$benvinguda = file_get_contents('stitch_downloads/benvinguda.html');

// Replace form
$formStart = strpos($benvinguda, '<form');
$formEnd = strpos($benvinguda, '</form>') + 7;
$formHtml = <<<HTML
<form method="POST" action="{{ route('login') }}" class="px-4 pb-6 space-y-5">
    @csrf
    <div class="space-y-1.5">
        <label class="block text-xs font-bold uppercase tracking-widest text-on-surface-variant px-1" for="email">Correu electrònic</label>
        <div class="relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg" data-icon="mail">mail</span>
            <input name="email" required class="w-full pl-12 pr-4 py-3.5 bg-surface-container-highest border-none rounded-xl text-on-surface placeholder:text-outline/60 focus:ring-2 focus:ring-primary/40 focus:bg-surface-container-lowest transition-all" id="email" placeholder="nom@exemple.com" type="email"/>
        </div>
        @error('email')<p class="text-red-500 text-xs mt-1">{{ \$message }}</p>@enderror
    </div>
    <div class="space-y-1.5">
        <div class="flex justify-between items-center px-1">
            <label class="block text-xs font-bold uppercase tracking-widest text-on-surface-variant" for="password">Contrasenya</label>
            <a class="text-xs font-semibold text-primary hover:underline" href="#">Recuperar contrasenya</a>
        </div>
        <div class="relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg" data-icon="lock">lock</span>
            <input name="password" required class="w-full pl-12 pr-4 py-3.5 bg-surface-container-highest border-none rounded-xl text-on-surface placeholder:text-outline/60 focus:ring-2 focus:ring-primary/40 focus:bg-surface-container-lowest transition-all" id="password" placeholder="••••••••" type="password"/>
        </div>
        @error('password')<p class="text-red-500 text-xs mt-1">{{ \$message }}</p>@enderror
    </div>
    <button class="w-full bg-primary text-on-primary py-4 rounded-full font-bold text-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all" type="submit">
        Entrar a l'Hospitalet
    </button>
</form>
HTML;

$newHtml = substr_replace($benvinguda, $formHtml, $formStart, $formEnd - $formStart);
file_put_contents('resources/views/welcome.blade.php', $newHtml);
file_put_contents('resources/views/auth/login.blade.php', $newHtml);
echo "Welcome and Login merged.\n";
