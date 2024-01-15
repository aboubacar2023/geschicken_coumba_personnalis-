<div wire:ignore.self class="modal fade" id="nouveauModal" tabindex="-1" aria-labelledby="nouveauModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form wire:submit="saveClient">
          @csrf
          <div class="modal-header">
          <h1 class="modal-title fs-5" id="nouveauModalLabel">Nouveau Client</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
            <h3 class="entete_bilan">IDENTITE DU NOUVEAU CLIENT</h3>
                <div class="row">
                    <div class="col-md-6">
                        <label class="col-form-label">Prénom</label>
                        <input type="text" class="form-control" wire:model="prenom" required maxlength="20">
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Nom</label>
                        <input type="text" class="form-control" wire:model="nom" required maxlength="20">
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Société</label>
                        <input type="text" class="form-control" wire:model="societe" maxlength="20">
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Adresse</label>
                        <input type="text" class="form-control" wire:model="adresse" required maxlength="20">
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Contact</label>
                        <input type="text" class="form-control" wire:model="contact" required minlength="8" maxlength="8">
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

{{-- update client --}}

<div wire:ignore.self class="modal fade" id="modificationModal" tabindex="-1" aria-labelledby="modificationModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form wire:submit="saveUpdateClient">
          @csrf
          <div class="modal-header">
          <h1 class="modal-title fs-5" id="modificationModalLabel">Modifications Client</h1>
          <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
            <h3 class="entete_bilan">MODIFICATION DE L'IDENTITE DU CLIENT</h3>
                <div class="row">
                    <div class="col-md-6">
                        <label class="col-form-label">Prénom</label>
                        <input type="text" class="form-control" wire:model="prenom" required maxlength="20">
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Nom</label>
                        <input type="text" class="form-control" wire:model="nom" required maxlength="20">
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Société</label>
                        <input type="text" class="form-control" wire:model="societe" maxlength="20">
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Adresse</label>
                        <input type="text" class="form-control" wire:model="adresse" required maxlength="20">
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Contact</label>
                        <input type="text" class="form-control" wire:model="contact" required minlength="8" maxlength="8">
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" wire:click="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
        <button type="submit" class="btn" style="background-color: #821435; color: white;">Modifier</button>
      </div>
    </form>
    </div>
  </div>
</div>