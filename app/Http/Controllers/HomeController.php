<?php

namespace App\Http\Controllers;

use App\Services\Event\EventService;
use App\Services\Listing\ListingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{
    protected $eventService;
    protected $listingService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EventService $eventService, ListingService $listingService)
    {
        $this->middleware('auth');

        $this->eventService = $eventService;
        $this->listingService = $listingService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        $user->totalListings = $this->listingService->totalListingsForLoggedInUser();
        $user->totalEvents = $this->eventService->totalEventsForLoggedInUser();

        return view('home')->with([
            'user' => $user,
        ]);
    }
}
