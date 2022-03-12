<?php

namespace App\Services\Groups;

use App\Models\Groups\Group;

class GroupsService
{
    public Group $groupModel;

    public function __construct(Group $groupModel)
    {
        $this->groupModel = $groupModel;
    }

    public function list()
    {
        return $this->groupModel->get();
    }
}
