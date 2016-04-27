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
        $from = date('Y-m-01');
        
        return Transaction::where('time', '>=', $from)->get();
    }
    
    public function monthlyTotalsForCategory($category) {
        $totalMonths = 12;
        $totals = array();
        
        for ($i = $totalMonths; $i >= 0; $i--) {
            $start = date("Y-m-01", strtotime(date("Y-m-d", strtotime(date("Y-m-d")))."-".$i." month"));
            $end = date("Y-m-t", strtotime(date("Y-m-d", strtotime(date("Y-m-d")))."-".$i." month"));
            
            $transactions = Transaction::where('time', '>=', $start)->where('time', '<=', $end)->where('category', $category)->get();
            $ttotal = 0;
            foreach ($transactions as $transaction) {
                $ttotal += floatval($transaction->price);
            }
            $totals[] = $ttotal;
        }
        
        $totals = array_reverse($totals);
        return $totals;
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
    
    public function previousTransactionsBetweenDates($account, $startDate, $time) {        
        $totals = array();
        
        for ($i = $time; $i >= 0; $i--) {
            $date = date("Y-m-d", strtotime('-'.$i.' days', $startDate));
            $totals[$date] = 0;
        }
        
        $from = date("Y-m-d", strtotime('-'.$time.' days', $startDate));
        $to = date("Y-m-d", $startDate);
        $transactions = Transaction::where('time', '>=', $from)->where('account_id', $account->id)->where('time', '<=', $to)->get();
        for ($i = $time; $i >= 0; $i--) {   
            if (isset($transactions[$i])) {
                $transaction = $transactions[$i];

                $date = date("Y-m-d", strtotime($transaction->time));
                $totals[$date] += floatval($transaction->price);
            }
        }

        for ($i = $time - 1; $i >= 0; $i--) {    
            $date = date("Y-m-d", strtotime('-'.$i.' days', $startDate));
            $pdate = date("Y-m-d", strtotime('-'.($i+1).' days', $startDate));
            $totals[$date] += $totals[$pdate];
        }

        
        return $totals;
    }
}