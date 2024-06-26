<?php

namespace Database\Factories;

use App\Models\Adventure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chapter>
 */
class ChapterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'adventure_id' => Adventure::factory(),
            'title' => fake()->realText(50),
            'slug' => fake()->slug(),
            'content' => fake()->paragraphs(5, true),
            'public' => fake()->boolean(),
        ];
    }

    public function withChapterFixture(): static
    {
        $chapters = collect(File::files(database_path('factories/fixtures/chapters')))
            ->map(fn (SplFileInfo $fileInfo) => $fileInfo->getContents())
            ->map(fn (string $contents) => str($contents)->explode("\n", 2))
            ->map(fn (Collection $parts) => [
                'title' => str($parts[0])->trim()->after('## '),
                'content' => str($parts[1])->trim(),
            ]);

        return $this->sequence(...$chapters);
    }
}
