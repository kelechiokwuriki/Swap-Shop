<?php

namespace App\Repositories\Listing;

use App\Repositories\BaseRepository;
use App\Event;


class EventRepository extends BaseRepository
{
    protected $eventModel;

    public function __construct(Event $eventModel)
    {
        parent::__construct($$eventModel);
    }
}
