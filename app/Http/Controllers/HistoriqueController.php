<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HistoriqueController extends Controller
{
    public function index() : View {
        return view('historique.histo');
    }
}
