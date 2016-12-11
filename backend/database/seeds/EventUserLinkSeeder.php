<?php

use Illuminate\Database\Seeder;

class EventUserLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('eventuser')->truncate();

        $eventsUser = [
            ['user_id' => 44, 'event_id' => 24, 'joined_at' => new DateTime(), 'active' => 1],
            ['user_id' => 4, 'event_id' => 24, 'joined_at' => new DateTime(), 'active' => 1],
            ['user_id' => 44, 'event_id' => 25, 'joined_at' => new DateTime(), 'active' => 1],
        ];

        DB::table('eventuser')->insert($eventsUser);
    }
}
