<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\User;
use App\Budget;
use App\Account;
use App\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\BudgetRepository;

class MainController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var AccountRepository
     */
    protected $accounts;
    protected $transactions;
    protected $budgets;
    
    public function __construct(AccountRepository $accounts, TransactionRepository $transactions, BudgetRepository $budgets) {
        $this->middleware('auth');
        
        $this->accounts = $accounts;
        $this->transactions = $transactions;
        $this->budgets = $budgets;
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
            'transactions' => $this->transactions->forAccounts($this->accounts->forUser($request->user()), 'time'),
            'budgets' => $this->budgets->forUser($request->user()),
        ]);
    }
    
    /**
     * Select an account.
     *
     * @param  Request  $request
     * @param  Account  $account
     * @return Response
     */
    public function selectAccount(Request $request, Account $account)
    {
        $account->selected = !$account->selected;
        $account->save();
        
        return redirect('/dashboard');
    }
    
    /**
     * Add an account.
     *
     * @param  Request  $request
     * @return Response
     */
    public function addAccount(Request $request)
    {   
        $user = $request->user();
        
        $success = true;
        $message = "Account import complete!";
        
        if (!file_exists($_FILES['csv']['tmp_name']) || !is_uploaded_file($_FILES['csv']['tmp_name'])) {
            $success = false;
            $message = 'Error: CSV file required.';
        } else {
            $csv = file($_FILES['csv']['tmp_name']);
            $success = $user->importAccount($csv);
        }

        if ($success) {
            $request->session()->flash('message', 'Import Succesful!'); 
            $request->session()->flash('alert-class', 'alert-success');
            
            return redirect('/dashboard');
        } else {
            $request->session()->flash('message', 'Import Failed.'); 
            $request->session()->flash('alert-class', 'alert-danger');
            
            return back();
        }
    }
    
    /**
     * Remove an account.
     *
     * @param  Request  $request
     * @param  Account  $account
     * @return Response
     */
    public function removeAccount(Request $request, Account $account)
    {
        $transactions = $this->transactions->forAccount($account);
        foreach ($transactions as $transaction) {
            $transaction->delete();
        }
        $account->delete();
        
        return redirect('/dashboard');
    }
    
    public function addBudget(Request $request)
    {
        $budget = new Budget;
        $budget->email = $request->user()->email;
        $budget->category = $request->category;
        $budget->limit = $request->limit;
        $budget->save();
        
        return redirect('/dashboard');
    }
}