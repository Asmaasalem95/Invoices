<?php

namespace Database\Factories;

use Modules\Company\Models\Company;
use Modules\Invoice\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = $this->faker->randomElement([0,1]);
        $paid_at =  $status == 0 ? null : $this->faker->dateTimeBetween('+1 month', '+2 month');
        $total = rand(1,9) * 10000;
        $feesTotal =  $this->faker->numberBetween( 500,$total);


        return [
            'creditor_id' =>  Company::factory()->create(['type' => 'creditor', 'debtor_total_limit' => 50000]),
        'debtor_id' =>  Company::factory()->create(['type' => 'debtor','debtor_total_limit'=> null]),
            'status' => $status,
            'paid_at' => $paid_at,
            'due_date' => !is_null($paid_at) ? $this->faker->dateTime($paid_at) : $this->faker->dateTimeBetween('+1 month', '+2 month'),
            'total_amount' => $total,
            'fees_amount' => $feesTotal ,
            'selling_amount' => $total - $feesTotal
        ];
    }
}
