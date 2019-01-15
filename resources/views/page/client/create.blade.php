@extends('layouts.master')

@section('content')
    <div class="container">
        <h3>Create Client</h3>
        <form class="form" action="{{ route('client.store') }}" method="POST">
            <div class="row mb-3">
                <div class="col">
                    <input type="text" class="form-control" placeholder="First name *" name="first_name" required>
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Last name *" name="last_name" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Patronymic name" name="patronymic_name">
                </div>
                <div class="col">
                    <input type="email" class="form-control" placeholder="Email *" name="email" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@stop