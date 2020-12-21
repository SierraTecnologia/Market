<?php

namespace Database\Market\Factories;

use Market\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'cheap hosting',
            'uuid' => \Illuminate\Support\Str::random(20),
            'amount' => 9999,
            'interval' => 'monthly',
            'currency' => 'usd',
            'enabled' => true,
            'sitecpayment_name' => 'cheap-package',
            'trial_days' => 30,
            'subscription_name' => 'default',
            'descriptor' => 'dumb is dumb',
            'description' => $this->faker->paragraph().' '.$this->faker->paragraph(),
            'updated_at' => $this->faker->datetime(),
            'created_at' => $this->faker->datetime(),
    
        ];
    }
}


// /*
// |--------------------------------------------------------------------------
// | Subscription Plans Factory
// |--------------------------------------------------------------------------
// */

// $factory->define(\Market\Models\Plan::class, function (Faker\Generator $faker) {
    // return [
    //     'name' => 'cheap hosting',
    //     'uuid' => \Illuminate\Support\Str::random(20),
    //     'amount' => 9999,
    //     'interval' => 'monthly',
    //     'currency' => 'usd',
    //     'enabled' => true,
    //     'sitecpayment_name' => 'cheap-package',
    //     'trial_days' => 30,
    //     'subscription_name' => 'default',
    //     'descriptor' => 'dumb is dumb',
    //     'description' => $faker->paragraph().' '.$faker->paragraph(),
    //     'updated_at' => $faker->datetime(),
    //     'created_at' => $faker->datetime(),

    // ];
// });