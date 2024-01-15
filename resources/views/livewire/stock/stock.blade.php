<div>
    <div class="cote-menu">
        <div class="nav-haut">
            <div><h4 style="padding-left: 3px;"><i class="fa-solid fa-boxes-packing" style="padding-right: 7px"></i>Stock</h4></div>
            <div style="padding-right: 10px;"><h5>DALLA DISTRIBUTIONS</h5></div>
        </div>
        <div class="contenu">
            <div>
              <button type="button" class="btn" style="background-color: #821435; color: white;" data-bs-toggle="modal" data-bs-target="#extractionModal" data-bs-whatever="@mdo" ><i class="fa-solid fa-plus icon"></i>Extraction</button>
              <button type="button" class="btn" style="background-color: #821435; color: white;" data-bs-toggle="modal" data-bs-target="#avarieModal" data-bs-whatever="@mdo" ><i class="fa-solid fa-right-from-bracket icon"></i>Retrait</button>
            </div>
            <h2>LE STOCK GLOBAL</h2>
            <div class="tableau pt-4">
                <div class="titre">
                    <div><h4>Quantité Par Type</h4></div>
                </div>
                <div>
                    <table class="table table-striped table-bordered" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Quantité</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $stock)
                                <tr wire:key="{{$stock->id}}">
                                    <td>{{strtoupper($stock->id)}}</td>
                                    <td>{{strtoupper($stock->type)}}</td>
                                    <td>{{$stock->quantite_stock}} KG</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.stock.stock-modal')
</div>
