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
		factory(Siravel\Models\Commerce\Plan::class, rand(1, 5))->create();
		factory(Siravel\Models\Commerce\Coupon::class, rand(1, 5))->create();
		factory(Siravel\Models\Commerce\Transaction::class, rand(1, 50))->create();
		factory(Siravel\Models\Commerce\Variant::class, rand(1, 5))->create();
		factory(Siravel\Models\Commerce\Product::class, rand(1, 5))->create();
		factory(Siravel\Models\Commerce\Order::class, rand(1, 50))->create();
		factory(Siravel\Models\Commerce\Cart::class, rand(1, 50))->create();
    }
}
