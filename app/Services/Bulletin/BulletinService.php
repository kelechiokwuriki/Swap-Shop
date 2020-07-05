<?php

namespace App\Services\Bulletin;

use App\Mail\Bulletin;
use App\Repositories\Event\EventRepository;
use App\Repositories\Listing\ListingRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Repositories\Bulletin\BulletinRepository;
use App\Services\User\UserService;

class BulletinService
{
    protected $eventRepository;
    protected $listingRepository;
    protected $bulletinRepository;
    protected $userService;

    public function __construct(EventRepository $eventRepository,
    ListingRepository $listingRepository,
    UserService $userService,
    BulletinRepository $bulletinRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->listingRepository = $listingRepository;
        $this->bulletinRepository = $bulletinRepository;
        $this->userService = $userService;
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

    public function createAndSendBulletin($bulletin)
    {
        $usersEmail = $this->userService->getAllUsersEmailAddress();

        $cleanedData = $this->cleanData($bulletin);


        foreach($usersEmail as $userEmail) {

            Mail::to($userEmail)->queue(new Bulletin(
                $cleanedData['number'],
                $cleanedData['header'],
                $cleanedData['listings'],
                $cleanedData['events'],
                $cleanedData['swap_shop_info']
            ));
        }

        $incrementedBulletinNumber = $cleanedData['number']++;

        $this->createLocalBulletinData($incrementedBulletinNumber, $cleanedData['header'], $cleanedData['swap_shop_info']);


        return 'Done';

    }

    private function createLocalBulletinData(int $number, string $header, string $swapShopInfo)
    {
        return $this->bulletinRepository->create([
            'number' => $number,
            'header' => $header,
            'swap_shop_info' => $swapShopInfo
        ]);
    }

    private function cleanData($bulletin)
    {
        foreach($bulletin['listings'] as $key => $value)
        {
            unset(
                $bulletin['listings'][$key]['id'],
                $bulletin['listings'][$key]['user_id'],
                $bulletin['listings'][$key]['created_at'],
                $bulletin['listings'][$key]['updated_at'],
                $bulletin['listings'][$key]['included_in_bulletin']
            );
        }

        foreach($bulletin['events'] as $key => $value)
        {
            unset(
                $bulletin['events'][$key]['id'],
                $bulletin['events'][$key]['user_id'],
                $bulletin['events'][$key]['created_at'],
                $bulletin['events'][$key]['updated_at'],
                $bulletin['events'][$key]['included_in_bulletin']
            );
        }

        return $bulletin;
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

