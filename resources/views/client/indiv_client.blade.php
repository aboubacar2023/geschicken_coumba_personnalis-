@extends('base')

@section('content')
    @livewire('client.indiv-client', [
        'id_client' => $id_client
    ])
@endsection