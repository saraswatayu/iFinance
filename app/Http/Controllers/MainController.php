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

use Gbrock\Table\Table;

use Khill\Lavacharts\Lavacharts;

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
        // table
        $rows = $this->transactions->forAccountsPaginated($this->accounts->forUser($request->user()));
        $table = Table::create($rows, ['merchant', 'category']);
        $table->addColumn('price', 'Price', function($model) {
            return '$'.number_format($model->price, 2);
        });
        $table->addColumn('time', 'Time', function($model) {
            $date = date_create($model->time);
            return date_format($date, "m/d/y");
        });
        
        // line chart
        $temperatures = \Lava::DataTable();
        $temperatures->addDateColumn('Date')
                     ->addNumberColumn('Max Temp')
                     ->addNumberColumn('Mean Temp')
                     ->addNumberColumn('Min Temp')
                     ->addRow(['2014-10-1',  67, 65, 62])
                     ->addRow(['2014-10-2',  68, 65, 61])
                     ->addRow(['2014-10-3',  68, 62, 55])
                     ->addRow(['2014-10-4',  72, 62, 52])
                     ->addRow(['2014-10-5',  61, 54, 47])
                     ->addRow(['2014-10-6',  70, 58, 45])
                     ->addRow(['2014-10-7',  74, 70, 65])
                     ->addRow(['2014-10-8',  75, 69, 62])
                     ->addRow(['2014-10-9',  69, 63, 56])
                     ->addRow(['2014-10-10', 64, 58, 52])
                     ->addRow(['2014-10-11', 59, 55, 50])
                     ->addRow(['2014-10-12', 65, 56, 46])
                     ->addRow(['2014-10-13', 66, 56, 46])
                     ->addRow(['2014-10-14', 75, 70, 64])
                     ->addRow(['2014-10-15', 76, 72, 68])
                     ->addRow(['2014-10-16', 71, 66, 60])
                     ->addRow(['2014-10-17', 72, 66, 60])
                     ->addRow(['2014-10-18', 63, 62, 62]);
        \Lava::LineChart('Temps', $temperatures, [
            'title' => 'Weather in October'
        ]);
        
        return view('dashboard.index', [
            'accounts' => $this->accounts->forUser($request->user()),
            'table' => $table,
            'month_transactions' => $this->transactions->monthTransactions(),
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
        
        return redirect('/dashboard?sort=time&dir=desc');
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
        
        if (!file_exists($_FILES['csv']['tmp_name']) || !is_uploaded_file($_FILES['csv']['tmp_name'])) {
            $success = false;
            $message = 'Please upload a valid .CSV file!';
        } else {
            $csv = file($_FILES['csv']['tmp_name']);
            $success = $user->importAccount($csv);
        }

        if ($success) {
            $message = "Account import complete!";
            
            $request->session()->flash('message', $message); 
            $request->session()->flash('alert-class', 'alert-success');
            
            return redirect('/dashboard?sort=time&dir=desc');
        } else {
            $message = "Account import failed.";
            
            $request->session()->flash('message', $message); 
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
        
        return redirect('/dashboard?sort=time&dir=desc');
    }
    
    /**
     * Add a budget.
     *
     * @param  Request  $request
     * @return Response
     */
    public function addBudget(Request $request)
    {
        $success = true;
        $message = "Budget added successfully!";
        
        if (isset($request->category)) {
            if (!$this->budgets->isUnique($request->category)) {
                $success = false;
                $message = "A budget for that category already exists!";
            }
        } else {
            $success = false;
            $message = "Please fill in all information.";
        }
        
        if (isset($request->limit)) {
            if (!is_numeric($request->limit)) {
                $success = false;
                $message = "Please enter a valid number.";
            }
        } else {
            $success = false;
            $message = "Pelase fill in all information.";
        }
        
        if ($success) {
            $budget = new Budget;
            $budget->email = $request->user()->email;
            $budget->category = $request->category;
            $budget->limit = $request->limit;
            $budget->save();
            
            $request->session()->flash('message', $message); 
            $request->session()->flash('alert-class', 'alert-success');
            
            return redirect('/dashboard?sort=time&dir=desc');
        } else {
            $request->session()->flash('message', $message); 
            $request->session()->flash('alert-class', 'alert-danger');
            
            return back();
        }
    }
    
    /**
     * Remove a budget.
     *
     * @param  Request  $request
     * @param  Account  $account
     * @return Response
     */
    public function removeBudget(Request $request, Budget $budget)
    {
        $budget->delete();
        
        return redirect('/dashboard?sort=time&dir=desc');
    }
}