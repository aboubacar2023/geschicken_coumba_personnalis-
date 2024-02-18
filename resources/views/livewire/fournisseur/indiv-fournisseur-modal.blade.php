<div wire:ignore.self class="modal fade" id="receptionModal" tabindex="-1" aria-labelledby="receptionModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form wire:submit="saveReception">
          @csrf 
          <div class="modal-header">
          <h1 class="modal-title fs-5" id="receptionModalLabel">Nouvelle Reception</h1>
          <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
            <h3 class="entete_bilan">Renseignez les champs suivants :</h3>
                <div class="row">
                    <div class="col-md-6">
                      <label  class="col-form-label">Type Produit</label>
                      <select class="form-select" aria-label="Default select example" wire:model="type_depot" required>
                        <option value=""></option>
                        <option value="poulet">Poulet</option>
                        <option value="attieke">Attiéké</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Quantité en KG</label>
                        <input type="text" class="form-control @error('quantite') is-invalid @enderror" wire:model="quantite" required>
                        <div class="erreur">@error('quantite') {{$message}}@enderror</div>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Prix Unitaire en FCFA</label>
                        <input type="text" class="form-control @error('prix_unitaire') is-invalid @enderror" wire:model="prix_unitaire" required>
                        <div class="erreur">@error('prix_unitaire') {{$message}}@enderror</div>
                    </div>
                    <div class="col-md-6">
                      <label class="col-form-label">ID reception</label>
                      <input type="text" class="form-control" wire:model="id_reception" required>
                      <div class="erreur">@error('id_reception') {{$message}}@enderror</div>
                    </div>
                    <div class="col-md-6">
                      <label class="col-form-label">Date Reception</label>
                      <input type="date" class="form-control" wire:model="date_reception" required>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Montant</label>
                        <div class="form-check form-switch">
                          <input type="checkbox" class="form-check-input" wire:click="montantFinal">
                        </div>
                        <input type="text" class="form-control" placeholder="{{number_format($this->montant, 0, '', ' ')}} FCFA" readonly>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" wire:click="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
        <button type="submit" class="btn" style="background-color: #821435; color: white;">Valider</button>
      </div>
    </form>
    </div>
  </div>
</div>

{{-- reglement --}}

<div wire:ignore.self class="modal fade" id="reglementModal" tabindex="-1" aria-labelledby="reglementModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form wire:submit="saveReglement">
          @csrf
          <div class="modal-header">
          <h1 class="modal-title fs-5" id="reglementModalLabel">Nouveau Règlement</h1>
          <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
            <h3 class="entete_bilan">Règlement Fournisseur</h3>
              @if ($this->montant_insuffisant)
                  <h5 style="text-align: center; color:#821435">{{$this->montant_insuffisant}}</h5>
              @endif
                <div class="row">
                    <div class="col-md-6">
                      <label  class="col-form-label">Type Paiement</label>
                      <select class="form-select" aria-label="Default select example" wire:model.lazy="type_paiement" required>
                        <option value=""></option>
                        @if ($solde !== 0)
                          <option value="somme">Somme</option>
                        @endif
                        <option value="reglement_facture">Reglement Facture</option>
                      </select>
                    </div>
                    @if ($type_paiement === 'somme')
                        <div class="col-md-6">
                            <label class="col-form-label">Montant</label>
                            <input type="text" class="form-control @error('montant_paye') is-invalid @enderror" wire:model="montant_paye" required>
                            <div style="color: #821435;">@error('montant_paye') {{$message}} @enderror</div>
                        </div>
                    @elseif ($type_paiement === 'reglement_facture')
                      <div class="col-md-6">
                          <label  class="col-form-label">Les Règlements</label>
                          <select class="form-select" aria-label="Default select example" wire:model="reglement_effectif" required>
                            <option value=""></option>
                            @foreach ($reglements as $reglement)
                              <option value="{{$reglement->id}}">Reception N°{{$reglement->id_reception}} -- Montant Total : {{number_format($reglement->montant_non_regle, 0, '', ' ')}} FCFA</option>
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
        <button type="button" wire:click="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
        <button type="submit" class="btn" style="background-color: #821435; color: white;">Régler</button>
      </div>
    </form>
    </div>
  </div>
</div>