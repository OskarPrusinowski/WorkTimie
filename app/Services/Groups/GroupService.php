<?php

namespace App\Services\Groups;

use App\Models\Groups\Group;

class GroupService
{
    public Group $groupModel;

    public function __construct(Group $groupModel)
    {
        $this->groupModel = $groupModel;
    }

    public function getGroup($id)
    {
        return $this->groupModel->find($id);
    }
}
