<?php

namespace App\Services\Listing;

use App\Repositories\Listing\ListingRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ListingService
{
    protected $listingRepository;

    public function __construct(ListingRepository $listingRepository)
    {
        $this->listingRepository = $listingRepository;
    }

    public function getAllListings()
    {
        return $this->listingRepository->all();
    }

    public function createListing(array $listing)
    {
        Log::debug(Auth::user());
        // return $this->listingRepository->create($listing);
    }

    public function updateListing(int $id, array $listing)
    {
        return $this->listingRepository->update($id, $listing);
    }

    public function deleteListing(int $id)
    {
        return $this->listingRepository->delete($id);
    }
}
