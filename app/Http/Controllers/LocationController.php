<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Resources\AdventureResource;
use App\Http\Resources\LocationResource;
use App\Models\Adventure;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Locations/Index', [
            'adventures' => LocationResource::collection(Location::get()->latest()->latest('id')->paginate(5))
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

    /**
     * Store a newly created resource in storage.
     */
    public function storeAndAttachToAdventure(Request $request, Adventure $adventure)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => 'string',
        ]);

        $location = Auth::user()->locations()->create($data);
        $adventure->locations()->attach($location);

        return redirect()->route('adventures.locations.show', [$adventure, $location]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        $userId = Auth::id();
        $isOwner = $userId === $location->user_id;

        return Inertia::render('Locations/Show', [
            'location' => $location,
            'isOwner' => $isOwner,
        ]);
    }

    public function showInAdventure(Adventure $adventure, Location $location)
    {
        $adventure->load('chapters', 'locations');
        $location->load('user');

        $userId = Auth::id();
        $isOwner = $userId === $location->user_id;

        return Inertia::render('Locations/ShowInAdventure', [
            'adventure' => $adventure,
            'location' => LocationResource::make($location),
            'isOwner' => $isOwner,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => 'string',
            'public' => 'boolean',
        ]);

        $location->update($data);

        return redirect()->route('locations.show', $location);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateInAdventure(Request $request,Adventure $adventure, Location $location)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => 'string',
            'public' => 'boolean',
        ]);

        $location->update($data);

        return redirect()->route('adventures.locations.show', [$adventure, $location]);
    }

    public function detachFromAdventure(Adventure $adventure, Location $location)
    {
        $adventure->locations()->detach($location);

        return redirect()->route('adventures.show', $adventure);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adventure $adventure, Location $location)
    {
        $adventure->locations()->detach($location);
        $location->delete();

        return redirect()->route('adventures.show', $adventure);
    }
}
