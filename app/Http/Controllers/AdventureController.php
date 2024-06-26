<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdventureResource;
use App\Models\Adventure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdventureController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $adventures = Adventure::query()
            ->with(['chapters' => function ($query) use ($userId) {
                // Only load chapters if the user owns the adventure
                if ($userId) {
                    $query->whereHas('adventure', function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    });
                }
            }])
            ->where(function ($query) use ($userId) {
                $query->where('public', true);
                // Include user's own adventures
                if ($userId) {
                    $query->orWhere('user_id', $userId);
                }
            })
            ->latest()
            ->paginate(5);

        return Inertia::render('Adventures/Index', [
            'adventures' => AdventureResource::collection($adventures),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->cannot('create', Adventure::class)) {
            abort(404);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:75'],
        ]);

        $adventure = Auth::user()->adventures()->create($data);

        return redirect()->route('adventures.show', $adventure);
    }

    /**
     * Display the specified resource.
     */
    public function show(Adventure $adventure)
    {
        if (Auth::user()->cannot('view', $adventure)) {
            abort(404);
        }

        if ($adventure->user_id === Auth::user()->id) {
            $adventure->load('chapters', 'locations');
        }

        $userId = Auth::id();
        $isOwner = $userId === $adventure->user_id;

        return Inertia::render('Adventures/Show', [
            'adventure' => fn() => AdventureResource::make($adventure),
            'isOwner' => $isOwner,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adventure $adventure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Adventure $adventure)
    {
        if (Auth::user()->cannot('update', $adventure)) {
            abort(404);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'max:1024'],
            'public' => 'boolean',
        ]);

        $adventure->update($data);

        return redirect()->route('adventures.show', $adventure);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adventure $adventure)
    {
        if (Auth::user()->cannot('delete', $adventure)) {
            abort(404);
        }

        $adventure->chapters()->delete();
        $adventure->locations()->detach();
        $adventure->delete();

        return redirect()->route('adventures.index');
    }
}
