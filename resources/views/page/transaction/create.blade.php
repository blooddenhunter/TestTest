@extends('layouts.master')

@section('content')
    <div class="container">
        <h3>Pay money</h3>
        <form class="form" action="{{ route('transaction.store') }}" method="POST">
            <div class="row mb-3">
                <div class="col">
                    <input type="number" class="form-control" placeholder="Sum *" name="sum" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <input type="radio" name="type" value="default" checked>
                    <label for="contactChoice1">Default</label>

                    <input type="radio" name="type" value="refund">
                    <label for="contactChoice2">Refund</label>
                </div>
            </div>
            <input type="hidden" name="client_id" value="{{ $clientId }}">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@stop