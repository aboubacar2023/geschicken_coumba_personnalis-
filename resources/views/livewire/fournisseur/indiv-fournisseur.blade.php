<div>
    <div class="cote-menu">
        <div class="nav-haut">
            <div><h4 style="padding-left: 3px;"><i class="fa-solid fa-truck-arrow-right" style="padding-right: 7px"></i>fournisseur</h4></div>
            <div style="padding-right: 10px;"><h5>DALLA DISTRIBUTIONS</h5></div>
        </div>
        <div class="contenu">
            <div class="pb-3">
                <button type="button" class="btn" style="background-color: #821435; color: white;"  ><a href="{{route('fournisseur.apercu')}}"><i class="fa-solid fa-delete-left icon"></i>Retour</a></button>
                <button type="button" class="btn" style="background-color: #821435; color: white;" data-bs-toggle="modal" data-bs-target="#receptionModal" data-bs-whatever="@mdo" ><i class="fa-solid fa-plus icon"></i>Reception</button>
                <button type="button" class="btn" style="background-color: #821435; color: white;" data-bs-toggle="modal" data-bs-target="#reglementModal" data-bs-whatever="@mdo" ><i class="fa-solid fa-hand-holding-dollar icon"></i>Règlement</button>
            </div>
            <h2>Le Fournisseur {{$fournisseur->prenom}} {{$fournisseur->nom}}</h2>
            <div class="col-md-3">
                <label class="col-form-label">Solde Débiteur</label>
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
                                <th>Date Reception</th>
                                <th>Quantité</th>
                                <th>Prix Unitaire</th>
                                <th>Montant</th>
                                <th>Date Règlement</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($receptions as $reception)
                                <tr wire:key="{{$reception->id}}">
                                    <td>{{$reception->id}}</td>
                                    @php
                                        $reception_date = new DateTime($reception->created_at)
                                    @endphp
                                    <td>{{$reception_date->format('m-d-Y')}}</td>
                                    <td>{{$reception->quantite}} KG</td>
                                    <td>{{number_format($reception->prix_unitaire, 0, '', ' ')}} FCFA</td>
                                    <td>{{number_format($reception->montant, 0, '', ' ')}} FCFA</td>
                                    @if ($reception->date_reglement)
                                        @php
                                            $reglement_date = new DateTime($reception->date_reglement)
                                        @endphp
                                        <td>{{$reglement_date->format('m-d-Y')}}</td>
                                    @else
                                        <td>---</td>
                                    @endif
                                    <td>
                                        @if ($reception->reglement)
                                            Réglé
                                        @else
                                            Non réglé
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $receptions->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.fournisseur.indiv-fournisseur-modal')
</div>
