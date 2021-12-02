@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Customers List</h4>
                                <a href="{{ url('/') }}" class="btn btn-danger float-end">BACK</a>
                            </div>
                            <div class="card-body">

                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Currency</th>
                                        <th>Country</th>
                                        <th>Balance</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td><a href="{{ url('Customers/'.$customer->CustID.'/ledger') }}">{{ $customer->DisplayName }}</a></td>
                                            <td>{{ $customer->Currency }}</td>
                                            <td>{{ $customer->Country }}</td>
                                            <td>{{ number_format((float) $customer->balance, 2) }}</td>
                                            <td>
                                                <a href="{{ url('Customers/'.$customer->CustID.'/ledger') }}" class="btn btn-primary btn-sm">View Ledger</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endauth

        @guest
        <h1>Customers</h1>
        <p class="lead">Your viewing the home page. Please login to view the restricted data.</p>
        @endguest
    </div>
@endsection
