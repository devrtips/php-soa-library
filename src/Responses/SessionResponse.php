<?php

namespace Devrtips\Soa\Responses;

use Devrtips\Soa\Models\Session;
use League\Fractal;

class SessionResponse extends Fractal\TransformerAbstract
{
    public function transform(Session $session)
    {
        $profile = $session->profile;
        $user = $session->profile->user;

        return [
            'token' => $session->token,
            'user' => [
                'uuid' => $user->uuid, 
                'name' => $user->name, 
                'gender' => $user->gender,
                'dob' => $user->dob,
                'email' => $user->email,
                'facebook_id' => $user->facebook_id,
                'profile' => [
                    'uuid' => $profile->uuid,
                    'name' => $profile->name,
                ]
            ]
        ];
    }
}