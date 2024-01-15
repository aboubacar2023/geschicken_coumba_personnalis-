<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index() : View {
        return view('stock.apercu_stock');
    }
}
