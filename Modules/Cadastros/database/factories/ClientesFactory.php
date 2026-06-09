<?php

namespace Modules\Cadastros\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cadastros\Models\Clientes;

class ClientesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Clientes>
     */
    protected $model = Clientes::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $tipo = $this->faker->randomElement(['F', 'J']);
        $codigo = 'CLI'.$this->faker->unique()->numerify('####');

        return [
            'cli_codigo' => $codigo,
            'cli_nome' => $tipo === 'F'
                ? $this->faker->name()
                : $this->faker->company(),
            'cli_tipo' => $tipo,
            'cli_cpf_cnpj' => $tipo === 'F'
                ? $this->faker->numerify('###########')
                : $this->faker->numerify('##############'),
            'cli_ie' => $this->faker->numerify('##############'),
            'cli_im' => $this->faker->numerify('##########'),
            'cli_nao_contribuinte' => false,
            'cli_substituto_tributario_iss' => false,
            'cli_nao_calcula_diferimento_icms' => false,
            'cli_apura_icms' => false,
            'cli_aliquota_icms_diferenciada_contribuinte' => false,
            'cli_logradouro' => $this->faker->streetName(),
            'cli_numero' => $this->faker->buildingNumber(),
            'cli_complemento' => $this->faker->optional(0.5)->word(),
            'cli_bairro' => $this->faker->word(),
            'cli_cidade' => $this->faker->city(),
            'cli_estado' => $this->faker->stateAbbr(),
            'cli_cep' => $this->faker->postcode(),
            'cli_telefone' => $this->faker->optional(0.7)->phoneNumber(),
            'cli_celular' => $this->faker->optional(0.9)->phoneNumber(),
            'cli_email' => $this->faker->unique()->safeEmail(),
            'cli_ativo' => true,
        ];
    }
}
