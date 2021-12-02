<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Companies;

class HomeController extends Controller
{
    public function index()
    {
        $companies = Companies::get();
        return view('home.index', ['companies' => $companies]);
    }
}
