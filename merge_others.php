<?php
$files = [
    'resources/views/admin/categories.blade.php' => 'stitch_downloads/010ad02fe2014dfabc384b4e6a21fa0f.html',
    'resources/views/admin/gymkhanas.blade.php' => 'stitch_downloads/74b968c262054607b76ffa250f0b4535.html'
];
foreach($files as $target => $source) {
    if(file_exists($source)) {
        $html = file_get_contents($source);
        $html = preg_replace('/<button[^>]+>\s*<span[^>]+data-icon="logout".*?<\/button>/s',
            '<form method="POST" action="{{ route(\'logout\') }}" class="inline">@csrf<button type="submit" class="p-2.5 text-[#5d3fd3] hover:bg-[#5d3fd3]/10 transition-colors rounded-2xl active:opacity-80 active:scale-95 transition-all"><span class="material-symbols-outlined" data-icon="logout">logout</span></button></form>', $html);
        file_put_contents($target, $html);
    }
}
echo "Copied Categories and Gymkhanes templates.\n";
