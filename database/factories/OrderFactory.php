<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'AWB' => $this->faker->unique()->regexify('[A-Z0-9]{1,30}'),
            'id_user' => function () {
                return \App\Models\User::inRandomOrder()->value('id_user');
            },
            'id_daerah' => function () {
                return \App\Models\Daerah::inRandomOrder()->value('id_daerah');
            },
            'tujuan' => $this->faker->text(70),
            'penerima' => $this->faker->text(50),
            'no_hp' => $this->faker->regexify('\+?[0-9]{1,15}'),
            'tanggal' => $this->faker->date,
            'status' => $this->faker->randomElement(['Proses', 'Gagal', 'Terkirim']),
        ];
    }
}