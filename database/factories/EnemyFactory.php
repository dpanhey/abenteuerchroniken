<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enemy>
 */
class EnemyFactory extends Factory
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
            'name' => fake()->realText(50),
            'slug' => fake()->slug(),
            'description' => fake()->paragraphs(5, true),
            'public' => fake()->boolean(),
        ];
    }

    public function withEnemyFixture(): static
    {
        $enemies = collect(File::files(database_path('factories/fixtures/enemies')))
            ->map(fn (SplFileInfo $fileInfo) => $fileInfo->getContents())
            ->map(fn (string $contents) => str($contents)->explode("\n", 2))
            ->map(fn (Collection $parts) => [
                'name' => str($parts[0])->trim()->after('## '),
                'description' => str($parts[1])->trim(),
            ]);

        return $this->sequence(...$enemies);
    }
}
