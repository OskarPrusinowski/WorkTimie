<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Services\Groups\GroupsService;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public GroupsService $groupsService;

    public function __construct(GroupsService $groupsService)
    {
        $this->groupsService = $groupsService;
    }

    public function list()
    {
        $groups = $this->groupsService->list();
        return response()->json(['groups' => $groups]);
    }
}
