<div>
    <div class="cote-menu">
        <div class="nav-haut">
            <div><h4 style="padding-left: 3px;"><i class="fa-solid fa-truck-arrow-right" style="padding-right: 7px"></i>fournisseur</h4></div>
            <div style="padding-right: 10px;"><h5>DALLA DISTRIBUTIONS</h5></div>
        </div>
        <div class="contenu">
            <div>
              <button type="button" class="btn" style="background-color: #821435; color: white;" data-bs-toggle="modal" data-bs-target="#nouveauModal" data-bs-whatever="@mdo" ><i class="fa-solid fa-user-plus icon"></i>Nouveau Fournisseur</button>
            </div>
            <h2>LES FOURNISSEURS</h2>
            <div class="tableau pt-4">
                <div class="titre">
                    <div><h4>Liste des fournisseurs</h4></div>
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
                            @foreach ($fournisseurs as $fournisseur)
                                <tr wire:key="{{$fournisseur->id}}">
                                    <td>{{$fournisseur->prenom}}</td>
                                    <td>{{$fournisseur->nom}}</td>
                                    <td>{{$fournisseur->societe}}</td>
                                    <td>{{$fournisseur->adresse}}</td>
                                    <td>{{$fournisseur->contact}}</td>
                                    <td>
                                        <button type="button" wire:click="updateFournisseur({{$fournisseur->id}})" class="btn btn-warning" style="color: white;" data-bs-toggle="modal" data-bs-target="#modificationModal" data-bs-whatever="@mdo"><i class="fa-solid fa-pen-nib"></i></button>
                                        <button type="submit" class="btn" style="background-color: #821435; color: white;"><a href="{{route('fournisseur.individuel', ['fournisseur_id' => $fournisseur->id])}}"><i class="fa-solid fa-eye"></i></a></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $fournisseurs->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.fournisseur.fournisseur-modal')
</div>
