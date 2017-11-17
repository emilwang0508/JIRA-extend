<?php

namespace App\Events;

use App\Issue;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IssueAdd implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $issue;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Issue $issue)
    {
        $this->issue = $issue;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('channel-name');
    }
    /**
     * 事件的广播名称。
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'server.issue';
    }
    /**
     * 指定广播数据
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [issue=>$this->issue];
    }
    /**
     * 指定事件被放置在哪个队列上
     *
     * @var string
     */
    public $broadcastQueue = 'issue-queue';
}
