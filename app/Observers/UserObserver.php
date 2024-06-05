<?php

namespace App\Observers;

use App\Models\User;

class UserObserver {

    /**
     * Make actions after created user
     * @param User
     * @return void
     */
    public function created(User $user)
    {       
    }

    /**
     * Make actions after updated user
     * @param User
     * @return void
     */
    public function updated(User $user)
    {       
    }

    /**
     * Make actions after deleted user
     * @param User
     * @return void
     */
    public function deleted(User $user)
    {
    }
}