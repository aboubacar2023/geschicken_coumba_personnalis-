@extends('base')

@section('content')
    @livewire('fournisseur.indiv-fournisseur', [
        'id_fournisseur' => $id_fournisseur
    ])
@endsection