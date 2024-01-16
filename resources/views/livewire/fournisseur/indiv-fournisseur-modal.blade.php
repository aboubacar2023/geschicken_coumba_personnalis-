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
                        <input type="text" class="form-control" wire:model="quantite" required>
                        <div class="erreur">@error('quantite') {{$message}}@enderror</div>
                    </div>
                    <div class="col-md-12">
                        <label class="col-form-label">Prix Unitaire en FCFA</label>
                        <input type="text" class="form-control" wire:model="prix_unitaire" required>
                        <div class="erreur">@error('prix_unitaire') {{$message}}@enderror</div>
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
            <h3 class="entete_bilan">Sélectionner la facture à régler</h3>
              @if ($this->montant_insuffisant)
                  <h5 style="text-align: center; color:#821435">{{$this->montant_insuffisant}}</h5>
              @endif
                <div class="row">
                    <div class="col-md-6">
                        <label  class="col-form-label">Les Règlements</label>
                        <select class="form-select" aria-label="Default select example" wire:model="reglement_effectif" required>
                          <option value=""></option>
                          @foreach ($reglements as $reglement)
                            <option value="{{$reglement->id}}">Reception N°{{$reglement->id}} -- Montant Total : {{number_format($reglement->montant, 0, '', ' ')}} FCFA</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                      <label  class="col-form-label">Mode de Paiement</label>
                      <select class="form-select" aria-label="Default select example" wire:model="mode_paiement" required>
                        <option value=""></option>
                        <option value="espece">Espèce</option>
                        <option value="banque">Banque</option>
                      </select>
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