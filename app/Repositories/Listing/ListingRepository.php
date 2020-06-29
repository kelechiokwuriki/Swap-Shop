<?php

namespace App\Repositories\Listing;

use App\Repositories\BaseRepository;
use App\Listing;


class ListingRepository extends BaseRepository
{
    protected $listingModel;

    public function __construct(Listing $listingModel)
    {
        parent::__construct($listingModel);
    }

    public function getListingsForLoggedInUser()
    {
        return auth()->user()->listings()->orderBy('created_at', 'DESC')->get();
    }

    public function totalListingsForLoggedInUser()
    {
        return auth()->user()->listings()->count();
    }
}
