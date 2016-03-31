<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Account;
use App\Repositories\AccountRepository;

class MainController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $accounts;
    
    public function __construct(AccountRepository $accounts) {
        $this->middleware('auth');
        
        $this->accounts = $accounts;
    }
    
    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('dashboard.index', [
            'accounts' => $this->accounts->forUser($request->user()),
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