@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <!-- Current Tasks -->
            @if (count($accounts) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Accounts
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Account</th>
                                <th>&nbsp;</th>
                            </thead>
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
                    </div>
                </div>
            @endif
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
    </div>
</div>
@endsection