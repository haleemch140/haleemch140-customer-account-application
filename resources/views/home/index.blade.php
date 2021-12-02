@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
        <h1>Dashboard</h1>
        <p class="lead">Only authenticated users can access this section.</p>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Recent Companies list</h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Country</th>
                                        <th>City</th>
                                        <th>Currency</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($companies as $company)
                                        <tr>
                                            <td>{{ $company->Id }}</td>
                                            <td><a href="{{ url('Customers/'.$company->Id) }}">{{ $company->org_name }}</a></td>
                                            <td>{{ $company->country }}</td>
                                            <td>{{ $company->city }}</td>
                                            <td>{{ $company->currency }}</td>
                                            <td>
                                                <a href="{{ url('Customers/'.$company->Id) }}" class="btn btn-primary btn-sm">View Customers</a>
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
        <h1>Homepage</h1>
        <p class="lead">Your viewing the home page. Please login to view the restricted data.</p>
        @endguest
    </div>
@endsection
