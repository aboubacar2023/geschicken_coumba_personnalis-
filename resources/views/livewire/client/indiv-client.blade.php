<div>
    <div class="cote-menu">
        <div class="nav-haut">
            <div><h4 style="padding-left: 3px;"></i>Client</h4></div>
            <div style="padding-right: 10px;"><h5>DALLA DISTRIBUTIONS</h5></div>
        </div>
        <div class="contenu">
            <div class="pb-4">
                <button type="button" class="btn" style="background-color: #821435; color: white;"  ><a href="{{route('client.apercu')}}">Retour</a></button>
                <button type="button" class="btn" style="background-color: #821435; color: white;" data-bs-toggle="modal" data-bs-target="#commandeModal" data-bs-whatever="@mdo" >Commande</button>
                <button type="button" class="btn" style="background-color: #821435; color: white;" data-bs-toggle="modal" data-bs-target="#paiementModal" data-bs-whatever="@mdo" >Paiement</button>
            </div>
            
            <h2>Le Client {{$client->prenom}} {{$client->nom}}</h2>
            <div class="col-md-3">
                <label class="col-form-label">Solde Créditeur</label>
                <input type="text" class="form-control" placeholder="{{number_format($solde, 0, '', ' ')}} FCFA" readonly>
            </div>
            <div class="tableau pt-4">
                <div class="titre">
                    <div><h4>Historique des opérations</h4></div>
                    <div>
                        <input type="text" wire:model.live="query" placeholder="Recherche" class="form-control">
                    </div>
                </div>
                <div>
                    <table class="table table-striped table-bordered" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date Commande</th>
                                <th>Montant</th>
                                <th>Reste Paiement</th>
                                <th>Date Règlement</th>
                                <th>Action</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr wire:key="{{$data->id}}">
                                    <td>{{$data->id_commande}}</td>
                                    @php
                                        $new_format = new DateTime($data->date_commande);
                                    @endphp
                                    <td>{{$new_format->format('d-m-Y')}}</td>
                                    <td>{{number_format($data->montant_commande, 0, '', ' ')}} FCFA</td>
                                    <td>{{number_format($data->montant_non_regle_type, 0, '', ' ')}} FCFA</td>
                                    @if ($data->date_reglement)
                                        @php
                                            $format = new DateTime($data->date_reglement)
                                        @endphp
                                        <td>{{$format->format('d-m-Y')}}</td>
                                    @else
                                        <td>---</td>
                                    @endif
                                    <td>
                                        <button type="button" wire:click="seeCommandeIndiv({{$data->id}})" class="btn btn-warning" style="color: white;" data-bs-toggle="modal" data-bs-target="#seeCommandeModal" data-bs-whatever="@mdo">Voir</i></button>
                                        @if (!$data->date_reglement)
                                            <button type="button" wire:click="deleteCommande({{$data->id}})" class="btn" style="background-color: #821435; color: white" data-bs-toggle="modal" data-bs-target="#supressionModal" data-bs-whatever="@mdo">Supprimer</button>
                                        @endif
                                    </td>
                                    @if ($data->date_reglement)
                                        <td><button class="btn td_client" style="background-color: green"></button></td>  
                                    @else
                                    <td><button class="btn td_client" style="background-color: red"></button></td>
                                    @endif
                                </tr> 
                            @endforeach
                        </tbody>
                    </table> 
                    {{ $datas->links() }}
                    <span class="loader" wire:loading></span>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.client.indiv-client-modal')
</div>
