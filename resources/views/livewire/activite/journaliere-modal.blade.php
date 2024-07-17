<div wire:ignore.self class="modal fade" id="depenseModal" tabindex="-1" aria-labelledby="depenseModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form wire:submit="depense">
          @csrf
          <div class="modal-header">
          <h1 class="modal-title fs-5" id="depenseModalLabel">Nouvelle Dépense</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
            <h3 class="entete_bilan">RENSEIGNEZ LES CHAMPS</h3>
                <div class="row">
                    <div class="col-md-6">
                        <label class="col-form-label">Précisez le montant</label>
                        <input type="text" class="form-control" wire:model="montant" required
                        @if ($this->mode_paiement === 'espece')
                            max = "{{$argent['caisse']}}"
                        @else
                            max = "{{$argent['banque']}}"
                        @endif>
                        <div class="erreur">@error('montant') {{$message}}@enderror</div>
                    </div>
                    <div class="col-md-6">
                        <label  class="col-form-label">Mode de Paiement</label>
                        <select class="form-select" aria-label="Default select example" wire:model.lazy="mode_paiement" required>
                          <option value=""></option>
                          <option value="espece">Espèce</option>
                          <option value="banque">Banque</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label  class="col-form-label">Motif</label>
                        <select class="form-select" aria-label="Default select example" wire:model.lazy="motif" required>
                          <option value=""></option>
                          <option value="salaire">Salaire</option>
                          @if ($this->mode_paiement === 'espece')
                            <option value="virement">Dépôt Bancaire</option>
                          @endif
                          <option value="facture">Facture</option>
                          <option value="prelevement">Dépenses Personnelles</option>
                          <option value="divers">Dépenses Divers</option>
                        </select>
                    </div> 
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
        <button type="submit" class="btn" style="background-color: #821435; color: white;">Enregistrer</button>
        <span class="loader" wire:loading></span>
      </div>
    </form>
    </div>
  </div>
</div>

{{-- encaissement --}}

<div wire:ignore.self class="modal fade" id="encaissementModal" tabindex="-1" aria-labelledby="encaissementModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form wire:submit="encaissementDepot">
        @csrf
        <div class="modal-header">
        <h1 class="modal-title fs-5" id="encaissementModalLabel">Nouveau Encaissement</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="container-fluid">
          <h3 class="entete_bilan">RENSEIGNEZ LES CHAMPS</h3>
              <div class="row">
                  <div class="col-md-6">
                      <label class="col-form-label">Précisez le montant</label>
                      <input type="text" class="form-control" wire:model="montant" required>
                      <div class="erreur">@error('montant') {{$message}}@enderror</div>
                  </div>
                  <div class="col-md-6">
                      <label  class="col-form-label">Compte</label>
                      <select class="form-select" aria-label="Default select example" wire:model="encaissement" required>
                        <option value=""></option>
                        <option value="caisse">Caisse</option>
                        <option value="banque">Banque</option>
                      </select>
                  </div>
              </div>
          </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
      <button type="submit" class="btn" style="background-color: #821435; color: white;">Enregistrer</button>
      <span class="loader" wire:loading></span>
    </div>
  </form>
  </div>
</div>
</div>