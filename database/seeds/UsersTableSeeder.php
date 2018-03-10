<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		App\User::create([
			'name' => 'Gradi',
			'email' => 'gradiph@gmail.com',
			'password' => bcrypt('kamusdota'),
		]);

        factory(App\User::class, 3)->create();
    }
}
