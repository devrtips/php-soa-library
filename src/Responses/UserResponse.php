<?php

namespace Devrtips\Soa\Responses;

use Devrtips\Soa\Models\User;
use League\Fractal;

class UserResponse extends Fractal\TransformerAbstract
{
    public function transform(User $user)
    {
        $profiles = [];

        foreach ($user->profiles as $profile) {
            $profiles[] = [
                'uuid' => $profile->uuid,
                'profile' => $profile->profile
            ];
        }

        return [
            'uuid' => $user->uuid, 
            'name' => $user->name, 
            'gender' => $user->gender,
            'dob' => $user->dob,  
            'phone' => $user->phone, 
            'email' => $user->email,
            'facebook_id' => $user->facebook_id,
            'twitter_id' => $user->twitter_id,
            'google_id' => $user->google_id,
            'profiles' => $profiles
        ];
    }
}