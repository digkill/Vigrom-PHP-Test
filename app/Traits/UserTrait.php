<?php

namespace App\Traits;

use App\User;

trait UserTrait
{
    /* @var User */
    private $user;

    public function getUserId()
    {
        return $this->getUser()->id;
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|\App\User
     */
    public function getUser()
    {
        /** $user User */
        $user = auth()->user();

        return $user ?? $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
