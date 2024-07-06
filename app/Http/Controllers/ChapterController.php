<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdventureResource;
use App\Http\Resources\ChapterResource;
use App\Models\Adventure;
use App\Models\Chapter;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ChapterController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Adventure $adventure, Chapter $chapter)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Adventure $adventure)
    {
        if (Auth::user()->cannot('create', Chapter::class)) {
            abort(403);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:75'],
        ]);

        $chapter = $adventure->chapters()->create($data);

        return redirect()->route('adventures.chapters.show', [$adventure, $chapter]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Adventure $adventure, Chapter $chapter)
    {
        $adventure->load('chapters', 'enemies', 'locations', 'nonplayercharacters');
        return Inertia::render('Chapters/Show', [
            'chapter' => ChapterResource::make($chapter),
            'adventure' => fn() => AdventureResource::make($adventure),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adventure $adventure, Chapter $chapter)
    {
        if (Auth::user()->cannot('update', $chapter)) {
            abort(403);
        }

        $adventure->load('chapters');
        return Inertia::render('Chapters/Edit', [
            'chapter' => ChapterResource::make($chapter),
            'adventure' => fn() => AdventureResource::make($adventure),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Adventure $adventure, Chapter $chapter)
    {
        if (Auth::user()->cannot('update', $chapter)) {
            abort(403);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'content' => 'nullable',
        ]);

        $chapter->update($data);

        return redirect()->route('adventures.chapters.show', [$adventure, $chapter]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adventure $adventure, Chapter $chapter)
    {
        if (Auth::user()->cannot('delete', $chapter)) {
            abort(403);
        }

        $chapter->delete();

        return redirect()->route('adventures.show', $adventure);
    }
}
