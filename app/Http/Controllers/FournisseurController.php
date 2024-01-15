<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index() : View {
        return view('fournisseur.apercu_fournisseur');
    }

    public function individuel($id_fournisseur) : View {
        return view('fournisseur.indiv_fournisseur', [
            'id_fournisseur' => $id_fournisseur
        ]);
    }
}
