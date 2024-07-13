<?php

namespace App\Http\Controllers;

use App\Http\Resources\NonPlayerCharacterResource;
use App\Models\Adventure;
use App\Models\NonPlayerCharacter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NonPlayerCharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('NonPlayerCharacters/Index', [
            'nonPlayerCharacters' => NonPlayerCharacterResource::collection(NonPlayerCharacter::get()->latest()->latest('id')->paginate(5))
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

        $nonPlayerCharacter = Auth::user()->nonPlayerCharacters()->create($data);
        $adventure->nonplayercharacters()->attach($nonPlayerCharacter);

        return redirect()->route('adventures.nonplayercharacters.show', [$adventure, $nonPlayerCharacter]);
    }

    /**
     * Display the specified resource.
     */
    public function show(NonPlayerCharacter $nonPlayerCharacter)
    {
        $userId = Auth::id();
        $isOwner = $userId === $nonPlayerCharacter->user_id;

        return Inertia::render('NonPlayerCharacters/Show', [
            'nonPlayerCharacter' => $nonPlayerCharacter,
            'isOwner' => $isOwner,
        ]);
    }

    public function showInAdventure(Adventure $adventure, NonPlayerCharacter $nonPlayerCharacter)
    {
        $adventure->load('chapters', 'enemies', 'locations', 'nonplayercharacters');
        $nonPlayerCharacter->load('user');

        $userId = Auth::id();
        $isOwner = $userId === $nonPlayerCharacter->user_id;

        return Inertia::render('NonPlayerCharacters/ShowInAdventure', [
            'adventure' => $adventure,
            'nonPlayerCharacter' => NonPlayerCharacterResource::make($nonPlayerCharacter),
            'isOwner' => $isOwner,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NonPlayerCharacter $nonPlayerCharacter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NonPlayerCharacter $nonPlayerCharacter)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => 'nullable',
            'public' => 'boolean',
        ]);

        $nonPlayerCharacter->update($data);

        return redirect()->route('nonplayercharacters.show', $nonPlayerCharacter);
    }

    public function updateInAdventure(Request $request, Adventure $adventure, NonPlayerCharacter $nonPlayerCharacter)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => 'nullable',
            'public' => 'boolean',
        ]);

        $nonPlayerCharacter->update($data);

        return redirect()->route('adventures.nonplayercharacters.show', [$adventure, $nonPlayerCharacter]);
    }

    public function detachFromAdventure(Adventure $adventure, NonPlayerCharacter $nonPlayerCharacter)
    {
        $adventure->nonPlayerCharacters()->detach($nonPlayerCharacter);

        return redirect()->route('adventures.show', $adventure);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adventure $adventure, NonPlayerCharacter $nonPlayerCharacter)
    {
        $adventure->nonPlayerCharacters()->detach($nonPlayerCharacter);
        $nonPlayerCharacter->delete();

        return redirect()->route('adventures.show', $adventure);
    }
}
