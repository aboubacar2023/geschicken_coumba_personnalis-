<?php

namespace App\Livewire\Fournisseur;

use App\Models\Caisse;
use App\Models\Fournisseur;
use App\Models\Operation;
use App\Models\Reception;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class IndivFournisseur extends Component
{
    public $query = '';
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
    public $date_reception = '';

    public $date_reglement = '';
    
    #[Validate('required')]
    public $id_reception = '';

    public $reglement_effectif = '';

    public $montant = 0;

    // Le montant à payer quand il opte pour le mode de paiement en avance, genre il regle pas totalement les
    // dettes, mais il paye une somme pour diminuer les dettes
    public $montant_paye ;

    public $mode_paiement = '';

    // Payement pour solder une facture ou payer une somme seulement
    public $type_paiement = '';

    public $montant_insuffisant = '';

    public function rules() {
        return [
            'montant_paye' => $this->type_paiement === 'somme' ? 'required|numeric|gt:1' : '',
        ];
    }
    public function messages() {
        return [
            'montant_paye.gt' => "Veuillez Saisir un chiffre superieur à 0",
            'montant_paye.numeric' => "Veuillez Saisir des Chiffres",
        ];
    }


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
                'date_reception' => $validated['date_reception'],
                'montant' => $validated['quantite'] * $validated['prix_unitaire'],
                'montant_non_regle' => $validated['quantite'] * $validated['prix_unitaire'],
                'fournisseur_id' => $this->id_fournisseur
            ]); 
        
            Stock::where('type', $validated['type_depot'] )->increment('quantite_stock', $validated['quantite']);
        


        return $this->redirectRoute('fournisseur.individuel', ['fournisseur_id' => $this->id_fournisseur]);
    }

    public function montantFinal(){
        $validated = $this->validate();
        if ($validated) {
            if ($validated['type_depot'] === "poulet") {
                $this->montant = $validated['quantite'] * $validated['prix_unitaire'];
            } else {
                $this->montant = $validated['quantite'] * $validated['prix_unitaire'];
            }
            
        }
    }

    public function closeModal(){
        $this->reset('quantite', 'prix_unitaire', 'montant');
    }

    // Methode qu'on va appeler quand la personne voudra plutot deposer une somme
    private function decrementationSoldeGlobal($type, $somme)
    {
        if ($type === "espece") {
            $type_caisse = "somme_caisse";
        } else {
            $type_caisse = "somme_banque";
        }
        
        $factures = DB::table('fournisseurs')->where('fournisseurs.id', $this->id_fournisseur)
        ->join('receptions', 'fournisseurs.id', '=', 'receptions.fournisseur_id')
        ->where('reglement', false)
        ->orderBy('date_reception', 'asc')
        ->select('receptions.id', 'montant_non_regle')
        ->get();

        // verification si la somme qu'on veut regler est disponible en caisse
        $somme_restant = Caisse::where('type_caisse', $type_caisse)->value('somme_type');
        $id_caisse = Caisse::where('type_caisse', $type_caisse)->value('id');

        if ($somme <= $somme_restant) {
            // Dans les operations du jour, mettre uniquement la somme total payé au fournisseur et les informations
            Operation::create([
                'type_operation' => 'Règlement Fournisseur',
                'montant_operation' => $somme,
                'caisse_id' => $id_caisse,
            ]);
            // On n'oublie pas de decrementer le type de caisse
            Caisse::where('type_caisse', $type_caisse)->decrement('somme_type', $somme);
            // il fera le tour pour regler d'une maniere chaque fature tant que la somme deposer soit egale à 0

            foreach($factures  as $facture){
                // si la somme recu en parametre est égale à 0, on arrete tout
                if ($somme > 0) {

                    // si la somme en cours est superieur ou égale à une dette d'un facture, alors on peut solder cette facture
                    if ($somme >= $facture->montant_non_regle) {
                        Reception::where('id', $facture->id)->update([
                            'reglement' => true,
                            'montant_non_regle' => 0,
                            'date_reglement' => $this->date_reglement
                        ]);
                    } else {
                        Reception::where('id', $facture->id)->decrement('montant_non_regle', $somme);
                    }
                    $somme -= $facture->montant_non_regle;
                    
                }else {
                    break ;
                }
            }
            return $this->redirectRoute('fournisseur.individuel', ['fournisseur_id' => $this->id_fournisseur]);
        } else {
            $this->montant_insuffisant = 'La somme disponible est insuffisante pour régler ce fournisseur !!!';
        }
        
    }

    public function saveReglement() {
        // Verification si on veut regler une facture ou deposer une somme
        if ($this->type_paiement === "reglement_facture") {

            // Ici on determine le mode de paeiment avant la suite
            if ($this->mode_paiement === "espece") {
                $type_caisse = "somme_caisse";
            } else {
                $type_caisse = "somme_banque";
            }

            $montant = Reception::where('id', $this->reglement_effectif)->value('montant_non_regle');
            $somme_restant = Caisse::where('type_caisse', $type_caisse)->value('somme_type');

            // verification si la somme qu'on veut regler est disponible en caisse

            if ($montant <= $somme_restant) {
                $id_caisse = Caisse::where('type_caisse', $type_caisse)->value('id');
                Operation::create([
                    'type_operation' => 'Règlement Fournisseur',
                    'montant_operation' => $montant,
                    'caisse_id' => $id_caisse,
                ]);
    
                Caisse::where('type_caisse', $type_caisse)->decrement('somme_type', $montant);
        
                Reception::where('id', $this->reglement_effectif)->update([
                    'reglement' => true,
                    'montant_non_regle' => 0,
                    'date_reglement' => $this->date_reglement
                ]);
                return $this->redirectRoute('fournisseur.individuel', ['fournisseur_id' => $this->id_fournisseur]);
            } else {
                $this->montant_insuffisant = 'La somme disponible est insuffisante pour régler ce fournisseur !!!';
            }
            
        } else {
            $validated = $this->validate([
                'montant_paye' => 'required|numeric|gt:1'
            ]);
            $this->decrementationSoldeGlobal($this->mode_paiement, $validated['montant_paye']);
        }
        
        
    }


    public function deleteReception($id){
        Reception::where('id', $id)->delete();
        return $this->redirectRoute('fournisseur.individuel', ['fournisseur_id' => $this->id_fournisseur]);
    }


    public function render()
    {
        $fournisseur  = Fournisseur::find($this->id_fournisseur);

        $receptions = Reception::where('fournisseur_id',$this->id_fournisseur)->orderByDesc('date_reception');

        if ($this->query) {
            $receptions = $receptions->where('id_reception', 'like', '%'.$this->query.'%');
        }

        $receptions = $receptions->paginate(25);

        $solde = Reception::where('fournisseur_id', $this->id_fournisseur)
        ->where('reglement', false)
        ->sum('montant_non_regle');

        $reglements = Reception::where('fournisseur_id', $this->id_fournisseur)
        ->where('reglement', false)
        ->select('id', 'id_reception', 'montant_non_regle')
        ->get();

        $type_produit = Stock::select('type')->get();

        return view('livewire.fournisseur.indiv-fournisseur', [
            'fournisseur' => $fournisseur, 
            'receptions' => $receptions, 
            'solde' => $solde,
            'reglements' => $reglements,
            'type_produit' => $type_produit
        ]);
    }
}
