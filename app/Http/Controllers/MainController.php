<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Account;
use App\Repositories\AccountRepository;
use App\Repositories\TransactionRepository;

class MainController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var AccountRepository
     */
    protected $accounts;
    protected $transactions;
    
    public function __construct(AccountRepository $accounts, TransactionRepository $transactions) {
        $this->middleware('auth');
        
        $this->accounts = $accounts;
        $this->transactions = $transactions;
    }
    
    /**
     * Display a list of all of the user's accounts.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('dashboard.index', [
            'accounts' => $this->accounts->forUser($request->user()),
            'transactions' => $this->transactions->forAccounts($this->accounts->forUser($request->user())),
        ]);
    }
    
    /**
     * Select an account.
     *
     * @param  Request  $request
     * @param  Account  $account
     * @return Response
     */
    public function select(Request $request, Account $account)
    {
        $account->selected = !$account->selected;
        $account->save();
        
        return redirect('/dashboard');
    }
}