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

use Session;
use Input;

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
        
        // LINE CHART
        $startDate = strtotime(Input::get('start', date("Y-M-d")));
        $days = Input::get('days', 90);
        
        $totals = \Lava::DataTable();
        $totals->addDateColumn('Date');

        // selected accounts
        $selected = $this->accounts->selectedForUser($request->user());
        foreach ($selected as $account) {
            $totals->addNumberColumn($account->name);
        }

        $dailyTotals = array();
        foreach ($selected as $account) {
            $dailyTotals[] = $this->transactions->previousTransactionsBetweenDates($account, $startDate, $days);
        }
        
        for ($i = $days; $i >= 0; $i--) {
            $d = date("Y-m-d", strtotime('-'.$i.' days', $startDate));
            
            $row = array();
            $row[] = $d;
            foreach ($dailyTotals as $daily) {
                $row[] = $daily[$d];
            }
            
            $totals->addRow($row);   
        }
        
        $historyCategory = Input::get('history');
        $history = $this->transactions->monthlyTotalsForCategory($historyCategory);
        $historicalBudget = $this->budgets->forCategory($historyCategory);
        $historicalLimit = $historicalBudget ? $historicalBudget->limit : 1;

        \Lava::LineChart('Monthly Reports', $totals, [
            'hAxis' => ['title' => 'Date'],
            'vAxis' => ['title' => 'Spending ($)']
        ]);
        
        return view('dashboard.index', [
            'accounts' => $this->accounts->forUser($request->user()),
            'table' => $table,
            'month_transactions' => $this->transactions->monthTransactions(),
            'budgets' => $this->budgets->forUser($request->user()),
            'historicTotals' => $history,
            'historicLimit' => $historicalLimit,
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
    
    public function showHistory(Request $request, $category)
    {
        return redirect('/dashboard?history='.$category.'&showModal=true');
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
    
    public function setDates(Request $request) {
        Session::put('startDate', $request->startDate);
        Session::put('time', $request->days);

        return redirect('/dashboard?sort=time&dir=desc');
    }
}