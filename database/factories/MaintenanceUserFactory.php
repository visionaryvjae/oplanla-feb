<?php

namespace Database\Factories\Booking;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking\MaintenanceUser; //

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Booking\MaintenanceUser>
 */
class MaintenanceUserFactory extends Factory
{

    protected $model = MaintenanceUser::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specialties = [
            'plumbing',
            'electrical',
            'carpentry',
            'HVAC',
            'painting',
            'roofing',
            'landscaping',
            'appliance repair',
            'tile work',
            'drywall'
        ];

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'speciality' => fake()->randomElement($specialties),
            'providers_id' => 29,
        ];
    }
}
