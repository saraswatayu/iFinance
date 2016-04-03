<?php

namespace App\Repositories;

use App\User;
use App\Account;
use App\Budget;
use App\Transaction;

class BudgetRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return Budget::where('email', $user->email)
                    ->orderBy('category', 'asc')
                    ->get();
    }
    
    public function isUnique($category)
    {
        return count(Budget::where('category', $category)->get()) == 0;
    }
}