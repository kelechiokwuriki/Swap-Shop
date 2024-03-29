<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Bulletin extends Mailable
{
    use Queueable, SerializesModels;

    public $bulletinNumber;
    public $header;
    public $listings;
    public $events;
    public $swapShopInformation;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bulletinNumber, $header, $listings, $events, $swapShopInformation)
    {
        $this->bulletinNumber = $bulletinNumber;
        $this->header = $header;
        $this->listings = $listings;
        $this->events = $events;
        $this->swapShopInformation = $swapShopInformation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.bulletin')->with([
            'bulletinNumber' => $this->bulletinNumber,
            'header' => $this->header,
            'wantedListings' => $this->getWantedListings(),
            'offeredListings' => $this->getOfferedListings(),
            'events' => $this->events,
            'swapShopInformation' => $this->swapShopInformation
        ]);
    }

    private function getWantedListings()
    {
        $wantedListings = [];

        foreach($this->listings as $listing) {
            if($listing['type'] === 'Want') {
                $wantedListings[] = $listing;
            }
        }

        return $wantedListings;
    }

    private function getOfferedListings()
    {
        $offeredListings = [];

        foreach($this->listings as $listing) {
            if($listing['type'] === 'Offer') {
                $offeredListings[] = $listing;
            }
        }

        return $offeredListings;
    }
}
