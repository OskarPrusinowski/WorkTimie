<?php

namespace App\Services\Holidays;

use App\Models\Holidays\FreeSaturday;

class FreeSaturdayService
{

    public FreeSaturday $freeSaturdayModel;

    public function __construct(FreeSaturday $freeSaturdaysModel)
    {
        $this->freeSaturdayModel = $freeSaturdaysModel;
    }

    public function getFreeSaturday($id)
    {
        return $this->freeSaturdayModel->find($id);
    }

    public function changeFreeStaruday($freeSaturdayId)
    {
        $freeSaturday = $this->getFreeSaturday($freeSaturdayId);
        $freeSaturday->free = !$freeSaturday->free;
        $freeSaturday->save();
    }
}
