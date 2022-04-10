<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organisation>
 */
class OrganisationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $subbed = random_int(0, 1);

        return [
            'name' => $this->faker->company,
            'subscribed' => $subbed,
            'trial_end' => !$subbed ? Carbon::now()->addDays(30) : null,
        ];
    }
}
