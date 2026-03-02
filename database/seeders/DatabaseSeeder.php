<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking\ProviderUser;
use App\Models\Booking\MaintenanceUser;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // ProviderUser::factory()->create([
        //     'name' => 'Kevin Jonas',
        //     'email' => 'kevin@jonas.brothers',
        //     'password' => bcrypt('k3vinjon@s'),
        //     'provider_id' => 2,
        // ]);

        // ProviderUser::factory()->create([
        //     'name' => 'Joe Jonas',
        //     'email' => 'joe@jonas.brothers',
        //     'password' => bcrypt('j0ejon@s'),
        //     'provider_id' => 5,
        // ]);

        MaintenanceUser::factory(7)->create();
        // or
        // MaintenanceUser::factory()->plumber()->create();
    }
}
