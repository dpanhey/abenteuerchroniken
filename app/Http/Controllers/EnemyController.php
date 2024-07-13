<?php

namespace App\Http\Controllers;

use App\Http\Resources\EnemyResource;
use App\Models\Adventure;
use App\Models\Enemy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EnemyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Enemies/Index', [
            'enemies' => EnemyResource::collection(Enemy::get()->latest()->latest('id')->paginate(5))
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
        //
    }

    public function storeAndAttachToAdventure(Request $request, Adventure $adventure)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $enemy = Auth::user()->enemies()->create($data);
        $adventure->enemies()->attach($enemy);

        return redirect()->route('adventures.enemies.show', [$adventure, $enemy]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Enemy $enemy)
    {
        $userId = Auth::id();
        $isOwner = $userId === $enemy->user_id;

        return Inertia::render('Enemies/Show', [
            'enemy' => $enemy,
            'isOwner' => $isOwner
        ]);
    }

    public function showInAdventure(Adventure $adventure, Enemy $enemy)
    {
        $adventure->load('chapters', 'enemies', 'locations', 'nonplayercharacters');
        $enemy->load('user');

        $userId = Auth::id();
        $isOwner = $userId === $enemy->user_id;

        return Inertia::render('Enemies/ShowInAdventure', [
            'adventure' => $adventure,
            'enemy' => EnemyResource::make($enemy),
            'isOwner' => $isOwner
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enemy $enemy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enemy $enemy)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => 'nullable',
            'public' => 'boolean',
        ]);

        $enemy->update($data);

        return redirect()->route('enemies.show', $enemy);
    }

    public function updateInAdventure(Request $request, Adventure $adventure, Enemy $enemy)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => 'nullable',
            'public' => 'boolean',
        ]);

        $enemy->update($data);

        return redirect()->route('adventures.enemies.show', [$adventure, $enemy]);
    }

    public function detachFromAdventure(Adventure $adventure, Enemy $enemy)
    {
        $adventure->enemies()->detach($enemy);

        return redirect()->route('adventures.show', $adventure);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adventure $adventure, Enemy $enemy)
    {
        $adventure->enemies()->detach($enemy);
        $enemy->delete();

        return redirect()->route('adventures.show', $adventure);
    }
}
