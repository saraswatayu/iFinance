@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Accounts
                </div>

                <div class="panel-body">
                    @if (count($accounts) > 0)
                        <table class="table table-striped task-table">
                            <tbody>
                                @foreach ($accounts as $account)
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
                            </tbody>
                        </table>
                    @else
                        No accounts found.
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Graph</div>

                <div class="panel-body">
                    <h1>Selected Accounts</h1>
                    @foreach ($accounts as $account)
                        @if ($account->selected)
                            {{ $account->selected ? $account->name : "" }}
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
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