@extends('layouts.app-master')
<!-- Datatables CSS CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Datatables JS CDN -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Customer Statement (Ledger)</h4>
                                <a href="{{ url('/') }}/Customers/{{ session()->get('company_id') }}" class="btn btn-danger float-end">BACK</a>
                                <table class="table table-borderless">
                                    @foreach ($customer as $data)
                                    <tr>
                                        <td colspan="7"> <b>Customer Name: </b>{{$data->DisplayName}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7"> <b>Currency: </b>{{$data->Currency}}</td>
                                    </tr>
                                    <tr>
                                         <td colspan="7">Date From: <input type="text" id="min" name="min"></td>
                                    </tr>
                                    <tr>
                                         <td colspan="7">Date To <input type="text" id="max" name="max"></td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="card-body">

                                <table class="table table-bordered table-striped" id="customer_ledger">
                                    <thead>
                                    <tr>
                                        <th  style="display: none">Order ID</th>
                                        <th>Payment Date</th>
                                        <th>Reference No.</th>
                                        <th>Type</th>
                                        <th>Charged (credit)</th>
                                        <th>Paid (debit)</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $current_balance = 0;
                                        $balance = 0;
                                        $debit = '';
                                        $credit = '';
                                    @endphp
                                    @foreach ($ledger as $item)
                                       @php
                                           if($item->active == 1){
                                                $current_balance = $balance + $item->money_credit;
                                                $balance = $current_balance - $item->money_debit;
                                            }
                                            if($item->transaction_type ==  'Opening Balance'){
                                               $debit = '';
                                               $credit = '';
                                            }
                                            else{
                                                $debit = number_format((float) $item->money_debit, 2);
                                                $credit = number_format((float) $item->money_credit, 2);
                                            }

                                       @endphp
                                        <tr  class="{{ $item->active ==  '1' ? '' : 'text-decoration-line-through'}}">
                                            <td style="display: none">{{$item->Id}}</td>
                                            <td>{{ $item->transaction_type ==  'Opening Balance' ? '' : date('d/m/Y', strtotime($item->payment_date))}}</td>
                                            <td>{{ $item->transaction_type ==  'Opening Balance' ? '' : $item->transaction_reference }}</td>
                                            <td>{{ $item->transaction_type }}</td>
                                            <td>{{ $credit ==  '0.00' ? '' : $credit}}</td>
                                            <td>{{ $debit ==  '0.00' ? '' : $debit}}</td>
                                            <td>{{number_format((float) $balance, 2)}}</td>
                                            @if($item->active == 1)
                                                <td> {{ $item->transaction_type ==  'Opening Balance' ? '' : 'Active'}} </td>
                                            @else
                                                <td>Deleted </td>
                                            @endif

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
    <!-- Script -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#customer_ledger').DataTable();
        } );
    </script>
@endsection
