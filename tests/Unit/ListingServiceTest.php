<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use App\Listing;
use App\User;
use App\Repositories\Listing\ListingRepository;
use App\Services\Listing\ListingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Tests\TestCase;


class ListingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $listingService;
    protected $listingRepository;
    protected $user;
    protected $listingRequest;
    protected $listing;

    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function setup(): void
    {
        parent::setup();

        //user setup
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
            'api_token' => Str::random(80),
            'remember_token' => Str::random(10)
        ]);
        $this->actingAs($this->user);

        //listing repository
        $this->listingRepository = new ListingRepository(new Listing());
        //listing service
        $this->listingService = new ListingService($this->listingRepository);

        //listing request setup
        $this->listingRequest = new \stdClass();
        $this->listingRequest->type = 'wanted';
        $this->listingRequest->item = 'An item i want';
        $this->listingRequest->information = 'I need the item to have bla bla please';
        $this->listingRequest->deal = 'I have money to offer for this';

        //listing to be sent from front end
        $this->listing = [
            'type' => $this->listingRequest->type,
            'item' => $this->listingRequest->item,
            'information' => $this->listingRequest->information,
            'deal' => $this->listingRequest->deal
        ];
    }

    public function testCreateListingFromFrontEnd()
    {
        $this->be($this->user);

        $response = $this->json(
            'POST',
            '/api/listings',
            $this->listing,
            [
                'Authorization' => 'Bearer ' . $this->user->api_token
            ]
        );

        $response->assertStatus(201);
        $this->assertDatabaseHas('listings', $this->listing);
    }

    public function testCreateListing()
    {
        $this->listing['user_id'] = $this->user->id;
        $this->listingService->createListing($this->listing);
        $this->assertDatabaseHas('listings', $this->listing);
    }

    public function testEditListing()
    {
        $this->listing['user_id'] = $this->user->id;
        $listinCreated = Listing::create($this->listing);

        $this->listing['type'] = 'Offer';
        $this->listingService->updateListing($listinCreated->id, $this->listing);

        $this->assertEquals(Listing::first()->type, $this->listing['type']);
    }
}
