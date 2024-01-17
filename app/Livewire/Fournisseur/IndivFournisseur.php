<?php

namespace App\Livewire\Fournisseur;

use App\Models\Caisse;
use App\Models\Fournisseur;
use App\Models\Operation;
use App\Models\Reception;
use App\Models\Stock;
use Livewire\Attributes\Validate;
use Livewire\Component;

class IndivFournisseur extends Component
{
    public $id_fournisseur;

    #[Validate('required', message: 'Veuillez remplir le champ')]
    #[Validate('numeric', message: 'Veuillez saisir des chiffres')]
    public $quantite = '';

    #[Validate('required', message: 'Veuillez remplir le champ')]
    #[Validate('numeric', message: 'Veuillez saisir des chiffres')]
    public $prix_unitaire = '';
    
    #[Validate('required')]
    public $type_depot = '';
    
    #[Validate('required')]
    public $id_reception = '';

    public $reglement_effectif = '';

    public $montant = 0;

    public $mode_paiement = '';

    public $montant_insuffisant = '';


    private function createStock() {
        if ( Stock::all()->isEmpty()) {
            Stock::insert([
                [
                    'type' => 'entier',
                    'quantite_stock' => 0
                ],
                [
                    'type' => 'blanc',
                    'quantite_stock' => 0
                ],
                [
                    'type' => 'cuisse',
                    'quantite_stock' => 0
                ],
                [
                    'type' => 'aile',
                    'quantite_stock' => 0
                ],
                [
                    'type' => 'carcasse',
                    'quantite_stock' => 0
                ],
                [
                    'type' => 'attieke',
                    'quantite_stock' => 0
                ],
            ]);
        }
    }

    public function saveReception() {

        $this->createStock();

        $validated = $this->validate();

        Reception::create([
            'id_reception' => $validated['id_reception'],
            'quantite' => $validated['quantite'],
            'prix_unitaire' => $validated['prix_unitaire'],
            'type_produit' => $validated['type_depot'],
            'montant' => $validated['quantite'] * $validated['prix_unitaire'],
            'fournisseur_id' => $this->id_fournisseur
        ]); 

        if ($validated['type_depot'] === 'poulet') {
            Stock::where('type', 'entier')->increment('quantite_stock', $validated['quantite']);
        } else {
            Stock::where('type', 'attieke')->increment('quantite_stock', $validated['quantite']);
        }
        


        return $this->redirectRoute('fournisseur.individuel', ['fournisseur_id' => $this->id_fournisseur]);
    }

    public function montantFinal(){
        $validated = $this->validate();
        if ($validated) {
            $this->montant = $validated['quantite'] * $validated['prix_unitaire'];
        }
    }

    public function closeModal(){
        $this->reset('quantite', 'prix_unitaire', 'montant');
    }

    public function saveReglement() {

        if ($this->mode_paiement === 'espece') {

            $montant = Reception::where('id', $this->reglement_effectif)->value('montant');
            $somme_restant = Caisse::where('type_caisse', 'somme_caisse')->value('somme_type');

            // verification si la somme qu'on veut regler est disponible en caisse

            if ($montant <= $somme_restant) {
                $id_caisse = Caisse::where('type_caisse', 'somme_caisse')->value('id');
                Operation::create([
                    'type_operation' => 'Règlement Fournisseur',
                    'montant_operation' => $montant,
                    'caisse_id' => $id_caisse,
                ]);
    
                Caisse::where('type_caisse', 'somme_caisse')->decrement('somme_type', $montant);
        
                Reception::where('id', $this->reglement_effectif)->update([
                    'reglement' => true,
                    'date_reglement' => now()
                ]);
                return $this->redirectRoute('fournisseur.individuel', ['fournisseur_id' => $this->id_fournisseur]);
            } else {
                $this->montant_insuffisant = 'La somme disponible est insuffisante pour régler ce fournisseur !!!';
            }
            

        } else {

            $montant = Reception::where('id', $this->reglement_effectif)->value('montant');
            $somme_restant = Caisse::where('type_caisse', 'somme_banque')->value('somme_type');

            // verification si la somme qu'on veut regler est disponible à la banque
            if ($montant <= $somme_restant) {

                $montant = Reception::where('id', $this->reglement_effectif)->value('montant');
                $id_caisse = Caisse::where('type_caisse', 'somme_banque')->value('id');
                Operation::create([
                    'type_operation' => 'Règlement Fournisseur',
                    'montant_operation' => $montant,
                    'caisse_id' => $id_caisse,
                ]);
                Caisse::where('type_caisse', 'somme_banque')->decrement('somme_type', $montant);
        
                Reception::where('id', $this->reglement_effectif)->update([
                    'reglement' => true,
                    'date_reglement' => now()
                ]);
                return $this->redirectRoute('fournisseur.individuel', ['fournisseur_id' => $this->id_fournisseur]);
            } else {
                $this->montant_insuffisant = 'La somme disponible est insuffisante pour régler ce fournisseur !!!';
            }
            
        }
        
    }


    public function render()
    {
        $fournisseur  = Fournisseur::find($this->id_fournisseur);

        $receptions = Reception::where('fournisseur_id',$this->id_fournisseur)->orderByDesc('created_at')->paginate(10);

        $solde = Reception::where('fournisseur_id', $this->id_fournisseur)
        ->where('reglement', false)
        ->sum('montant');

        $reglements = Reception::where('fournisseur_id', $this->id_fournisseur)
        ->where('reglement', false)
        ->get();

        return view('livewire.fournisseur.indiv-fournisseur', [
            'fournisseur' => $fournisseur, 
            'receptions' => $receptions, 
            'solde' => $solde,
            'reglements' => $reglements
        ]);
    }
}
