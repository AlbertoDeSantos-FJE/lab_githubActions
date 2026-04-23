<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use App\Models\Gymkhana;
use App\Models\GymkhanaPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('places', $filename, 'public');
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
            'image' => 'nullable|image|max:2048',
            'remove_image' => 'nullable'
        ]);

        if ($request->input('remove_image') == '1') {
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('places', $filename, 'public');
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
            $file = $request->file('icon_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('category-icons', $filename, 'public');
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
            $file = $request->file('icon_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('category-icons', $filename, 'public');
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


    // ── Gymkhana Management ───────────────────────────────────────────────

    public function manageGymkhanas()
    {
        $gymkhanas = Gymkhana::withCount('points')
                             ->with('groupProgresses')
                             ->orderBy('created_at', 'desc')
                             ->get();
                             
        // Global Stats calculation
        $globals = [
            'totalRutes' => $gymkhanas->count(),
            'usersToday' => 0,
            'avgGlobalTime' => '-',
            'avgRating' => '-',
        ];

        $completedToday = \App\Models\GroupProgress::whereDate('completed_at', \Carbon\Carbon::today())->with('group.users')->get();
        foreach ($completedToday as $cp) {
            if ($cp->group && $cp->group->users) {
                $globals['usersToday'] += $cp->group->users->count();
            }
        }

        $allCompleted = \App\Models\GroupProgress::whereNotNull('completed_at')->get();
        if ($allCompleted->count() > 0) {
            $totalMins = 0;
            foreach ($allCompleted as $ac) {
                $totalMins += $ac->created_at->diffInMinutes($ac->completed_at);
            }
            $avgMins = round($totalMins / $allCompleted->count());
            if ($avgMins >= 60) {
                $h = floor($avgMins / 60);
                $m = $avgMins % 60;
                $globals['avgGlobalTime'] = "{$h}h {$m}m";
            } else {
                $globals['avgGlobalTime'] = "{$avgMins}m";
            }
        }

        $avgRatingDB = \App\Models\GroupProgress::whereNotNull('rating')->avg('rating');
        if ($avgRatingDB) {
            $globals['avgRating'] = number_format($avgRatingDB, 1);
        }

        foreach ($gymkhanas as $gym) {
            $completed = collect($gym->groupProgresses)->filter(function($p) {
                return !is_null($p->completed_at);
            });

            if ($completed->count() > 0) {
                $totalMinutes = 0;
                foreach ($completed as $p) {
                    $totalMinutes += $p->created_at->diffInMinutes($p->completed_at);
                }
                $avg = round($totalMinutes / $completed->count());
                
                if ($avg >= 60) {
                    $h = floor($avg / 60);
                    $m = $avg % 60;
                    $gym->real_duration = "{$h}h {$m}m";
                } else {
                    $gym->real_duration = "{$avg} min";
                }
            } else {
                $gym->real_duration = null;
            }
        }
                             
        return view('admin.gymkhanas', compact('gymkhanas', 'globals'));
    }

    public function createGymkhana()
    {
        $places = Place::with('category')->whereHas('category', function($q) {
            $q->where('active', true);
        })->get();

        return view('admin.gymkhana-create', compact('places'));
    }

    public function storeGymkhana(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_members' => 'required|integer|min:2|max:50',
            'image'       => 'nullable|image|max:5120',
            'points'      => 'required|array|min:1',
            'points.*.place_id'        => 'required|exists:places,id',
            'points.*.question'        => 'required|string',
            'points.*.answer_options'  => 'required|array|size:4',
            'points.*.answer_options.*'=> 'required|string',
            'points.*.correct_index'   => 'required|integer|min:0|max:3',
            'points.*.next_clue'       => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gymkhanas', 'public');
        }

        $gymkhana = Gymkhana::create([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'min_members' => $validated['min_members'],
            'image'       => $imagePath,
        ]);

        $lastIndex = count($validated['points']) - 1;
        foreach ($validated['points'] as $index => $point) {
            $options       = $point['answer_options'];
            $correctIndex  = (int) $point['correct_index'];
            $correctAnswer = $options[$correctIndex] ?? $options[0];

            GymkhanaPoint::create([
                'gymkhana_id'    => $gymkhana->id,
                'place_id'       => $point['place_id'],
                'order'          => $index + 1,
                'question'       => $point['question'],
                'expected_answer'=> $correctAnswer,
                'answer_options' => $options,
                'next_clue'      => ($index < $lastIndex) ? ($point['next_clue'] ?? null) : null,
            ]);
        }

        return response()->json(['success' => true, 'gymkhana' => $gymkhana]);
    }

    public function editGymkhana($id)
    {
        $gymkhana = Gymkhana::with(['points.place.category'])->findOrFail($id);
        $places = Place::with('category')->whereHas('category', function($q) {
            $q->where('active', true);
        })->get();

        return view('admin.gymkhana-create', compact('places', 'gymkhana'));
    }

    public function updateGymkhana(Request $request, $id)
    {
        $gymkhana = Gymkhana::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_members' => 'required|integer|min:2|max:50',
            'image'       => 'nullable|image|max:5120',
            'points'      => 'required|array|min:1',
            'points.*.place_id'        => 'required|exists:places,id',
            'points.*.question'        => 'required|string',
            'points.*.answer_options'  => 'required|array|size:4',
            'points.*.answer_options.*'=> 'required|string',
            'points.*.correct_index'   => 'required|integer|min:0|max:3',
            'points.*.next_clue'       => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($gymkhana->image) {
                Storage::disk('public')->delete($gymkhana->image);
            }
            $gymkhana->image = $request->file('image')->store('gymkhanas', 'public');
        }

        $gymkhana->update([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'min_members' => $validated['min_members'],
        ]);

        // Recreate points
        $gymkhana->points()->delete();
        
        $lastIndex = count($validated['points']) - 1;
        foreach ($validated['points'] as $index => $point) {
            $options       = $point['answer_options'];
            $correctIndex  = (int) $point['correct_index'];
            $correctAnswer = $options[$correctIndex] ?? $options[0];

            GymkhanaPoint::create([
                'gymkhana_id'    => $gymkhana->id,
                'place_id'       => $point['place_id'],
                'order'          => $index + 1,
                'question'       => $point['question'],
                'expected_answer'=> $correctAnswer,
                'answer_options' => $options,
                'next_clue'      => ($index < $lastIndex) ? ($point['next_clue'] ?? null) : null,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function destroyGymkhana($id)
    {
        $gymkhana = Gymkhana::findOrFail($id);
        if ($gymkhana->image) {
            Storage::disk('public')->delete($gymkhana->image);
        }
        $gymkhana->delete();
        
        return response()->json(['success' => true]);
    }

    public function toggleGymkhanaStatus($id)
    {
        $gymkhana = Gymkhana::findOrFail($id);
        $gymkhana->active = !$gymkhana->active;
        $gymkhana->save();
        return response()->json(['success' => true, 'active' => $gymkhana->active]);
    }

    // ── User Management ───────────────────────────────────────────────────

    public function manageUsers(Request $request)
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role');

        $query = \App\Models\User::withCount('groups');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($roleFilter && in_array($roleFilter, ['admin', 'user'])) {
            $query->where('role', $roleFilter);
        }

        $users = $query->latest()->paginate(7)->appends([
            'search' => $search,
            'role'   => $roleFilter,
        ]);

        // Stats for header cards
        $totalUsers = \App\Models\User::count();

        // Active groups: groups that have at least one ongoing (non-completed) gymkhana progress
        $activeGroupIds = \App\Models\GroupProgress::whereNull('completed_at')
                            ->distinct()
                            ->pluck('group_id');
        $activeGroups = \App\Models\Group::whereIn('id', $activeGroupIds)
                            ->with('users')
                            ->get();
        $totalGroups = $activeGroups->count();

        // Active gymkhanas: gymkhanas currently being played (have non-completed progress)
        $activeGymkhanaIds = \App\Models\GroupProgress::whereNull('completed_at')
                                ->distinct()
                                ->pluck('gymkhana_id');
        $activeGymkhanas = \App\Models\Gymkhana::whereIn('id', $activeGymkhanaIds)->get();
        $totalGymkhanas = $activeGymkhanas->count();

        if ($request->ajax()) {
            return view('admin.partials.users-list', compact('users', 'search', 'roleFilter'))->render();
        }

        return view('admin.users', compact('users', 'search', 'roleFilter', 'totalUsers', 'totalGroups', 'totalGymkhanas', 'activeGroups', 'activeGymkhanas'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,user',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = \App\Models\User::create($validated);

        return response()->json(['success' => true, 'user' => $user]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'role'     => 'required|in:admin,user',
            'password' => 'nullable|string|min:8',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json(['success' => true, 'user' => $user]);
    }

    public function destroyUser($id)
    {
        // Prevent self-deletion
        if (auth()->id() == $id) {
            return response()->json(['success' => false, 'message' => 'No pots eliminar el teu propi compte.'], 403);
        }

        $user = \App\Models\User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true]);
    }

    // ── Real-time stats for User Management ──────────────────────────────

    /**
     * Returns groups currently playing a gymkhana (non-completed progress).
     */
    public function getActiveGroups()
    {
        $activeGroupIds = \App\Models\GroupProgress::whereNull('completed_at')
                            ->distinct()
                            ->pluck('group_id');

        $groups = \App\Models\Group::whereIn('id', $activeGroupIds)
                    ->with(['users', 'progresses' => function ($q) {
                        $q->whereNull('completed_at')->with('gymkhana');
                    }])
                    ->get()
                    ->map(function ($group) {
                        $progress = $group->progresses->first();
                        return [
                            'id'            => $group->id,
                            'name'          => $group->name,
                            'members'       => $group->users->count(),
                            'gymkhana_name' => $progress?->gymkhana?->name ?? '-',
                        ];
                    });

        return response()->json([
            'count'  => $groups->count(),
            'groups' => $groups,
        ]);
    }

    /**
     * Returns gymkhanas currently being played (non-completed progress exists).
     */
    public function getActiveGymkhanas()
    {
        $activeGymkhanaIds = \App\Models\GroupProgress::whereNull('completed_at')
                                ->distinct()
                                ->pluck('gymkhana_id');

        $gymkhanas = \App\Models\Gymkhana::whereIn('id', $activeGymkhanaIds)
                        ->withCount(['groupProgresses as active_groups_count' => function ($q) {
                            $q->whereNull('completed_at');
                        }])
                        ->get()
                        ->map(function ($gym) {
                            return [
                                'id'                 => $gym->id,
                                'name'               => $gym->name,
                                'active_groups_count' => $gym->active_groups_count,
                            ];
                        });

        return response()->json([
            'count'      => $gymkhanas->count(),
            'gymkhanas'  => $gymkhanas,
        ]);
    }
}
