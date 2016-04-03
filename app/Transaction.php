<?php

namespace App;

use App\Account;
use Illuminate\Database\Eloquent\Model;
use Gbrock\Table\Traits\Sortable;

class Transaction extends Model
{
    use Sortable;
    
    protected $sortable = ['merchant', 'category', 'price', 'time'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'int'
    ];

    /**
     * Get the account that owns the transaction.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}