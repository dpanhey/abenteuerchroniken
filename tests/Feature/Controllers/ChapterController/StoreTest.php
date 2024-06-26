<?php

use App\Models\Adventure;
use App\Models\Chapter;
use App\Models\User;

it('can store a new chapter', function () {
    $user = User::factory()->create();
    $adventure = Adventure::factory()->create();

    $this->actingAs($user)->post(route('adventures.chapters.store', $adventure), [
        'title' => 'Test Chapter',
        'slug' => 'test-chapter',
        'content' => 'This is a chapter content.'
    ]);

    $this->assertDatabaseHas(Chapter::class, [
        'title' => 'Test Chapter',
        'content' => 'This is a chapter content.',
        'adventure_id' => $adventure->id
    ]);
});

it('redirects to the chapter show page', function () {
    $user = User::factory()->create();
    $adventure = Adventure::factory()->create();

    $chapterData = [
        'title' => 'Test Chapter',
        'slug' => 'test-chapter',
        'content' => 'This is a chapter content.'
    ];

    $response = $this->actingAs($user)
        ->post(route('adventures.chapters.store', $adventure), $chapterData);

    // Retrieve the newly created chapter
    $chapter = Chapter::where('title', 'Test Chapter')->where('adventure_id', $adventure->id)->first();

    // Redirect to the newly created chapter's show page
    $response->assertRedirect(route('adventures.chapters.show', [$adventure, $chapter]));
});
