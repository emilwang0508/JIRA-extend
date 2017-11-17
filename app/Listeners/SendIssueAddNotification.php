<?php

namespace App\Listeners;

use App\Events\IssueAdd;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendIssueAddNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IssueAdd  $event
     * @return void
     */
    public function handle(IssueAdd $event)
    {
        //
    }
}
