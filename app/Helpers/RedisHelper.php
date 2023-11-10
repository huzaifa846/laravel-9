<?php

namespace App\Helpers;

use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Support\Facades\Redis;

class RedisHelper implements RedisHelperInterface
{
    public function storeRecentMessage(mixed $id, string $messageSubject, string $toEmailAddress): void
    {
        $key = 'recent_messages';

        $messageData = [
            'id' => $id,
            'message_subject' => $messageSubject,
            'to_email_address' => $toEmailAddress,
        ];

        // Store the message data in Redis as a JSON string
        Redis::rpush($key, json_encode($messageData));
    }
}
