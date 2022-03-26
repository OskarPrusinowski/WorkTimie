<?php

namespace App\Listeners;

use App\Events\UserCreatedEvent;
use App\Services\Leaves\LeaveService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateLeaveListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public LeaveService $leaveService;

    public function __construct(LeaveService $leaveService)
    {
        $this->leaveService = $leaveService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserCreatedEvent  $event
     * @return void
     */
    public function handle(UserCreatedEvent $event)
    {
        $leave['user_id'] = $event->userId;
        $leave['start'] = null;
        $leave['end'] = null;
        $this->leaveService->create($leave);
    }
}
