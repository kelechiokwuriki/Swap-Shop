<?php

namespace App\Services\Bulletin;

use App\Repositories\Event\EventRepository;
use App\Repositories\Listing\ListingRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Repositories\Bulletin\BulletinRepository;

class BulletinService
{
    protected $eventRepository;
    protected $listingRepository;
    protected $bulletinRepository;


    public function __construct(EventRepository $eventRepository,
    ListingRepository $listingRepository,
    BulletinRepository $bulletinRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->listingRepository = $listingRepository;
        $this->bulletinRepository = $bulletinRepository;
    }

    public function getBulletinForLastSevenDays()
    {
        $convertBooleanListingColumns = [];
        $convertBooleanEventColumns = [];

        $events = $this->eventRepository->getDataCreatedSevenDaysAgo()->with('user')->get()->toArray();

        foreach($events as $event) {
            $convertBooleanEventColumns[] = $this->convertBooleanColumns($event);
        }


        $listings = $this->listingRepository->getDataCreatedSevenDaysAgo()->with('user')->get()->toArray();


        foreach($listings as $listing) {
            $convertBooleanListingColumns[] = $this->convertBooleanColumns($listing);
        }

        return [
            'events' => $convertBooleanEventColumns,
            'listings' => $convertBooleanListingColumns
        ];
    }

    protected function convertBooleanColumns($data)
    {
        return array_map(
            static function($value) {

                if($value === 1) {
                    return true;
                }

                if($value === 0) {
                    return false;
                }

                return $value;
            },
            $data
        );
    }

    public function getLatestBulletinData()
    {
        $bulletin = $this->bulletinRepository->latest()->first();

        $bulletin->number++;

        return $bulletin;
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

