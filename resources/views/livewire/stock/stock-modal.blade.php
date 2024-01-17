<div wire:ignore.self class="modal fade" id="extractionModal" tabindex="-1" aria-labelledby="extractionModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form wire:submit="saveExtraction">
          @csrf
          <div class="modal-header">
          <h1 class="modal-title fs-5" id="extractionModalLabel">Nouvelle Extraction</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
            <h3 class="entete_bilan">Renseignez les informations suivantes : </h3>
            @if ($this->message_erreur)
                <h4 style="text-align: center; color:#821435">{{$this->message_erreur}}</h4>
            @endif
            <div class="row"> 
                <div class="col-md-6">
                    <label class="col-form-label">Quantité Entier Disponible</label>
                    <input type="text" class="form-control" placeholder="{{number_format($quantite_dispo,2)}}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label">Quantité Entier</label>
                    <input type="text" class="form-control" wire:model="entier" required>
                    <div class="erreur">@error('entier') {{$message}}@enderror</div>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label">Blanc</label>
                    <input type="text" class="form-control" wire:model="blanc" required>
                    <div class="erreur">@error('blanc') {{$message}}@enderror</div>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label">Cuisse</label>
                    <input type="text" class="form-control" wire:model="cuisse" required>
                    <div class="erreur">@error('cuisse') {{$message}}@enderror</div>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label">Aile</label>
                    <input type="text" class="form-control" wire:model="aile" required>
                    <div class="erreur">@error('aile') {{$message}}@enderror</div>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label">Carcasse</label>
                    <input type="text" class="form-control" wire:model="carcasse" required>
                    <div class="erreur">@error('carcasse') {{$message}}@enderror</div>
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

{{-- anomalie --}}

<div wire:ignore.self class="modal fade" id="avarieModal" tabindex="-1" aria-labelledby="avarieModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form wire:submit="saveAvarie">
        @csrf
        <div class="modal-header">
        <h1 class="modal-title fs-5" id="avarieModalLabel">Anomalie</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="container-fluid">
          <h3 class="entete_bilan">Renseignez les informations suivantes : </h3>
          @if ($this->quantite_insuffisant)
                <h4 style="text-align: center; color:#821435">{{$this->quantite_insuffisant}}</h4>
            @endif
          <div class="row">
              <div class="col-md-4">
                <label class="col-form-label">Motif</label>
                <select class="form-select" aria-label="Default select example" wire:model="type_operation" required>
                  <option value=""></option>
                  <option value="manquant">Manquant</option>
                  <option value="avarie">Périmé</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="col-form-label">Type Produits</label>
                <select class="form-select" aria-label="Default select example" wire:model="produit_avarie" required>
                  <option value=""></option>
                  @foreach ($stocks as $stock)
                    <option value="{{$stock->id}}">{{ucfirst($stock->type)}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                  <label class="col-form-label">Quantité</label>
                  <input type="text" class="form-control" wire:model="quantite" required>
                  <div class="erreur">@error('quantite') {{$message}}@enderror</div>
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
