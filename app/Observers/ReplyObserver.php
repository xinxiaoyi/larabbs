<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $topic = $reply->topic;
        $topic->increment('reply_count', 1);

        // 通知作者话题被回复了
        $topic->user->notify(new TopicReplied($reply));
    }

	public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function deleted(Reply $reply)
    {
    	if ($reply->topic->reply_count > 0) {
            $reply->topic->decrement('reply_count', 1);
        }
    }

}