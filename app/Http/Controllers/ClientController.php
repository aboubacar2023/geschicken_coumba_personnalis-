<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index() : View {
        return view('client.apercu_client');
    }

    public function individuel($id_client) : View{
        return view('client.indiv_client', [
            'id_client' => $id_client
        ]);
    }
}
