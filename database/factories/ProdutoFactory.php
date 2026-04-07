<?php

namespace Database\Factories;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Produto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_categoria' => Categoria::factory(),
            'nome' => $this->faker->word(),
            'descricao' => $this->faker->sentence(),
            'imagem' => 'exemplo.png',
            'preco' => $this->faker->randomFloat(2, 10, 100),
            'eh_vegano' => $this->faker->boolean(),
            'eh_sem_gluten' => $this->faker->boolean(),
            'em_estoque' => $this->faker->boolean(),
            'porcoes' => $this->faker->numberBetween(1, 4)

        ];
    }
}
