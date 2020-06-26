<?php

namespace App\Services\Event;

use App\Repositories\Event\EventRepository;


class EventService
{
    protected $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function createEvent(array $event)
    {
        return $this->eventRepository->create($event);
    }

    public function getEventsForLoggedInUser()
    {
        return $this->eventRepository->getEventsForLoggedInUser();
    }
}
