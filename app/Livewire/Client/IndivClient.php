<?php

namespace App\Livewire\Client;

use App\Models\Caisse;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Operation;
use App\Models\Stock;
use Livewire\Component;

class IndivClient extends Component
{
    public $prix_total = 0 ;
    public $id_client;

    public $activation = false ;

    public $entier = false, $blanc = false, $cuisse = false, $aile = false, $carcasse = false;

    public $parties = [] ;

    public $quantite = [];

    public $quantite_dispo = [];

    public $prix = [];

    public $indiv_commande = [];

    public $message_erreur = '';

    public $id_commande_en_cours = '';

    public $reglement_effectif = '';

    public $mode_paiement = '';

    public function saveCommande() {
        $commande = Commande::create([
            'client_id' => $this->id_client
        ]);

        foreach($this->parties as $key => $partie){
            
            // decrementation du stock avannt l'insertion des ids de la commande et stocks dans la table intermediare

            Stock::where('type', $partie)->decrement('quantite_stock', $this->quantite[$key]);
            $id_stock = Stock::where('type', $partie)->value('id');
            $stock = Stock::find($id_stock);
            $stock->commandes()->attach($commande->id, [
                'quantite_type' => $this->quantite[$key],
                'prix_unitaire_type' => $this->prix[$key],
                'montant_type' => $this->quantite[$key] * $this->prix[$key]
            ]);

        }

        return $this->redirectRoute('client.individuel', ['id_client' => $this->id_client]);
    }

    // Methode pour voir les autres champs du formulaire quand on clique sur activation

    public function remplissageChamps() {
        $this->reset('parties', 'prix', 'quantite', 'quantite_dispo');
        $composants = ['entier', 'blanc', 'cuisse', 'aile', 'carcasse'];
        foreach($composants as $composant){
            if ($this->{$composant}) {
                array_push($this->quantite_dispo, Stock::where('type', $composant)->value('quantite_stock'));
                array_push($this->parties, $composant);
            }
        }
    }


    public function montantTotal() {

        // Maintenant attaquer la partie ou on va obliger l'itilisateur a saisir un chiffre inferieur à la quantité dans le stock

        $this->reset('message_erreur', 'prix_total');
        $occurence = 0 ;
        // verification si tous les champs sont remplis
        if (count($this->quantite) === count($this->parties) && count($this->prix) === count($this->parties)) {
            foreach($this->parties as $key => $partie){
                if ($this->quantite[$key] > 0 && $this->prix[$key] > 0) {
                    $occurence++;
                }
            }
            if ($occurence === count($this->parties)) {
                foreach($this->parties as $key => $partie){
                    $this->prix_total += $this->quantite[$key] * $this->prix[$key];
                }
            } else {
                $this->message_erreur = "Revoyez vos quantités et vos prix !!!";
            }
        }else{
            $this->message_erreur = "Remplissez tous les champs";
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


    public function seeCommandeIndiv($id_commande){

        $this->id_commande_en_cours = $id_commande;
        $this->indiv_commande = Commande::with('stocks')->where('id', $id_commande)->get()->toArray();
        $this->indiv_commande = $this->conversionIndivCommande($this->indiv_commande);

    }

    public function closeModalSeeCommande(){
        $this->reset('id_commande_en_cours', 'indiv_commande');
    }


    public function conversion(array $operations) : array{

        // le tableau qui va recevoir le tableau reorganisé
        $data = [];

        foreach($operations as $operation){
            $donne = [] ;
            foreach($operation as $key => $item){ 
                if ($key === 'id') {
                    array_push($donne, $item);
                }
                if ($key === 'created_at') {
                    array_push($donne, $item);
                }
                if ($key === 'date_reglement') {
                    array_push($donne, $item);
                }
                if ($key === 'stocks') {
                    $montant = 0 ;
                    foreach($item as $partie){
                        // recuperation du montant de chaque type de produit concercant la commande en cours dans la boucle 
                        $montant += $partie['commande_stock']['montant_type'];
                    }
                    
                    // affectation du montant total d'un commande au tableau
                    array_push($donne, $montant);
                }

            }
            array_push($data, $donne);
        }

        return $data;
    }

    public function recuperationMontantPaiement(array $datas) : int{
        $somme = 0;
        foreach($datas as $data){
            foreach($data as $key => $item){ 
                if ($key === 'stocks') {
                    $montant = 0 ;
                    foreach($item as $partie){
                        // recuperation du montant de chaque type de produit concercant la commande en cours dans la boucle 
                        $montant += $partie['commande_stock']['montant_type'];
                    }
                    
                    // affectation du montant  à la somme global
                   $somme += $montant;
                }

            }
        }
        return $somme;

    }


    public function savePaiement() {

        if ($this->mode_paiement === 'espece') {
            $somme_paiement = Commande::with('stocks')->where('id', $this->reglement_effectif)
            ->get()
            ->toArray();
            $somme_paiement = $this->recuperationMontantPaiement($somme_paiement);
    
            $id_caisse = Caisse::where('type_caisse', 'somme_caisse')->value('id');
            Operation::create([
                'type_operation' => 'Règlement Client',
                'montant_operation' => $somme_paiement,
                'caisse_id' => $id_caisse,
            ]);
    
            Caisse::where('type_caisse', 'somme_caisse')->increment('somme_type', $somme_paiement);
    
            Commande::where('id', $this->reglement_effectif)->update([
                'date_reglement' => now()
            ]);
        } else {

            $somme_paiement = Commande::with('stocks')->where('id', $this->reglement_effectif)
            ->get()
            ->toArray();
            $somme_paiement = $this->recuperationMontantPaiement($somme_paiement);
    
            $id_caisse = Caisse::where('type_caisse', 'somme_banque')->value('id');
            Operation::create([
                'type_operation' => 'Règlement Client',
                'montant_operation' => $somme_paiement,
                'caisse_id' => $id_caisse,
            ]);
    
            Caisse::where('type_caisse', 'somme_banque')->increment('somme_type', $somme_paiement);
    
            Commande::where('id', $this->reglement_effectif)->update([
                'date_reglement' => now()
            ]);
        }
        
        return $this->redirectRoute('client.individuel', ['id_client' => $this->id_client]);
    }


    public function calculSolde(array $datas) : int {

        $solde = 0 ;
        foreach($datas as $data){
            foreach($data as $key => $item){ 
                if ($key === 'stocks') {
                    $montant = 0 ;
                    foreach($item as $partie){
                        $montant += $partie['commande_stock']['montant_type'];
                    }
                    
                    $solde += $montant ;
                }

            }
        }

        return $solde;
    }

    
    public function render()
    {
        $operations = Commande::with('stocks')->where('client_id', $this->id_client)
        ->get()
        ->toArray();

        $datas = array_reverse($this->conversion($operations));

        $reglements = Commande::with('stocks')->where('client_id', $this->id_client)
        ->whereNull('date_reglement')
        ->get()
        ->toArray();

        $reglements = array_reverse($this->conversion($reglements));

        $solde = Commande::with('stocks')->where('client_id', $this->id_client)
        ->whereNull('date_reglement')
        ->get()
        ->toArray();

        $solde = $this->calculSolde($solde);

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


