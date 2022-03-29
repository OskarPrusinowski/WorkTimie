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
        $this->middleware("permission:groupsShow");
        $this->middleware("permission:groupsManage");
    }

    public function show($id)
    {
        $group = $this->groupService->get($id);
        return response()->json(['group' => $group]);
    }
}
