<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Company\Models\Company;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type =  $this->faker->randomElement(['creditor', 'debtor']);
        return [
            'name' => $this->faker->company,
            'type' => $type,
            'debtor_total_limit' => $type == 'debtor' ? null : rand(1,9) * 10000,
        ];
    }
}
