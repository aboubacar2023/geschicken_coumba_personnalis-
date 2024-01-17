<?php

namespace App\Livewire\Stock;

use App\Models\Probleme;
use App\Models\Stock as ModelsStock;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Stock extends Component
{
    #[Validate('required')]
    #[Validate('numeric', message : "Veuillez saisir des chiffres")]
    public $entier;

    #[Validate('required')]
     #[Validate('numeric', message : "Veuillez saisir des chiffres")]
    public $blanc;

    #[Validate('required')]
     #[Validate('numeric', message : "Veuillez saisir des chiffres")]
    public $cuisse;

    #[Validate('required')]
     #[Validate('numeric', message : "Veuillez saisir des chiffres")]
    public $aile;

    #[Validate('required')]
     #[Validate('numeric', message : "Veuillez saisir des chiffres")]
    public $carcasse;

    public $quantite_dispo;

    public $message_erreur = '';

    public $produit_avarie = '';
    public $quantite = '';
    public $quantite_insuffisant = '';
    public $type_operation = '';

    public function saveAvarie(){
        $validated = $this->validate([
            'quantite' => 'required|numeric', 
        ], [
            'quantite.numeric' => "Veuillez saisir des chiffres"
        ]);
        if (ModelsStock::where('id', $this->produit_avarie)->value('quantite_stock') >= $this->quantite) {

            if ($this->type_operation === 'manquant') {
                ModelsStock::where('id', $this->produit_avarie)->decrement('quantite_stock', $this->quantite);
                Probleme::create([
                    'quantite' => $validated['quantite'],
                    'type_probleme' => 'manquant',
                    'stock_id' => $this->produit_avarie
                ]);
            } else {
                ModelsStock::where('id', $this->produit_avarie)->decrement('quantite_stock', $this->quantite);
                Probleme::create([
                    'quantite' => $validated['quantite'],
                    'type_probleme' => 'avarie',
                    'stock_id' => $this->produit_avarie
                ]);
            }
            
            return $this->redirectRoute('stock');
        }else {
            $this->quantite_insuffisant = "Quantité non disponible dans le stock !!!";
        }
    }

    // verification si les données saisies sont correctes

    public function verifDonnee( array $composant) : bool {
        $a = 0;
        $somme = 0;

        if ($composant['entier'] > 0) {

            foreach($composant as $key => $item){
                if ($item > 0 && $key !== 'entier') {
                    $a++;
                    $somme += $item ;
                }
            }
            // Verification si la somme des differents composants sont inferieurs à la quanite saisie et aussi inferieur à la quantite dispo

            if ($somme <= $composant['entier'] && $composant['entier'] <= $this->quantite_dispo && $a === 4) {
                return true ;
            } else {
                return false ;
            }

        }else{

            return false;

        }
    }


    public function saveExtraction() {

        $validated = $this->validate();

        if ($this->verifDonnee($validated)) {

            ModelsStock::where('type', 'blanc')->increment('quantite_stock', $validated['blanc']);
            ModelsStock::where('type', 'cuisse')->increment('quantite_stock', $validated['cuisse']);
            ModelsStock::where('type', 'aile')->increment('quantite_stock', $validated['aile']);
            ModelsStock::where('type', 'carcasse')->increment('quantite_stock', $validated['carcasse']);
            ModelsStock::where('type', 'entier')->decrement('quantite_stock', $validated['entier']);

                return $this->redirectRoute('stock');
            }
        else{
            $this->message_erreur = 'Revoyez vos quantités !!!';
        }
    }
    public function render()
    {
        $this->quantite_dispo = ModelsStock::where('type', 'entier')->value('quantite_stock');
        $stocks = ModelsStock::all();
        return view('livewire.stock.stock', [
            'stocks' => $stocks,
            'quantite_dispo' => $this->quantite_dispo
        ]);
    }
}
