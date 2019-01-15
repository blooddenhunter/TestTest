@extends('layouts.master')

@section('content')
    <div class="container">
        <h3 class="text-center">Transaction report</h3>
        <div class="row mt-3 mb-3">
            <form action="{{ route('transaction.report') }}" method="GET">
                <div class="form-row">
                    <div class="col">
                        <input class="form-control" type="text" id="from" name="from" placeholder="From"  value="{{ Request::get('from') }}">
                    </div>
                    <div class="col">
                        <input class="form-control" type="text" id="to" name="to" placeholder="To" value="{{ Request::get('to') }}">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">New users</th>
                    <th scope="col">Active Users</th>
                    <th scope="col">Count of payments</th>
                    <th scope="col">Sum of payments</th>
                    <th scope="col">Count of refunds</th>
                    <th scope="col">Sum of refunds</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <th scope="row">{{ date('d-m-Y', strtotime($transaction->date)) }}</th>
                        <th scope="row">{{ $transaction->new }}</th>
                        <th scope="row">{{ $transaction->regular }}</th>
                        <th scope="row">{{ $transaction->count }}</th>
                        <th scope="row">{{ $transaction->sum }}</th>
                        <th scope="row">{{ $transaction->countRefund }}</th>
                        <th scope="row">{{ $transaction->sumRefund }}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop