<div wire:ignore.self class="modal fade" id="commandeModal" tabindex="-1" aria-labelledby="commandeModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form wire:submit="saveCommande">
          @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="commandeModalLabel">Nouvelle Commande</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <h3 class="entete_bilan">Cochez les produits concernés </h3>
                    <div class="row">
                        <div class="col">
                            <label class="col-form-label">Entier</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" wire:model.lazy="entier">
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label">Blanc</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" wire:model.lazy="blanc">
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label">Cuisse</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" wire:model.lazy="cuisse">
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label">Aile</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" wire:model.lazy="aile">
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label">Carcasse</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" wire:model.lazy="carcasse">
                            </div>
                        </div>
                        <div class="col">
                            <label class="col-form-label">Attiéké</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" wire:model.lazy="attieke">
                            </div>
                        </div>
                    </div>
                    <div class="checkbox-wrapper-3 pt-3">
                        <h5>Activation</h5>
                        <input type="checkbox" id="cbx-3" wire:click="remplissageChamps" wire:model.live="activation" />
                        <label for="cbx-3" class="toggle"><span></span></label>
                    </div>
                    @if(!empty($this->parties) && $this->activation)
                        <h3 class="entete_bilan mt-4">Renseignez les champs suivants : </h3>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label">ID commande</label>
                                <input type="text" class="form-control" wire:model="id_identifiant_commande" required>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label">Date Commande</label>
                                <input type="date" class="form-control" wire:model="date_commande" required>
                            </div>
                        </div>
                        @foreach ($this->parties as $key => $partie)
                            <h3 class="pt-3" style="text-align: center; color:#821435">{{strtoupper($partie)}}</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label">Quantité {{$partie}}</label>
                                    <input type="text" class="form-control" wire:model="quantite.{{$key}}" required max="{{$this->quantite_dispo[$key]}}">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label">Prix Unitaire en FCFA</label>
                                    <input type="text" class="form-control" wire:model="prix.{{$key}}" required>
                                </div>
                            </div>
                            @endforeach
                            @if ($this->message_erreur)
                                <h4 class="pt-4" style="text-align: center; color:#821435">{{$this->message_erreur}}</h4>
                            @endif
                            <h5 class="pt-3">Prix Total</h5>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" wire:click="montantTotal">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="{{number_format($this->prix_total, 0, '', ' ')}} FCFA" readonly>
                            </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
                <button type="submit" class="btn" style="background-color: #821435; color: white;">Enregistrer</button>
            </div>
        </form>
    </div>
  </div>
</div>

{{-- see Commande --}}

<div wire:ignore.self class="modal fade" id="seeCommandeModal" tabindex="-1" aria-labelledby="seeCommandeModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
          <h1 class="modal-title fs-5" id="seeCommandeModalLabel">Apercu Commande</h1>
          <button type="button" wire:click="closeModalSeeCommande" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <h3 class="entete_bilan">Les informations sur la commande</h3>
                <div class="row"> 
                    <table class="table table-striped table-bordered" >
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Quantité</th>
                                <th>Prix Unitaire</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        @if ($indiv_commande)
                            <tbody>
                            @foreach ($indiv_commande as $item)
                                <tr>
                                    <td>{{strtoupper($item[0])}}</td>
                                    <td>{{$item[1]}}</td>
                                    <td>{{number_format($item[2], 0, '', ' ')}} FCFA</td>
                                    <td>{{number_format($item[3], 0, '', ' ')}} FCFA</td>
                                </tr>
                            @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" wire:click="closeModalSeeCommande" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
        </div>
    </div>
  </div>
</div>

{{-- paiement --}}

<div wire:ignore.self class="modal fade" id="paiementModal" tabindex="-1" aria-labelledby="paiementModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form wire:submit="savePaiement">
          @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="paiementModalLabel">Règlement</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <h3 class="entete_bilan">SELECTIONNER LA FACTURE A PAYER </h3>
                    <div class="row">
                        <div class="col-md-6">
                            <label  class="col-form-label">Type Paiement</label>
                            <select class="form-select" aria-label="Default select example" wire:model.lazy="type_paiement" required>
                              <option value=""></option>
                              @if ($solde !== 0)
                                <option value="somme">Somme</option>
                              @endif
                              <option value="regelement_facture">Reglement Facture</option>
                            </select>
                        </div>
                        @if ($type_paiement === 'somme')
                            <div class="col-md-6">
                                <label class="col-form-label">Montant</label>
                                <input type="text" class="form-control @error('montant_paye') is-invalid @enderror" wire:model="montant_paye" required>
                                <div style="color: #821435;">@error('montant_paye') {{$message}} @enderror</div>
                            </div>
                        @elseif ($type_paiement === 'regelement_facture')
                            <div class="col-md-6">
                                <label  class="col-form-label">LES FACTURES IMPAYES</label>
                                <select class="form-select" aria-label="Default select example" wire:model="reglement_effectif" required>
                                <option value=""></option>
                                @foreach ($reglements as $reglement)
                                    <option value="{{$reglement->id}}">Facture N°{{$reglement->id_commande}} -- Montant Total : {{number_format($reglement->montant_non_regle_type, 0, '', ' ')}} FCFA</option>
                                @endforeach
                                </select>
                            </div> 
                        @endif    
                        <div class="col-md-6">
                            <label  class="col-form-label">Mode de Paiement</label>
                            <select class="form-select" aria-label="Default select example" wire:model="mode_paiement" required>
                              <option value=""></option>
                              <option value="espece">Espèce</option>
                              <option value="banque">Banque</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">Date Règlement</label>
                            <input type="date" class="form-control" wire:model="date_reglement" required>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
                <button type="submit" class="btn" style="background-color: #821435; color: white;">Enregistrer</button>
            </div>
        </form>
    </div>
  </div>
</div>