<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use App\Models\Gymkhana;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Renders the main admin dashboard view
        return view('admin.dashboard');
    }

    public function getPlaces()
    {
        // Only return places whose category is active
        $places = Place::whereHas('category', function($query) {
            $query->where('active', true);
        })->with('category')->get();
        
        return response()->json($places);
    }

    public function storePlace(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('places', 'public');
            $validated['image'] = $path;
        }

        $place = Place::create($validated);
        return response()->json(['message' => 'Place created', 'place' => $place]);
    }

    public function updatePlace(Request $request, $id)
    {
        $place = Place::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('places', 'public');
            $validated['image'] = $path;
        }

        $place->update($validated);
        return response()->json(['message' => 'Place updated', 'place' => $place]);
    }

    public function destroyPlace($id)
    {
        $place = Place::findOrFail($id);
        $place->delete();
        return response()->json(['message' => 'Place deleted']);
    }

    public function getCategories()
    {
        // For the dashboard, only show active categories
        $categories = Category::where('active', true)->get();
        return response()->json($categories);
    }

    public function manageCategories(Request $request)
    {
        $search = $request->input('search');

        $query = Category::withCount('places');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $categories = $query->paginate(7)->appends(['search' => $search]);
        
        if ($request->ajax()) {
            return view('admin.partials.categories-list', compact('categories', 'search'))->render();
        }

        return view('admin.categories', compact('categories', 'search'));
    }

    public function toggleCategoryStatus($id)
    {
        $category = Category::findOrFail($id);
        $category->active = !$category->active;
        $category->save();
        return response()->json(['success' => true, 'active' => $category->active]);
    }
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon'        => 'nullable|string',
            'color'       => 'nullable|string|max:7',
            'icon_image'  => 'nullable|mimetypes:image/jpeg,image/png,image/gif,image/webp,image/svg+xml|max:2048',
        ]);

        // If a custom icon image was uploaded, store it and use its path as the icon value
        if ($request->hasFile('icon_image')) {
            $path = $request->file('icon_image')->store('category-icons', 'public');
            $validated['icon'] = $path;
        }

        unset($validated['icon_image']); // not a DB column

        $category = Category::create($validated);
        return response()->json(['success' => true, 'category' => $category]);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon'        => 'nullable|string',
            'color'       => 'nullable|string|max:7',
            'icon_image'  => 'nullable|mimetypes:image/jpeg,image/png,image/gif,image/webp,image/svg+xml|max:2048',
        ]);

        if ($request->hasFile('icon_image')) {
            $path = $request->file('icon_image')->store('category-icons', 'public');
            $validated['icon'] = $path;
        }

        unset($validated['icon_image']);

        $category->update($validated);
        return response()->json(['success' => true, 'category' => $category]);
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        
        // Prevent deleting the fallback category
        if ($category->name === 'Sense categoria') {
            return response()->json(['success' => false, 'message' => 'No es pot eliminar la categoria per defecte.'], 403);
        }

        // Find or create fallback category
        $fallback = Category::firstOrCreate(
            ['name' => 'Sense categoria'],
            ['color' => '#64748b', 'icon' => 'help_outline', 'active' => true]
        );

        // Reassign places
        \App\Models\Place::where('category_id', $category->id)->update(['category_id' => $fallback->id]);

        $category->delete();

        return response()->json(['success' => true]);
    }
}
