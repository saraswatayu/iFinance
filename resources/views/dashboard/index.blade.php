@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Accounts</h3>
                </div>

                @if (count($accounts) > 0)
                    <table class="table table-hover">
                        <thead>
                            <th class="warning">Credit Cards</th>
                            <th class="warning"></th>
                            <th class="warning"></th>
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
                                        <td class="table-text"><div>{{ $account->name }}</div></td>
                                        <td class="table-text"><div>${{ $account->balance }}</div></td>

                                        <!-- Task Delete Button -->
                                        <td>
                                            <form action="/account/{{ $account->id }}" method="POST">
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
                                    <td class="table-text">No credit cards found.</td>
                                </tr>
                            @endif
                        </tbody>
                        
                        <thead>
                            <th class="warning">Savings</th>
                            <th class="warning"></th>
                            <th class="warning"></th>
                        </thead>
                        <tbody>
                            @if (count($savings) > 0)
                                @foreach ($savings as $account)
                                    <tr>
                                        <td class="table-text"><div>{{ $account->name }}</div></td>
                                        <td class="table-text"><div>${{ $account->balance }}</div></td>

                                        <!-- Task Delete Button -->
                                        <td>
                                            <form action="/account/{{ $account->id }}" method="POST">
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
                                    <td class="table-text">No savings found.</td>
                                </tr>
                            @endif
                        </tbody>
                        
                        <thead>
                            <th class="warning">Loans</th>
                            <th class="warning"></th>
                            <th class="warning"></th>
                        </thead>
                        <tbody>
                            @if (count($loans) > 0)
                                @foreach ($loans as $account)
                                    <tr>
                                        <td class="table-text"><div>{{ $account->name }}</div></td>
                                        <td class="table-text"><div>${{ $account->balance }}</div></td>

                                        <!-- Task Delete Button -->
                                        <td>
                                            <form action="/account/{{ $account->id }}" method="POST">
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
                                    <td class="table-text">No loans found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Graph
                </div>

                <div class="panel-body">
                    <h1>Selected Accounts</h1>
                    @foreach ($accounts as $account)
                        @if ($account->selected)
                            {{ $account->selected ? $account->name : "" }}
                        @endif
                    @endforeach
                </div>
            </div>
        
            <div class="panel panel-default">
                <div class="panel-heading">Transactions</div>

                <div class="panel-body">
                    @if (count($transactions) > 0)
                        <table class="table table-striped task-table">
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
                                        <td class="table-text"><div>${{ $transaction->price }}</div></td>
                                        <td class="table-text"><div>{{ $transaction->time }}</div></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        No transactions found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection