<?php

namespace App\Livewire\Activite;

use App\Models\Caisse;
use App\Models\Operation;
use DateTime;
use Livewire\Attributes\Validate;
use Livewire\Component;
 
class Journaliere extends Component
{
    #[Validate('numeric', message: 'Veuillez Saisir des chiffres')]
    public $montant ;

    public $encaissement = '';
    public $mode_paiement = '';
    public $motif = '';

    public function encaissementDepot() {
        $validated = $this->validate();
        if ($this->encaissement === 'caisse') {
            $id = Caisse::where('type_caisse', 'somme_caisse')->value('id');
            Caisse::where('id', $id)->increment('somme_type', $validated['montant']);
            Operation::create([
                'type_operation' => 'Encaissement Caisse', 
                'montant_operation' => $validated['montant'],
                'caisse_id' => $id
            ]);
        } else {
            $id = Caisse::where('type_caisse', 'somme_banque')->value('id');
            Caisse::where('id', $id)->increment('somme_type', $validated['montant']);
            Operation::create([
                'type_operation' => 'Encaissement Banquaire', 
                'montant_operation' => $validated['montant'],
                'caisse_id' => $id
            ]);
        }

        return $this->redirectRoute('activite-journaliere');
        
    }

    public function retraitCaisse() {
        $validated = $this->validate();

        $id_caisse = Caisse::where('type_caisse', 'somme_caisse')->value('id');
        $id_depense = Caisse::where('type_caisse', '_depense')->value('id');

        Caisse::where('id', $id_caisse)->decrement('somme_type', $validated['montant']);
        if ($this->motif === 'virement') {
            $id_banque = Caisse::where('type_caisse', 'somme_banque')->value('id');
            Caisse::where('id', $id_banque)->increment('somme_type', $validated['montant']);
        }
        Operation::create([
            'type_operation' => $this->motif, 
            'montant_operation' => $validated['montant'],
            'caisse_id' => $id_depense
        ]);
        Caisse::where('id', $id_depense)->increment('somme_type', $validated['montant']);
        return $this->redirectRoute('activite-journaliere');
    }

    public function retraitBanque() {

        $validated = $this->validate();

        $id_caisse = Caisse::where('type_caisse', 'somme_banque')->value('id');
        $id_depense = Caisse::where('type_caisse', '_depense')->value('id');

        Caisse::where('id', $id_caisse)->decrement('somme_type', $validated['montant']);
        Operation::create([
            'type_operation' => $this->motif, 
            'montant_operation' => $validated['montant'],
            'caisse_id' => $id_depense
        ]);
        Caisse::where('id', $id_depense)->increment('somme_type', $validated['montant']);
        return $this->redirectRoute('activite-journaliere');

    }
    public function depense() {
        if ($this->mode_paiement === 'espece') {
            $this->retraitCaisse();
        } else {
            $this->retraitBanque();
        }
        
        
    }
    public function render()
    {
        $maintenant = new DateTime();

        $operations = Operation::with('caisse')
        ->whereYear('created_at', $maintenant->format('Y'))
        ->whereMonth('created_at', $maintenant->format('m'))
        ->whereDay('created_at', $maintenant->format('d'))
        ->orderByDesc('created_at')
        ->get();

        $argent['caisse'] = Caisse::where('type_caisse', 'somme_caisse')->value('somme_type');
        $argent['banque'] = Caisse::where('type_caisse', 'somme_banque')->value('somme_type');
        return view('livewire.activite.journaliere', [
            'operations' => $operations,
            'argent' => $argent
        ]);
    }
}
