<div wire:ignore.self class="modal fade" id="rapportModal" tabindex="-1" aria-labelledby="rapportModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="rapportModalLabel">Rapport</h1>
                <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <h3 class="entete_bilan">
                        Rapports des activités
                        @if ($this->mois)
                            du {{$this->mois}}/
                        @else
                            de
                        @endif
                        {{$this->annee}}
                    </h3>
                    @if ($rapport)
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label">Investissement</label>
                                <input type="text" class="form-control" placeholder="{{number_format($rapport['investissement'], 0, '', ' ')}} FCFA" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label">Dépenses</label>
                                <input type="text" class="form-control" placeholder="{{number_format($rapport['depense'], 0, '', ' ')}} FCFA" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label">Dépenses Personnelles</label>
                                <input type="text" class="form-control" placeholder="{{number_format($rapport['depense_perso'], 0, '', ' ')}} FCFA" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label">Ventes</label>
                                <input type="text" class="form-control" placeholder="{{number_format($rapport['vente'], 0, '', ' ')}} FCFA" readonly>
                            </div>
                        </div>
                        <h3 class="entete_bilan mt-4">Les Pertes</h3>
                        <div class="row">
                                @foreach ($pertes as $perte)
                                    <div class="col-md-6">
                                        <label class="col-form-label">Quantité {{ucfirst($perte->type)}}</label>
                                        <input type="text" class="form-control" placeholder="{{ucfirst($perte->quantite)}}" readonly>
                                    </div>
                                @endforeach
                        </div>
                        <h3 class="entete_bilan mt-4">Les Manquants</h3>
                        <div class="row">
                                @foreach ($manquants as $manquant)
                                    <div class="col-md-6">
                                        <label class="col-form-label">Quantité {{ucfirst($manquant->type)}}</label>
                                        <input type="text" class="form-control" placeholder="{{ucfirst($manquant->quantite)}}" readonly>
                                    </div>
                                @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
            </div>
    </div>
  </div>
</div>