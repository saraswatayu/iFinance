<?php

namespace App\Repositories;

use App\User;
use App\Transaction;

class TransactionRepository
{
    /**
     * Get all of the tasks for a given account.
     *
     * @param  Array<Account>  $accounts
     * @return Collection
     */
    public function forAccounts($accounts, $sort)
    {
        $account_ids = [];
        foreach ($accounts as $account) {
            if ($account->selected)
                $account_ids[] = $account->id;
        }
        
        return Transaction::whereIn('account_id', $account_ids)
                    ->orderBy($sort, 'asc')
                    ->get();
    }
}