<div>
    <div class="cote-menu">
        <div class="nav-haut">
            <div><h4 style="padding-left: 3px;">Client</h4></div>
            <div style="padding-right: 10px;"><h5>DALLA DISTRIBUTIONS</h5></div>
        </div>
        <div class="contenu">
            <div>
              <button type="button" class="btn" style="background-color: #821435; color: white;" data-bs-toggle="modal" data-bs-target="#nouveauModal" data-bs-whatever="@mdo" >Nouveau Client</button>
            </div>
            <h2>LES CLIENTS</h2>
            <div class="tableau pt-4">
                <div class="titre">
                    <div><h4>Liste des clients</h4></div>
                    <div>
                        <input type="text" wire:model.live="query" placeholder="Recherche" class="form-control">
                    </div>
                </div>
                <div>
                    <table class="table table-striped table-bordered" >
                        <thead>
                            <tr>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Societé</th>
                                <th>Adresse</th>
                                <th>Contact</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr wire:key="{{$client->id}}">
                                    <td>{{$client->prenom}}</td>
                                    <td>{{$client->nom}}</td>
                                    <td>{{$client->societe}}</td>
                                    <td>{{$client->adresse}}</td>
                                    <td>{{$client->contact}}</td>
                                    <td>
                                        @if ($client->nom !== 'DIVERS')
                                            <button type="button" wire:click="updateClient({{$client->id}})" class="btn btn-warning" style="color: white;" data-bs-toggle="modal" data-bs-target="#modificationModal" data-bs-whatever="@mdo">Modifier</button>
                                        @endif
                                        <button type="submit" class="btn" style="background-color: #821435; color: white;"><a href="{{route('client.individuel', ['id_client' => $client->id])}}">Voir</a></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $clients->links() }}
                    <span class="loader_recherche" wire:loading></span>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.client.client-modal')
</div>
