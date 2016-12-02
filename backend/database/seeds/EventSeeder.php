<?php

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('events')->truncate();

        $events = [
            ['id' => 24, 'name' => 'PSV - Ajax', 'location' => 'Eindhoven', 'start_time' => new DateTime(), 'end_time' => date("Y-m-d", strtotime("+1 week")), 'category' => 'Sport', 'owner_id' => 44],
            ['id' => 25, 'name' => 'Ajax - PSV', 'location' => 'Amsterdam', 'start_time' => new DateTime(), 'end_time' => date("Y-m-d", strtotime("+1 week")), 'category' => 'Sport', 'owner_id' => 44],
        ];

        DB::table('events')->insert($events);
    }
}
