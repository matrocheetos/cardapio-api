<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\Mesa;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Pedido::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comanda' => Mesa::factory(),
            'id_produto' => Produto::factory(),
            'observacao' => $this->faker->sentence()
        ];
    }
}
