<?php

namespace Devrtips\Soa\Responses;

use League\Fractal;
use Devrtips\Soa\Entities\ThreadEntity;

class ThreadResponse extends Fractal\TransformerAbstract
{
    public function transform(ThreadEntity $thread)
    {
        $messages = [];

        foreach ($thread->messages as $message) {
            $messages[] = [
                'uuid' => $message->uuid,
                'message' => $message->message,
                'expires_at' => $message->expires_at,
                'created_at' => $message->created_at,
                'updated_at' => $message->updated_at
            ];
        }

        return [
            'uuid' => $thread->uuid, 
            'created_at' => $thread->created_at, 
            'updated_at' => $thread->updated_at,
            'messages' => $messages
        ];
    }
}