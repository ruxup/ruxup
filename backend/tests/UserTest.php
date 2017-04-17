<?php

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
    }

    public function test_get_events()
    {
        $this->json('GET', "api/getEvents/4")->seeStatusCode(200)->decodeResponseJson();
    }

    public function test_get_events_where_owner()
    {
        $this->json('GET', "api/getEventsOwner/44")->seeStatusCode(200)->decodeResponseJson();
    }

    public function test_join_event()
    {
        $response = $this->call('GET', "api/joinEvent/44/25");
        $this->assertEquals('200 User Radu has joined event Ajax - PSV', $response->status() . ' ' . $response->getContent());
    }

    public function test_find_event()
    {
        $data = [
            'start_time' =>  Carbon::parse('2016-11-26 14:50:32')->format('Y-m-d H:i:s'),
            'end_time' => Carbon::parse('2017-11-26 15:50:32')->format('Y-m-d H:i:s'),
            'type' => 'time',
        ];
        $this->json('POST', "api/findEvent", $data)->seeStatusCode(200)->decodeResponseJson();
    }

    public function test_comment()
    {
        $data = [
            'description' => 'First message',
            'time_sent' => Carbon::parse('2016-12-14 14:50:32')->format('Y-m-d H:i:s'),
            'owner_id' => 44,
            'event_id' => 24
        ];
        $this->json('POST', "api/comment", $data)->seeStatusCode(200)->decodeResponseJson();
    }
}