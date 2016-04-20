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
    public function forAccount($account)
    {   
        return Transaction::where('account_id', $account->id)
                    ->get();
    }
    
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
    
    public function forAccountsPaginated($accounts)
    {
        $account_ids = [];
        foreach ($accounts as $account) {
            if ($account->selected)
                $account_ids[] = $account->id;
        }
        
        return Transaction::whereIn('account_id', $account_ids)->sorted()->paginate();
    }
    
    public function monthTransactions() {
        $from = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d")))."-1 month"));
        
        return Transaction::where('time', '>=', $from)->get();
    }
    
    public function previousTransactions($account, $time) {        
        $totals = array();
        
        for ($i = $time; $i >= 0; $i--) {
            $date = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d")))."-".$i." days"));
            $totals[$date] = 0;
        }
        
        $from = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d")))."-".$time." days"));
        $transactions = Transaction::where('time', '>=', $from)->get();
        for ($i = $time; $i >= 0; $i--) {    
            $transaction = $transactions[$i];
            
            $date = date("Y-m-d", strtotime($transaction->time));
            $totals[$date] += floatval($transaction->price);
        }

        for ($i = $time - 1; $i >= 0; $i--) {    
            $date = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d")))."-".$i." days"));
            $pdate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d")))."-".($i+1)." days"));
            $totals[$date] += $totals[$pdate];
        }

        
        return $totals;
    }
}