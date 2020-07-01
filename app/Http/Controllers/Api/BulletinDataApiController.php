<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Bulletin\BulletinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BulletinDataApiController extends Controller
{
    protected $bulletinService;

    public function __construct(BulletinService $bulletinService)
    {
        $this->bulletinService = $bulletinService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBulletinForSevenDays()
    {
        return $this->bulletinService->getBulletinForLastSevenDays();
    }
}
