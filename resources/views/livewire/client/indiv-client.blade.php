<div>
    <div class="cote-menu">
        <div class="nav-haut">
            <div><h4 style="padding-left: 3px;"><i class="fa-solid fa-people-group" style="padding-right: 7px"></i>Client</h4></div>
            <div style="padding-right: 10px;"><h5>DALLA DISTRIBUTIONS</h5></div>
        </div>
        <div class="contenu">
            <div class="pb-4">
                <button type="button" class="btn" style="background-color: #821435; color: white;"  ><a href="{{route('client.apercu')}}"><i class="fa-solid fa-delete-left icon"></i>Retour</a></button>
                <button type="button" class="btn" style="background-color: #821435; color: white;" data-bs-toggle="modal" data-bs-target="#commandeModal" data-bs-whatever="@mdo" ><i class="fa-solid fa-plus icon"></i>Commande</button>
                <button type="button" class="btn" style="background-color: #821435; color: white;" data-bs-toggle="modal" data-bs-target="#paiementModal" data-bs-whatever="@mdo" ><i class="fa-solid fa-money-check-dollar icon"></i>Paiement</button>
            </div>
            
            <h2>Le Client {{$client->prenom}} {{$client->nom}}</h2>
            <div class="col-md-3">
                <label class="col-form-label">Solde Créditeur</label>
                <input type="text" class="form-control" placeholder="{{number_format($solde, 0, '', ' ')}} FCFA" readonly>
            </div>
            <div class="tableau pt-4">
                <div class="titre">
                    <div><h4>Historique des opérations</h4></div>
                </div>
                <div>
                    <table class="table table-striped table-bordered" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date Commande</th>
                                <th>Montant Total</th>
                                <th>Date Règlement</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr wire:key="{{$data[0]}}">
                                    <td>{{$data[0]}}</td>
                                    @php
                                        $new_format = new DateTime($data[2]);
                                    @endphp
                                    <td>{{$new_format->format('d-m-Y')}}</td>
                                    <td>{{number_format($data[3], 0, '', ' ')}} FCFA</td>
                                    @if ($data[1])
                                        @php
                                            $format = new DateTime($data[1])
                                        @endphp
                                        <td>{{$format->format('d-m-Y')}}</td>
                                    @else
                                        <td>---</td>
                                    @endif
                                    <td>
                                        @if ($data[1])
                                           Réglé  
                                        @else
                                            Non réglé
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" wire:click="seeCommandeIndiv({{$data[0]}})" class="btn btn-warning" style="color: white;" data-bs-toggle="modal" data-bs-target="#seeCommandeModal" data-bs-whatever="@mdo"><i class="fa-solid fa-eye"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                     {{-- {{ $clients->links() --}} 
                </div>
            </div>
        </div>
    </div>
    @include('livewire.client.indiv-client-modal')
</div>
