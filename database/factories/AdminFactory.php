<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition()
    {
        return [
            'username' => $this->faker->unique()->regexify('[a-zA-Z0-9._]{1,50}'),
            'password' => bcrypt('password'),
            'nama' => $this->faker->text(100),
        ];
    }
}