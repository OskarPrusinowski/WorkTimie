<?php

namespace App\Services\Holidays;

use App\Models\Holidays\FreeSaturday;

class FreeSaturdaysService
{

    public FreeSaturday $freeSaturdaysModel;

    public function __construct(FreeSaturday $freeSaturdaysModel)
    {
        $this->freeSaturdaysModel = $freeSaturdaysModel;
    }

    public function list()
    {
        return $this->freeSaturdaysModel->get();
    }
}
