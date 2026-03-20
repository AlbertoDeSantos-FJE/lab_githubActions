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
        // Returns places as JSON for the AJAX map request
        $places = Place::with('category')->get();
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
            'category_id' => 'required|exists:categories,id'
        ]);

        $place = Place::create($validated);
        return response()->json(['message' => 'Place created', 'place' => $place]);
    }

    public function destroyPlace($id)
    {
        $place = Place::findOrFail($id);
        $place->delete();
        return response()->json(['message' => 'Place deleted']);
    }

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }
}
