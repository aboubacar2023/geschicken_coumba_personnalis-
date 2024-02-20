<?php

namespace App\Livewire\Client;

use App\Models\Caisse;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Operation;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IndivClient extends Component
{
    
    public $prix_total = 0 ;
    public $id_client;

    public $activation = false ;

    public $entier = false, $blanc = false, $cuisse = false, $aile = false, $carcasse = false, $attieke = false;

    public $parties = [] ;

    public $quantite = [];

    public $quantite_dispo = [];

    public $prix = [];

    public $indiv_commande = [];

    public $message_erreur = '';
    // Ajout
    public $date_reglement = '';
    // La date de la commande 
    public $date_commande = '';

    public $type_paiement = '';
    // Ceci est l'id manuelle qu'on saisira
    public $id_identifiant_commande = '';

    public $id_commande_en_cours = '';

    public $reglement_effectif = '';

    // Le montant à payer quand il opte pour le mode de paiement en avance, genre il regle pas totalement les
    // dettes, mais il paye une somme pour diminuer les dettes
    public $montant_paye ;
    
    public $mode_paiement = '';

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

    public function saveCommande() {
        if ($this->activation && !empty($this->parties)) {
                $verif = $this->montantTotal() ;
                if ($verif) {
                    $commande = Commande::create([
                        'id_commande' => $this->id_identifiant_commande,
                        'client_id' => $this->id_client,
                        'date_commande' => $this->date_commande,
                        'montant_commande' => $this->prix_total,
                        'montant_non_regle_type' => $this->prix_total
                    ]);

                    foreach($this->parties as $key => $partie){
                        
                        // decrementation du stock avant l'insertion des ids de la commande et stocks dans la table intermediare
                        Stock::where('type', $partie)->decrement('quantite_stock', $this->quantite[$key]);
                        $id_stock = Stock::where('type', $partie)->value('id');
                        $stock = Stock::find($id_stock);
                        if ($partie === 'attieke') {
                            $stock->commandes()->attach($commande->id, [
                                'quantite_type' => $this->quantite[$key],
                                'prix_unitaire_type' => $this->prix[$key],
                                'montant_type' => $this->quantite[$key] * $this->prix[$key],
                            ]);
                        } else {
                            $stock->commandes()->attach($commande->id, [
                                'quantite_type' => $this->quantite[$key],
                                'prix_unitaire_type' => $this->prix[$key],
                                'montant_type' => $this->quantite[$key] * $this->prix[$key],
                            ]);
                        }
                        

                    }

                    return $this->redirectRoute('client.individuel', ['id_client' => $this->id_client]);
                }
        }
    }

    // Methode pour voir les autres champs du formulaire quand on clique sur activation ou si les données saisies sont correctes

    public function remplissageChamps() {
        $this->reset('parties', 'prix', 'quantite', 'quantite_dispo');
        $composants = ['entier', 'blanc', 'cuisse', 'aile', 'carcasse', 'attieke'];
        foreach($composants as $composant){
            if ($this->{$composant}) {
                array_push($this->quantite_dispo, Stock::where('type', $composant)->value('quantite_stock'));
                array_push($this->parties, $composant);
            }
        }
    }

    // Ceci est fait pour calculer le montant total mais egalement de referentiel de validation avant de sauvegarder la commande
    public function montantTotal() : bool {

        // Maintenant attaquer la partie ou on va obliger l'utilisateur a saisir un chiffre inferieur à la quantité dans le stock

        $this->reset('message_erreur', 'prix_total');
        $occurence = 0 ;
        // verification si tous les champs sont remplis
        if (count($this->quantite) === count($this->parties) && count($this->prix) === count($this->parties)) {
            foreach($this->parties as $key => $partie){

                // Verification si les nombres saisies (quantités et prix) est un chiffre et qu'il est inferieur au stock auquel il correspond

                $stock = Stock::where('type', $partie)->value('quantite_stock');
                if ((is_numeric($this->quantite[$key]) && $this->quantite[$key] > 0 ) && ($this->quantite[$key] <= $stock) &&  (is_numeric($this->prix[$key]) && $this->prix[$key] > 0) ) {
                    $occurence++;
                }
            }
            // le nombre de $occurence doit etre egal au nombre du tableau pour verifier si toutes les conditions sont remplies

            if ($occurence === count($this->parties)) {
                foreach($this->parties as $key => $partie){

                    // seul attieke prendra en compte les chiffres après virgule

                   if ($partie === 'attieke') {
                        $this->prix_total += $this->quantite[$key] * $this->prix[$key];
                   } else {
                       $this->prix_total += $this->quantite[$key] * $this->prix[$key];
                   }
                   
                }
                return true ;
            } else {
                $this->message_erreur = "Revoyez vos quantités et vos prix !!!";
                return false ;
            }
        }else{
            $this->message_erreur = "Remplissez tous les champs";
            return false ;
        }
        

    }

    public function conversionIndivCommande(array $commandes) : array{
        $data = [];

        foreach($commandes as $commande){
            foreach($commande as $key => $item){ 
                if ($key === 'stocks') {
                    foreach($item as $partie){
                        $donne = [] ;
                        array_push($donne, $partie['type']);
                        array_push($donne, $partie['commande_stock']['quantite_type']);
                        array_push($donne, $partie['commande_stock']['prix_unitaire_type']);
                        array_push($donne, $partie['commande_stock']['montant_type']);
                        array_push($data, $donne);
                    }
                }

            }
        }

        return $data;
    }

    // Recuperation des informations d'une commande quand on regarde le modal
    public function seeCommandeIndiv($id_commande){

        $this->id_commande_en_cours = $id_commande;
        $this->indiv_commande = Commande::with('stocks')->where('id', $id_commande)->get()->toArray();
        $this->indiv_commande = $this->conversionIndivCommande($this->indiv_commande);

    }

    public function closeModalSeeCommande(){
        $this->reset('id_commande_en_cours', 'indiv_commande');
    }

    // Methode qu'on va appeler quand la personne voudra plutot deposer une somme
    private function decrementationSoldeGlobal($type, $somme) : void
    {
        if ($type === "espece") {
            $type_caisse = "somme_caisse";
        } else {
            $type_caisse = "somme_banque";
        }
        $commandes = Commande::where('client_id', $this->id_client)
        ->whereNull('date_reglement')
        ->orderBy('date_commande', 'asc')
        ->select('commandes.id', 'montant_non_regle_type')
        ->get();

        // Ajout de l'info dans les activités du jour
        $id_caisse = Caisse::where('type_caisse', $type_caisse)->value('id');
        Operation::create([
            'type_operation' => 'Règlement Client',
            'montant_operation' => $somme,
            'caisse_id' => $id_caisse,
        ]);

        // Augmentation de la somme de la caisse en fonction du type
        Caisse::where('type_caisse', $type_caisse)->increment('somme_type', $somme);
        
        foreach($commandes as $commande){
            if ($somme > 0) {
                if ($somme >= $commande->montant_non_regle_type) {
                    Commande::where('id', $commande->id)->update([
                        'date_reglement' => $this->date_reglement,
                        'montant_non_regle_type' => 0
                    ]);
                } else{
                    Commande::where('id', $commande->id)->decrement('montant_non_regle_type', $somme);
                }
                $somme -= $commande->montant_non_regle_type;
            } else {
                break ;
            }
        }
    }

    public function savePaiement() {
        if($this->type_paiement === "regelement_facture"){
            // On verifie si on fait l'operation sur la caisse ou la banque
            if ($this->mode_paiement === "espece") {
                $type_caisse = "somme_caisse";
            } else {
                $type_caisse = "somme_banque";
            }
                // Récuperation de la somme non réglé par la commande
                $somme_paiement = Commande::where('id', $this->reglement_effectif)->value('montant_non_regle_type');
        
                $id_caisse = Caisse::where('type_caisse', $type_caisse)->value('id');
                Operation::create([
                    'type_operation' => 'Règlement Client',
                    'montant_operation' => $somme_paiement,
                    'caisse_id' => $id_caisse,
                ]);
        
                Caisse::where('type_caisse', $type_caisse)->increment('somme_type', $somme_paiement);
        
                Commande::where('id', $this->reglement_effectif)->update([
                    'date_reglement' => $this->date_reglement,
                    'montant_non_regle_type' => 0
                ]);
            
            } else {
                $validated = $this->validate([
                    'montant_paye' => 'required|numeric|gt:1'
                ]);
                $this->decrementationSoldeGlobal($this->mode_paiement, $validated['montant_paye']);
            }
            return $this->redirectRoute('client.individuel', ['id_client' => $this->id_client]);
    }

    
    public function render()
    {
        $datas = Commande::where('client_id', $this->id_client)
        ->orderByDesc('date_commande')
        ->paginate(25);

        $reglements = Commande::where('client_id', $this->id_client)
        ->whereNull('date_reglement')
        ->get();

        $solde = Commande::where('client_id', $this->id_client)
        ->whereNull('date_reglement')
        ->sum('montant_non_regle_type');

        $client = Client::find($this->id_client);

        return view('livewire.client.indiv-client', [
            'client' => $client,
            'datas' => $datas,
            'indiv_commande' => $this->indiv_commande,
            'reglements' => $reglements,
            'solde' => $solde
        ]);
    }
}


