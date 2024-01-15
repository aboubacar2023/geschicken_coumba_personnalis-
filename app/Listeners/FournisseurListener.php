<?php

namespace App\Listeners;

use App\Events\FournisseurEvent;
use App\Models\Fournisseur;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FournisseurListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FournisseurEvent $event): void
    {
        if (!empty($event->societe)) { 
            Fournisseur::create([
                'prenom' => $event->validated['prenom'],
                'nom' => $event->validated['nom'],
                'societe' => $event->societe,
                'adresse' => $event->validated['adresse'],
                'contact' => $event->validated['contact'],
            ]);
        } else {
            Fournisseur::create([
                'prenom' => $event->validated['prenom'],
                'nom' => $event->validated['nom'],
                'adresse' => $event->validated['adresse'],
                'contact' => $event->validated['contact'],
            ]);
        }
    }
}
