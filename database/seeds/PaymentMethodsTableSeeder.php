<?php

use Illuminate\Database\Seeder;
use App\PaymentMethod;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'name' => 'Bank Transfer',
        ]);
    }
}
