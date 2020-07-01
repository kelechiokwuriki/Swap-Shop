<?php

namespace App\Repositories\Bulletin;

use App\Repositories\BaseRepository;
use App\Bulletin;


class BulletinRepository extends BaseRepository
{
    protected $bulletinModel;

    public function __construct(Bulletin $bulletinModel)
    {
        parent::__construct($bulletinModel);
    }
}
