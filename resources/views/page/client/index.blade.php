@extends('layouts.master')

@section('content')
    <div class="container">
        <h3 class="text-center">Clients</h3>
        <div class="row mt-3 mb-3">
            <a class="btn btn-outline-primary" href="{{ route('client.create') }}">Create Client</a>
            <a class="btn btn-outline-primary ml-2" href="{{ route('transaction.report') }}">Transaction report</a>
        </div>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Patronymic Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Balance ($)</th>
                    <th scope="col">Actions</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $client)
                    <tr>
                        <th scope="row">{{ $client->id }}</th>
                        <td>{{ $client->first_name }}</td>
                        <td>{{ $client->last_name }}</td>
                        <td>{{ $client->patronymic_name }}</td>
                        <td>{{ $client->email }}</td>
                        <td class="status">
                            <span class="{{ $client->status }}">{{ $client->status }}</span>
                        </td>
                        <td>{{ $client->balance }}</td>
                        <td>
                            @if($client->status !== 'locked')
                                <div class="actions">
                                    <a class="btn" href="{{ route('transaction.create', ['clientId' => $client->id]) }}" data-placement="top" title="Pay money">
                                        <i class="fas fa-money-bill"></i>
                                    </a>
                                    <a href="{{ route('client.locked', ['clientId' => $client->id]) }}" class="btn ban" data-id="{{ $client->id }}" data-placement="top" title="Ban">
                                        <i class="fas fa-ban"></i>
                                    </a>
                                </div>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-primary transaction-button" href="#collapseTransaction{{ $client->id }}" data-id="{{ $client->id }}">
                                Transaction
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" style="display: none;">
                            <div class="collapse" id="collapseTransaction{{ $client->id }}">

                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $clients->links() }}
        </div>
    </div>
@stop