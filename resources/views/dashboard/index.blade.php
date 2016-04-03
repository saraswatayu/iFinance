@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Account</h3>
                </div>
                
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/account/add" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        
                        <input type="file" name="csv" id="fileToUpload">
                        <br>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Account
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Accounts</h3>
                </div>

                @if (count($accounts) > 0)
                    <table class="table table-hover">
                        <thead>
                            <th class="warning" colspan="4">Credit Cards</th>
                        </thead>
                        <tbody>
                            <?php 
                                $credit_cards = [];
                                $savings = [];
                                $loans = [];
                            
                                foreach ($accounts as $account) {
                                    if ($account->category == "Credit Card")
                                        $credit_cards[] = $account;
                                    else if ($account->category == "Savings")
                                        $savings[] = $account;
                                    else if ($account->category == "Loans")
                                        $loans[] = $account;
                                }
                            ?>
                            @if (count($credit_cards) > 0)
                                @foreach ($credit_cards as $account)
                                    <tr>
                                        <td width="1">
                                            <form action="/account/remove/{{ $account->id }}" method="POST">
                                                {{ csrf_field() }}
                                                
                                                <button type="submit" class="trash-icon">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </form>
                                        </td>
                                        
                                        <td class="table-text" width="80%"><div>{{ $account->name }}</div></td>
                                        <td class="table-text" width="10%"><div>${{ number_format($account->balance, 2) }}</div></td>

                                        <td width="1">
                                            <form action="/account/select/{{ $account->id }}" method="POST">
                                                {{ csrf_field() }}

                                                @if ($account->selected)
                                                    <input type="checkbox" value="" onclick="this.form.submit();" checked>
                                                @else
                                                    <input type="checkbox" value="" onclick="this.form.submit();">
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="table-text" colspan="4">No credit cards found.</td>
                                </tr>
                            @endif
                        </tbody>
                        
                        <thead>
                            <th class="warning" colspan="4">Savings</th>
                        </thead>
                        <tbody>
                            @if (count($savings) > 0)
                                @foreach ($savings as $account)
                                    <tr>
                                        <td width="1">
                                            <form action="/account/remove/{{ $account->id }}" method="POST">
                                                {{ csrf_field() }}
                                                
                                                <button type="submit" class="trash-icon">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </form>
                                        </td>
                                        
                                        <td class="table-text" width="80%"><div>{{ $account->name }}</div></td>
                                        <td class="table-text" width="10%"><div>${{ number_format($account->balance, 2) }}</div></td>

                                        <td width="1">
                                            <form action="/account/select/{{ $account->id }}" method="POST">
                                                {{ csrf_field() }}

                                                @if ($account->selected)
                                                    <input type="checkbox" value="" onclick="this.form.submit();" checked>
                                                @else
                                                    <input type="checkbox" value="" onclick="this.form.submit();">
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="table-text" colspan="4">No savings found.</td>
                                </tr>
                            @endif
                        </tbody>
                        
                        <thead>
                            <th class="warning" colspan="4">Loans</th>
                        </thead>
                        <tbody>
                            @if (count($loans) > 0)
                                @foreach ($loans as $account)
                                    <tr>
                                        <td width="1">
                                            <form action="/account/remove/{{ $account->id }}" method="POST">
                                                {{ csrf_field() }}

                                                <button type="submit" class="trash-icon">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </form>
                                        </td>
                                        
                                        <td class="table-text" width="80%"><div>{{ $account->name }}</div></td>
                                        <td class="table-text" width="10%"><div>${{ number_format($account->balance, 2) }}</div></td>

                                        <td width="1">
                                            <form action="/account/select/{{ $account->id }}" method="POST">
                                                {{ csrf_field() }}

                                                @if ($account->selected)
                                                    <input type="checkbox" value="" onclick="this.form.submit();" checked>
                                                @else
                                                    <input type="checkbox" value="" onclick="this.form.submit();">
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="table-text" colspan="4">No loans found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endif
            </div>
            
            <!-- Budget -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title pull-left">Budget</h3>
                    <button type="submit" class="btn btn-default pull-right" data-toggle="modal" data-target="#addBudgetModal">
                        <i class="fa fa-btn fa-plus"></i>Add Budget
                    </button>
                    <div class="clearfix"></div>
                </div>
                
                <div class="panel-body">
                    @if (count($budgets) > 0)
                        <?php
                            $categoryTotals = [];
                            foreach ($transactions as $transaction) {
                                if (array_key_exists($transaction->category, $categoryTotals)) {
                                    $categoryTotals[$transaction->category] += $transaction->price;
                                } else {
                                    $categoryTotals[$transaction->category] = $transaction->price;
                                }
                            }
                        ?>
                    
                        @foreach ($budgets as $budget)
                            <?php
                                if (!array_key_exists($budget->category, $categoryTotals)) {
                                    $categoryTotals[$budget->category] = 0;
                                }
                            ?>
                    
                            {{ $budget->category }}
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{ $categoryTotals[$budget->category] / $budget->limit }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $categoryTotals[$budget->category] / $budget->limit }}%;">
                                </div>
                            </div>
                        @endforeach
                    @else
                        No budgets found.
                    @endif
                </div>
            </div>
            
            <!-- Budget Modal -->
            <div class="modal fade" id="addBudgetModal" tabindex="-1" role="dialog" 
                 aria-labelledby="addBudgetModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" 
                               data-dismiss="modal">
                                   <span aria-hidden="true">&times;</span>
                                   <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title" id="addBudgetModalLabel">
                                Add Budget
                            </h4>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form method="POST" action="/budget/add">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="budget-category">Category</label>
                                    <input type="text" class="form-control" name="category" id="budget-category" placeholder=""/>
                                </div>
                                <div class="form-group">
                                    <label for="budget-limit">Limit</label>
                                    <input type="number" class="form-control" name="limit" id="budget-limit" placeholder=""/>
                                </div>

                                <button type="submit" class="btn btn-default">Add Budget</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Graph</h3>
                </div>

                <div class="panel-body">
                    
                </div>
            </div>
        
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Transactions</h3>
                </div>

                @if (count($transactions) > 0)
                    <table class="table table-striped task-table">
                        <thead>
                            <th class="warning" colspan="4">December 31, 2014</th>
                        </thead>
                        <thead>
                            <tr>
                                <th>Merchant</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="table-text"><div>{{ $transaction->merchant }}</div></td>
                                    <td class="table-text"><div>{{ $transaction->category }}</div></td>
                                    <td class="table-text"><div>${{ number_format($transaction->price, 2) }}</div></td>
                                    <td class="table-text"><div>{{ date_format($transaction->time, "H:i") }}</div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="panel-body">
                        No transactions found.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection