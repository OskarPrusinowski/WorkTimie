<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Services\Groups\GroupService;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public GroupService $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function show($id)
    {
        $group = $this->groupService->getGroup($id);
        return response()->json(['group' => $group]);
    }
}
