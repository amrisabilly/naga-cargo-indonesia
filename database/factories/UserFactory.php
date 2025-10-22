<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role' => $this->faker->randomElement(['Kurir', 'PIC']),
            'nama' => $this->faker->text(100),
            'username' => $this->faker->unique()->regexify('[a-zA-Z0-9._]{1,50}'),
            'password' => bcrypt('password'),
            'no_hp' => $this->faker->regexify('\+?[0-9]{1,15}'),
            'id_daerah' => null,
            'status' => $this->faker->randomElement(['Aktif', 'Nonaktif']),
            
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
