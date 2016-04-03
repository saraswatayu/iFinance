<?php

namespace App;

use App\Account;
use App\Transaction;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Log;
use Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get all of the accounts for the user.
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
    
    public function importAccount($csv) 
    {
        $user = Auth::user();
        $first_line = true;
        
        foreach ($csv as $line) {
            $values = [];
            $values = str_getcsv(trim($line));

            if (($first_line && count($values) != 3) || (!$first_line && count($values) != 4)) {
                return false; 
            }

            if ($first_line) {
                list($category, $name, $balance) = $values;
                
                $account = new Account;
                $account->email = $user->email;
                $account->category = $category;
                $account->name = $name;
                $account->balance = $balance;
                $account->selected = true;
                $account->save();
                
                $first_line = false;
            } else {
                list($category, $merchant, $price, $time) = $values;
                
                $transaction = new Transaction;
                $transaction->account_id = $account->id;
                $transaction->email = $user->email;
                $transaction->category = $category;
                $transaction->merchant = $merchant;
                $transaction->price = $price;
                $transaction->time = date_create($time);
                $transaction->save();
            }
        }

        return true;
    }
}