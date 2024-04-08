<?php

namespace App\Domain\Clients\Models\Tests\Factories;

use App\Domain\Clients\Models\Clients;
use Ensi\LaravelTestFactories\BaseModelFactory;

class ClientsFactory extends BaseModelFactory
{
    protected $model = Clients::class;

    public function definition(): array
    {
        return [
            'fio' => $this->faker->text(100),
            'phone_number' => $this->faker->text(20),
        ];
    }
}
