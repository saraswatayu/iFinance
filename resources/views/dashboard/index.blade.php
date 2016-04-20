@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if(Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ Session::get('message') }}
            </div>
        @endif
    </div>
    
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
                        
                        <hr/>
                        
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
                            <th colspan="4">Credit Cards</th>
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
                            <th colspan="4">Savings</th>
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
                                    <td class="table-text" colspan="4">No savings accounts found.</td>
                                </tr>
                            @endif
                        </tbody>
                        
                        <thead>
                            <th colspan="4">Loans</th>
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
                    <h3 class="panel-title pull-left">Monthly Budgets</h3>
                    <button type="submit" class="btn btn-default pull-right" data-toggle="modal" data-target="#addBudgetModal">
                        <i class="fa fa-btn fa-plus"></i>Add Budget
                    </button>
                    <div class="clearfix"></div>
                </div>
                
                @if (count($budgets) > 0)
                    <?php
                        $categoryTotals = [];
                        foreach ($month_transactions as $transaction) {
                            if (array_key_exists($transaction->category, $categoryTotals)) {
                                $categoryTotals[$transaction->category] += $transaction->price;
                            } else {
                                $categoryTotals[$transaction->category] = $transaction->price;
                            }
                        }
                    ?>

                    <table class="table table-hover">
                        <tbody>
                            @foreach ($budgets as $budget)
                                <?php
                                    if (!array_key_exists($budget->category, $categoryTotals)) {
                                        $categoryTotals[$budget->category] = 0;
                                    }

                                    $progressStyle = 'warning';
                                    $overage = floatval($categoryTotals[$budget->category]) / floatval($budget->limit);
                                    if ($overage > 1) {
                                        $progressStyle = 'danger';
                                        $overage = 1;
                                    } else if ($overage < 1) {
                                        $progressStyle = 'success';
                                    }
                                ?>

                                <tr>
                                    <td width="1">
                                        <form action="/budget/remove/{{ $budget->id }}" method="POST">
                                            {{ csrf_field() }}

                                            <button type="submit" class="trash-icon">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </form>
                                    </td>

                                    <td>
                                        <strong>{{ $budget->category }}</strong>

                                        <div class="progress">
                                            <div class="progress-bar progress-bar-{{ $progressStyle }}" role="progressbar" aria-valuenow="{{ $overage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $overage * 100 }}%;">
                                            </div>
                                        </div>

                                        <p>You've spent <span class="label label-{{ $progressStyle }}">${{ number_format($categoryTotals[$budget->category], 2) }}</span> of <strong>${{ number_format($budget->limit, 2) }}</strong>.</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="panel-body">
                        No budgets found.
                    </div>
                @endif
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
                        <!-- Include Date Range Picker -->
    <script type="text/javascript" src="http://cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap/latest/css/bootstrap.css" />

    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
                    <div id="reportrange" name="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                        <span></span> <b class="caret"></b>
                    </div>
                    
                    <script type="text/javascript">
                        $(function() {
                            function cb(start, end) {
                                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                            }
                            cb(moment().subtract(29, 'days'), moment());

                            $('#reportrange').daterangepicker({
                                ranges: {
                                   'Today': [moment(), moment()],
                                   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                   'This Month': [moment().startOf('month'), moment().endOf('month')],
                                   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                }
                            }, cb);
                        });
                    </script>
                </div>

                <div class="panel-body">
                    
                    
                    <br/>
                    <br/>
                    <div id="line-chart"></div>
                    @linechart('Monthly Reports', 'line-chart')
                </div>
            </div>
        
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Transactions</h3>
                </div>

                @if (count($table->getRows()) > 0)
                    {!! $table->render() !!}
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