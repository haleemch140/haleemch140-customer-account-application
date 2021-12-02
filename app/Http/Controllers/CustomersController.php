<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Customers;
use App\Models\ledger;

class CustomersController extends Controller
{

    /**
     * Handle response after user authenticated
     * List of all customers
     */
    public function index()
    {
        $customers =Customers::query()->leftJoin('ledger', 'ledger.customerId', '=', 'customer.CustID')
            ->select('customer.*')
            ->selectRaw('SUM(money_credit - money_debit) as balance')
            ->groupby('customer.CustID')
            ->get();
        return view('customers.index', ['customers' => $customers]);
    }

    /**
     * Handle response after user authenticated
     * List of selected company customers
     */
    public function view($id)
    {
        Session::put('company_id', $id);	// Set company id in session variable

        $customers =Customers::query()->leftJoin('ledger', 'ledger.customerId', '=', 'customer.CustID')
            ->select('customer.*')
            ->selectRaw('SUM(money_credit - money_debit) as balance')
            ->groupby('customer.CustID')
            ->where('customer.CompanyId', $id)
            ->get();

        return view('customers.index', ['customers' => $customers]);
    }

    /**
     * Handle response after user authenticated
     * List of selected customer ledger report
     */
    public function ledger($id)
    {
        $ledgers =ledger::where('customerId', $id)
            ->orderBy('payment_date','ASC')
            ->get();

        $customer =Customers::where('CustID', $id)
            ->get();

        return view('ledger.index', ['ledger' => $ledgers, 'customer'=>$customer]);
    }
}
