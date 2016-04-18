<?php

namespace App\Repositories;

use App\User;
use App\Account;

class AccountRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return Account::where('email', $user->email)
                    ->orderBy('name', 'asc')
                    ->get();
    }
    
    public function selectedForUser(User $user) 
    {
        return Account::where('email', $user->email)
                    ->where('selected', true)
                    ->orderBy('name', 'asc')
                    ->get();
    }
}