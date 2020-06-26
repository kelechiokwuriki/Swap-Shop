<?php

namespace App\Repositories\Event;

use App\Repositories\BaseRepository;
use App\Event;


class EventRepository extends BaseRepository
{
    protected $eventModel;

    public function __construct(Event $eventModel)
    {
        parent::__construct($eventModel);
    }

    public function getEventsForLoggedInUser()
    {
        return auth()->user()->events()->orderBy('created_at', 'DESC')->get();
    }
}
