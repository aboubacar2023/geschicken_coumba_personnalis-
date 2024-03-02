<?php

namespace App\Livewire\Caisse;

use App\Models\Caisse as ModelsCaisse;
use App\Models\Commande;
use App\Models\Operation;
use App\Models\Peremption;
use App\Models\Reception;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Caisse extends Component
{

    public $annee = '';
    public $mois = '';

    protected $year = '';
    protected $month = '';

    protected $rapport = [];

    protected $pertes = '';
    protected $manquants = '';

    public function seeRapport() {
        if ($this->annee && $this->mois) {

            $this->rapport = [];
            $this->rapport['vente'] = Commande::whereNotNull('date_reglement')
            ->whereYear('created_at', $this->annee)
            ->whereMonth('created_at', $this->mois)
            ->sum('montant_commande');

            $this->rapport['investissement'] = Reception::whereYear('created_at', $this->annee)
            ->whereMonth('created_at', $this->mois)->sum('montant');

            $id_depense = ModelsCaisse::where('type_caisse', '_depense')->value('id');
            $this->rapport['depense'] = Operation::where('caisse_id', $id_depense)
            ->whereYear('created_at', $this->annee)
            ->whereMonth('created_at', $this->mois)
            ->where('type_operation', '<>', 'prelevement')
            ->sum('montant_operation');

            $this->rapport['depense_perso'] = Operation::where('caisse_id', $id_depense)
            ->whereYear('created_at', $this->annee)
            ->whereMonth('created_at', $this->mois)
            ->where('type_operation', 'prelevement')
            ->sum('montant_operation');

            $this->pertes = DB::table('stocks')
            ->join('problemes', 'stocks.id', '=', 'stock_id')
            ->whereYear('problemes.created_at', $this->annee)
            ->whereMonth('problemes.created_at', $this->mois)
            ->where('type_probleme', 'avarie')
            ->select('type', DB::raw('SUM(quantite) as quantite'))
            ->groupBy('stocks.type')
            ->get();

            $this->manquants = DB::table('stocks')
            ->join('problemes', 'stocks.id', '=', 'stock_id')
            ->whereYear('problemes.created_at', $this->annee)
            ->whereMonth('problemes.created_at', $this->mois)
            ->where('type_probleme', 'manquant')
            ->select('type', DB::raw('SUM(quantite) as quantite'))
            ->groupBy('stocks.type')
            ->get();

        }else{
            $this->rapport = [];
            $this->rapport['vente'] = Commande::whereNotNull('date_reglement')
            ->whereYear('created_at', $this->annee)
            ->sum('montant_commande');

            $this->rapport['investissement'] = Reception::whereYear('created_at', $this->annee)
            ->sum('montant');

            $id_depense = ModelsCaisse::where('type_caisse', '_depense')->value('id');
            $this->rapport['depense'] = Operation::where('caisse_id', $id_depense)
            ->whereYear('created_at', $this->annee)
            ->where('type_operation', '<>', 'prelevement')
            ->sum('montant_operation');

            $this->rapport['depense_perso'] = Operation::where('caisse_id', $id_depense)
            ->whereYear('created_at', $this->annee)
            ->where('type_operation', 'prelevement')
            ->sum('montant_operation');

            $this->pertes = DB::table('stocks')
            ->join('problemes', 'stocks.id', '=', 'stock_id')
            ->whereYear('problemes.created_at', $this->annee)
            ->where('type_probleme', 'avarie')
            ->select('type', DB::raw('SUM(quantite) as quantite'))
            ->groupBy('stocks.type')
            ->get();

            $this->manquants = DB::table('stocks')
            ->join('problemes', 'stocks.id', '=', 'stock_id')
            ->whereYear('problemes.created_at', $this->annee)
            ->where('type_probleme', 'manquant')
            ->select('type', DB::raw('SUM(quantite) as quantite'))
            ->groupBy('stocks.type')
            ->get();
        }
    }

    public function closeModal() {
        $this->rapport = [];
        $this->pertes = '';
    }

    public function render()
    {
        // Lors de la mise en place de l'application pour régulariser la caisse
        // ModelsCaisse::where('type_caisse', 'somme_caisse')->update([
        //     'somme_type' => 0
        // ]);

        $dette_clients = Commande::whereNull('date_reglement')->sum('montant_non_regle_type');

        $ventes = Commande::whereNotNull('date_reglement')->sum('montant_commande');

        $dette_fournisseurs = Reception::where('reglement', false)->sum('montant_non_regle');

        // recuperation des années et mois depuis l'appli 
        $this->year = Commande::selectRaw("strftime('%Y', created_at) as year")->distinct()->whereNotNull('date_reglement')->get();

        if ($this->annee) {
            $this->month = Commande::selectRaw("strftime('%m', created_at) as month")->distinct()->whereYear('created_at', $this->annee)->get();
        }

        $investissements = Reception::sum('montant');

        $somme ['somme_caisse'] = ModelsCaisse::where('type_caisse', 'somme_caisse')->value('somme_type');
        $somme ['somme_banque'] = ModelsCaisse::where('type_caisse', 'somme_banque')->value('somme_type');

        $depense = ModelsCaisse::where('type_caisse', '_depense')->value('somme_type');


        return view('livewire.caisse.caisse', [
            'dette_fournisseurs' => $dette_fournisseurs,
            'dette_clients' => $dette_clients,
            'ventes' => $ventes,
            'investissements' => $investissements,
            'year' => $this->year,
            'month' => $this->month,
            'rapport' => $this->rapport,
            'pertes' => $this->pertes,
            'manquants' => $this->manquants,
            'somme' => $somme,
            'depense' => $depense
        ]);
    }
}
