<div>
    <div class="cote-menu">
        <div class="nav-haut">
            <div><h4 style="padding-left: 3px;">Activités du Jour</h4></div>
            <div style="padding-right: 10px;"><h5>DALLA DISTRIBUTIONS</h5></div>
        </div>
        <div class="contenu">
            <div class="pb-4">
                <button type="button" class="btn" style="background-color: #821435; color: white;" data-bs-toggle="modal" data-bs-target="#depenseModal" data-bs-whatever="@mdo" >Opération</button>
                {{-- <button type="button" class="btn" style="background-color: #821435; color: white;" data-bs-toggle="modal" data-bs-target="#encaissementModal" data-bs-whatever="@mdo" ><i class="fa-solid fa-hand-holding-dollar icon"></i>Encaissement</button> --}}
            </div>
            <div class="tableau pt-4">
                <div class="titre">
                    <div><h4>Les opérations de la journée</h4></div>
                </div>
                <div>
                    <table class="table table-striped table-bordered" >
                        <thead>
                            <tr>
                                <th>Source</th>
                                <th>Motif</th>
                                <th>Montant</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($operations as $operation)
                                <tr wire:key="{{$operation->id}}">
                                    @php
                                        $type = explode('_', $operation->caisse->type_caisse);
                                    @endphp
                                    <td>{{ucfirst($type[1])}}</td>
                                    <td>{{ucfirst($operation->type_operation)}}</td>
                                    <td>{{number_format($operation->montant_operation, 0, '', ' ')}} FCFA</td>
                                    <td>
                                        @php
                                            $data = ['salaire', 'virement', 'facture', 'prelevement', 'divers']
                                        @endphp
                                        @if (in_array( $operation->type_operation, $data))
                                            <button type="button" wire:click="deleteDepense({{$operation->id}})" wire:confirm="Êtes vous sûr de supprimer Opération ?" class="btn" style="background-color: #821435; color: white">Supprimer</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.activite.journaliere-modal')
</div>
