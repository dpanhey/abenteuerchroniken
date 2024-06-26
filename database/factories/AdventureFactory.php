<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adventure>
 */
class AdventureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->realText(50),
            'slug' => fake()->slug(),
            'description' => fake()->paragraphs(3, true),
            'cover' => fake()->imageUrl(),
            'public' => fake()->boolean(),
        ];
    }

    public function withAdventureFixture(): static
    {
        $adventures = collect(File::files(database_path('factories/fixtures/adventures')))
            ->map(fn (SplFileInfo $fileInfo) => $fileInfo->getContents())
            ->map(fn (string $contents) => str($contents)->explode("\n", 2))
            ->map(fn (Collection $parts) => [
                'title' => str($parts[0])->trim()->after('## '),
                'description' => str($parts[1])->trim(),
            ]);

        return $this->sequence(...$adventures);
    }
}
