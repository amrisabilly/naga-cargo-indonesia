<?php

namespace Database\Factories;

use App\Models\OrderFoto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderFoto>
 */
class OrderFotoFactory extends Factory
{
    protected $model = OrderFoto::class;

    public function definition()
    {
        return [
            'AWB' => function () {
                return \App\Models\Order::inRandomOrder()->value('AWB');
            },
            'path_foto' => $this->faker->text(255),
            'tanggal_upload' => now(),
            'keterangan' => $this->faker->text(100),
        ];
    }
}