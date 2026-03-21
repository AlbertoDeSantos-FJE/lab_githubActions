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

    public function manageCategories()
    {
        $categories = Category::withCount('places')->get();
        return view('admin.categories', compact('categories'));
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
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'color' => 'nullable|string|max:7',
        ]);

        $category = Category::create($validated);
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
