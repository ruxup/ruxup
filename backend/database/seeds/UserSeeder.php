<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        $faker = Faker::create();
        $users = [];

        foreach(range(1,5) as $index)
        {
            $users[] = [
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => $faker->password(6, 20),
            ];
        }

        DB::table('users')->insert($users);
    }
}
