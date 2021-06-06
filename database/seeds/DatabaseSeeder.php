<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            //code...
            // $this->call(UsersTableSeeder::class);
            $this->call(CommerceSeeder::class);
        } catch (\Throwable $th) {
            //throw $th;
            \Log::warning('Aqui deu ruim 21212!');
        }
    }
}
