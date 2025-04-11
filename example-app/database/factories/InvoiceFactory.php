<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'invoice_number' => 'F/' . $this->faker->unique()->numberBetween(1, 999),
            'buyer_nip' => $this->faker->numerify('##########'),
            'seller_nip' => $this->faker->numerify('##########'),
            'product_name' => $this->faker->word(),
            'product_price' => $this->faker->randomFloat(2, 50, 1000),
            'issue_date' => Carbon::now()->subDays(rand(1, 10))->toDateString(),
            'edit_date' => Carbon::now()->toDateString(),
        ];
    }
}
