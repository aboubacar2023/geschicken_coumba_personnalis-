<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CaisseController extends Controller
{
    public function index() : View{
        return view('caisse.apercu_caisse');
    }
}
