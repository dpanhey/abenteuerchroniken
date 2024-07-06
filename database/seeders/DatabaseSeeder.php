<?php

namespace Database\Seeders;

use App\Models\Adventure;
use App\Models\Chapter;
use App\Models\Enemy;
use App\Models\Location;
use App\Models\NonPlayerCharacter;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        $adventures = Adventure::factory(8)
            ->withAdventureFixture()
            ->recycle($users)
            ->create();

        $chapters = Chapter::factory(25)
            ->withChapterFixture()
            ->recycle($adventures)
            ->create();

        $locations = Location::factory(15)
            ->withLocationFixture()
            ->recycle($users)
            ->afterCreating(function (Location $location) use ($adventures) {
                $location->adventures()->attach(
                    $adventures->random(rand(1, 3))->pluck('id')->toArray()
                );
            })
            ->create();

        $nonplayercharacters = NonPlayerCharacter::factory(15)
            ->withNonPlayerCharacterFixture()
            ->recycle($users)
            ->afterCreating(function (NonPlayerCharacter $nonPlayerCharacter) use ($adventures) {
                $nonPlayerCharacter->adventures()->attach(
                    $adventures->random(rand(1, 3))->pluck('id')->toArray()
                );
            })
            ->create();

        $enemies = Enemy::factory(15)
            ->withEnemyFixture()
            ->recycle($users)
            ->afterCreating(function (Enemy $enemy) use ($adventures) {
                $enemy->adventures()->attach(
                    $adventures->random(rand(1, 3))->pluck('id')->toArray()
                );
            })
            ->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
