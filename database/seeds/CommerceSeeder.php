<?php

use Illuminate\Database\Seeder;

class CommerceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		factory(Market\Models\Plan::class, rand(1, 5))->create();
		factory(Market\Models\Coupon::class, rand(1, 5))->create();
		factory(Market\Models\Transaction::class, rand(1, 50))->create();
		factory(Market\Models\Variant::class, rand(1, 5))->create();
		factory(Market\Models\Product::class, rand(1, 5))->create();
		factory(Market\Models\Order::class, rand(1, 50))->create();
		factory(Market\Models\Cart::class, rand(1, 50))->create();
    }
}
