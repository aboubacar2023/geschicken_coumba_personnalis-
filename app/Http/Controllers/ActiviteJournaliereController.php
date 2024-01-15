<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ActiviteJournaliereController extends Controller
{
    public function index() : View {
        return view('activite.journaliere');
    }
}
