<?php
$stitchHtml = file_get_contents('resources/views/admin/dashboard_stitch.blade.php');
$originalBlade = file_get_contents('resources/views/admin/dashboard.blade.php');

// Extract Script from old blade
$scriptStart = strpos($originalBlade, '<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"');
$scriptTag = substr($originalBlade, $scriptStart);
$scriptTag = str_replace('@endsection', '', $scriptTag); // Remove blade layout tag

// 1. Add Leaflet CSS & CSRF
$stitchHtml = str_replace('</head>', "  <link rel=\"stylesheet\" href=\"https://unpkg.com/leaflet@1.9.4/dist/leaflet.css\"/>\n  <meta name=\"csrf-token\" content=\"{{ csrf_token() }}\">\n</head>", $stitchHtml);

// 2. Map Div
$mapRegex = '/<div class="absolute inset-0 z-0">.*?<\/div>\s*<div class="absolute top-6 left-6/s';
$stitchHtml = preg_replace($mapRegex, '<div id="main-map" class="absolute inset-0 z-0"></div><div class="absolute top-6 left-6', $stitchHtml);

// 3. Remove static markers
$stitchHtml = preg_replace('/<div class="absolute top-[^>]+z-10 group\/marker cursor-pointer">.*?<\/div>\s*<\/div>/s', '', $stitchHtml);

// 4. Form inputs IDs
$stitchHtml = str_replace('placeholder="Ex: Restaurant L\'H" type="text"/>', 'id="place_name" placeholder="Ex: Restaurant L\'H" type="text"/>', $stitchHtml);
$stitchHtml = str_replace('placeholder="Carrer de l\'Hospitalet, 42" type="text"/>', 'id="place_address" placeholder="Carrer de l\'Hospitalet, 42" type="text"/>', $stitchHtml);

$stitchHtml = str_replace('<span class="material-symbols-outlined absolute right-4 top-2.5 text-outline text-xl" data-icon="map">map</span>', 
'<button type="button" id="btn-search-coords" class="absolute right-4 top-2.5 text-primary text-xl hover:scale-110 transition-all"><span class="material-symbols-outlined" data-icon="search">search</span></button>', $stitchHtml);

$stitchHtml = str_replace('placeholder="41.3597" type="text"/>', 'id="place_lat" readonly placeholder="41.3597" type="text"/>', $stitchHtml);
$stitchHtml = str_replace('placeholder="2.1003" type="text"/>', 'id="place_lng" readonly placeholder="2.1003" type="text"/>', $stitchHtml);

// 5. Categories Checkboxes
$stitchHtml = preg_replace('/<div class="bg-surface-container-low border border-surface-container-highest\/20 rounded-2xl p-4 max-h-\[160px\] overflow-y-auto space-y-2">.*?<\/div>\s*<\/div>\s*<\/div>/s',
'<div id="place-categories" class="bg-surface-container-low border border-surface-container-highest/20 rounded-2xl p-4 max-h-[160px] overflow-y-auto space-y-2"></div></div></div>', $stitchHtml);

// 6. Save Button
$stitchHtml = str_replace('<button class="w-full bg-primary', '<button id="btn-save-place" type="button" class="w-full bg-primary', $stitchHtml);

// 7. Filter Dropdown
$stitchHtml = preg_replace('/<div class="absolute right-0 top-full mt-2 w-full bg-white rounded-2xl shadow-xl border border-outline-variant\/10 hidden group-hover:block overflow-hidden z-20">.*?<\/div>\s*<\/div>/s',
'<div id="filter-dropdown" class="absolute right-0 top-full mt-2 w-full bg-white rounded-2xl shadow-xl border border-outline-variant/10 hidden group-hover:block overflow-hidden z-20"><a class="block px-4 py-3 text-xs font-bold hover:bg-[#f7edff] text-on-surface" href="#" onclick="window.filterCategory(null); return false;">Totes</a></div></div>', $stitchHtml);

// 8. Places List Container
$stitchHtml = preg_replace('/<!-- List of Items \(Extended\) -->.*?<!-- Spacer for bottom padding -->/s',
'<!-- List of Items (Extended) --><div id="places-list" class="flex flex-col gap-3"></div><!-- Spacer for bottom padding -->', $stitchHtml);

// 9. Logout POST
$stitchHtml = preg_replace('/<button[^>]+>\s*<span[^>]+data-icon="logout".*?<\/button>/s',
'<form method="POST" action="{{ route(\'logout\') }}" class="inline">@csrf<button type="submit" class="p-2.5 text-[#5d3fd3] hover:bg-[#5d3fd3]/10 transition-colors rounded-2xl active:opacity-80 active:scale-95 transition-all"><span class="material-symbols-outlined" data-icon="logout">logout</span></button></form>', $stitchHtml);

// 10. Inject JS at the end
$stitchHtml = str_replace('</body>', $scriptTag . "\n</body>", $stitchHtml);

file_put_contents('resources/views/admin/dashboard.blade.php', $stitchHtml);
echo "Surgery successful.\n";
