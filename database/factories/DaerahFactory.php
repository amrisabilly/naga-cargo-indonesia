<?php

namespace Database\Factories;

use App\Models\Daerah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Daerah>
 */
class DaerahFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Daerah::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kode' => $this->faker->unique()->regexify('[A-Z0-9]{1,5}'),
            'nama' => $this->faker->text(50),
            'latitude' => $this->faker->regexify('-?[0-9]{1,2}\.[0-9]{1,6}'),
            'longitude' => $this->faker->regexify('-?[0-9]{1,3}\.[0-9]{1,6}'),
        ];
    }
}