<div>
    <div class="cote-menu">
        <div class="nav-haut">
            <div><h4 style="padding-left: 3px;"><i class="fa-solid fa-cash-register" style="padding-right: 7px"></i>Caisse</h4></div>
            <div style="padding-right: 10px;"><h5>DALLA DISTRIBUTIONS</h5></div>
        </div>
        <div class="contenu">
            <h2>Situation de la Caisse</h2>
            <div class="row">
                <div class="col-md-3">
                    <label class="col-form-label">Montant de la Caisse</label>
                    <input type="text" class="form-control" placeholder="{{number_format($somme['somme_caisse'], 0, '', ' ')}} FCFA" readonly>
                </div>
                <div class="col-md-3">
                    <label class="col-form-label">Montant à la Banque </label>
                    <input type="text" class="form-control" placeholder="{{number_format($somme['somme_banque'], 0, '', ' ')}} FCFA" readonly>
                </div>
                <div class="col-md-3">
                    <label class="col-form-label">Dettes Clients</label>
                    <input type="text" class="form-control" placeholder="{{number_format($dette_clients, 0, '', ' ')}} FCFA" readonly>
                </div>
                <div class="col-md-3">
                    <label class="col-form-label">Dettes Fournisseurs</label>
                    <input type="text" class="form-control" placeholder="{{number_format($dette_fournisseurs, 0, '', ' ')}} FCFA" readonly>
                </div>
            </div>
            <h2 class="pt-4">Bilan de toutes les activités</h2>
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label">Investissement</label>
                    <input type="text" class="form-control" placeholder="{{number_format($investissements, 0, '', ' ')}} FCFA" readonly>
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">Dépenses</label>
                    <input type="text" class="form-control" placeholder="{{number_format($depense, 0, '', ' ')}} FCFA" readonly>
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">Ventes</label>
                    <input type="text" class="form-control" placeholder="{{number_format($ventes, 0, '', ' ')}} FCFA" readonly>
                </div>
            </div>
            <h2 class="pt-4">Générateur de Rapport GESCHICKEN</h2>
            <div class="row">
                <div class="col-md-5">
                    <label  class="col-form-label">Année</label>
                    <select class="form-select" aria-label="Default select example" wire:model.lazy="annee" required>
                        <option value=""></option>
                        @foreach ($year as $item)
                            <option value="{{$item->year}}">{{$item->year}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label  class="col-form-label">Mois</label>
                    <select class="form-select" aria-label="Default select example" wire:model="mois" required>
                        <option value=""></option>
                        @if ($month)
                            @foreach ($month as $item)
                                <option value="{{$item->month}}">{{$item->month}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-2" style="padding-top: 38px">
                    <button type="button" wire:click="seeRapport" class="btn" style="background-color: #821435; color: white;" data-bs-toggle="modal" data-bs-target="#rapportModal" data-bs-whatever="@mdo">Génerer</button>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.caisse.caisse-modal')
</div>
