<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)
            ->create()->each(static function (User $user) {
                Organisation::factory()->create([
                    'owner_user_id' => $user->id,
                ]);
            });
    }
}
