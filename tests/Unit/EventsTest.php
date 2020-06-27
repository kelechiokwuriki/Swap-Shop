<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Repositories\Event\EventRepository;
use App\Services\Event\EventService;
use Carbon\Carbon;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    protected $eventRepository;
    protected $eventService;
    protected $eventRequest;
    protected $event;
    protected $user;


    public function setup(): void
    {
        parent::setup();

        //user setup
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
            'api_token' => Str::random(80),
            'remember_token' => Str::random(10)
        ]);

        $this->eventRepository = new EventRepository(new Event());
        $this->eventService = new EventService($this->eventRepository);

        $this->eventRequest = new \stdClass();
        $this->eventRequest->name = 'Birthday';
        $this->eventRequest->when = Carbon::now()->toDateTimeString();
        $this->eventRequest->information = 'An information about the event';
        $this->eventRequest->contact_info = 'Contact info';

        $this->event = [
            'name' => $this->eventRequest->name,
            'when' => $this->eventRequest->when,
            'information' => $this->eventRequest->information,
            'contact_info' => $this->eventRequest->contact_info,
            'user_id' => $this->user->id
        ];
    }

    public function testPostEvent()
    {
        $response = $this->json(
            'POST',
            '/api/events',
            $this->event,
            [
                'Authorization' => 'Bearer ' . $this->user->api_token
            ]
        );

        $response->assertStatus(201);
        $this->assertDatabaseHas('events', $this->event);
    }

    public function testCreateEvent()
    {
        $this->eventService->createEvent($this->event);
        $this->assertDatabaseHas('events', $this->event);
    }

    public function testEditEvent()
    {
        $eventCreated = Event::create($this->event);

        $this->event['name'] = 'A new event name';
        $this->eventService->updateEvent($eventCreated->id, $this->event);

        $this->assertEquals(Event::first()->name, $this->event['name']);
    }

}
