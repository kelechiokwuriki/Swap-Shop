<?php

namespace App\Services\Bulletin;

use App\Repositories\Event\EventRepository;
use App\Repositories\Listing\ListingRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BulletinService
{
    protected $eventRepository;
    protected $listingRepository;

    public function __construct(EventRepository $eventRepository, ListingRepository $listingRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->listingRepository = $listingRepository;
    }

    public function getBulletinForLastSevenDays()
    {
        $events = $this->eventRepository->getDataCreatedSevenDaysAgo()->get();

        $listings = $this->listingRepository->getDataCreatedSevenDaysAgo()->get();

        return [
            'events' => $events,
            'listings' => $listings
        ];
    }

    protected function getAllListings()
    {
        return $this->listingService->getAllListings();
    }

    protected function getAllEvents()
    {
        return $this->eventService->getAllEvents();
    }
}

