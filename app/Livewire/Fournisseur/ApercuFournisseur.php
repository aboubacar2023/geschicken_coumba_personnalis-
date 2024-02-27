<?php

namespace App\Livewire\Fournisseur;

use App\Events\FournisseurEvent;
use App\Models\Caisse;
use App\Models\Fournisseur;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ApercuFournisseur extends Component
{
    #[Validate('required')]
    public $prenom = '' ;

    #[Validate('required')]
    public $nom = '';

    public $societe = ''; 
    
    #[Validate('required')]
    public $adresse = '';

    #[Validate('required')]
    public $contact = '' ;

    public $query = '' ;
    public $id_fournisseur = '' ;

    public function createCaisseAttribut(){
        Caisse::insert([
            [
                'type_caisse' => 'somme_caisse',
                'somme_type' => 0,
            ],
            [
                'type_caisse' => 'somme_banque',
                'somme_type' => 0,
            ],
            [
                'type_caisse' => '_depense',
                'somme_type' => 0,
            ],
        ]);
    }

    public function saveFournisseur(){

        
        if (Caisse::all()->isEmpty()) {
            $this->createCaisseAttribut();
        }

        $validated = $this->validate();
        
        // excetion de l'enregistrement du fournisseur en utilisant le système d'évènement

        event(new FournisseurEvent($validated, $this->societe)); 

        return $this->redirectRoute('fournisseur.apercu');
        
    }

    public function updateFournisseur(Fournisseur $fournisseur){
        $this->id_fournisseur = $fournisseur->id;
        $this->prenom = $fournisseur->prenom ;
        $this->nom = $fournisseur->nom ;
        $this->societe = $fournisseur->societe ;
        $this->adresse = $fournisseur->adresse ;
        $this->contact = $fournisseur->contact ;
    }

    public function saveUpdateFournisseur(){
        if ($this->societe) { 
            Fournisseur::where('id', $this->id_fournisseur)->update([
                'prenom' => $this->prenom,
                'nom' => $this->nom,
                'societe' => $this->societe,
                'adresse' => $this->adresse,
                'contact' => $this->contact,
            ]);
        } else {
            Fournisseur::where('id', $this->id_fournisseur)->update([
                'prenom' => $this->prenom,
                'nom' => $this->nom,
                'adresse' => $this->adresse,
                'contact' => $this->contact,
            ]);
        }
        return $this->redirectRoute('fournisseur.apercu');
    }

    public function closeModal(){
        $this->reset('id_fournisseur', 'prenom', 'nom', 'societe', 'adresse', 'contact');
    }
    public function render()
    {
        $fournisseurs = Fournisseur::orderByDesc('created_at');
        if ($this->query) {
            $fournisseurs->where(function($query){
                $query->where('prenom', 'like', "%{$this->query}%")
                ->orWhere('nom', 'like', "%{$this->query}%")
                ->orWhere('societe', 'like', "%{$this->query}%")
                ->orWhere('contact', 'like', "%{$this->query}%");
            });
        } 
        $fournisseurs = $fournisseurs->paginate(15) ;
        return view('livewire.fournisseur.apercu-fournisseur', [
            'fournisseurs' => $fournisseurs
        ]);
    }
}
