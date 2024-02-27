<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Livewire\Component;

class ApercuClient extends Component
{
    public $prenom = '', $nom = '', $societe = '', $adresse = '', $contact = '' ;

    public $query = '' ;
    public $id_client = '' ;

    public function saveClient(){
        if ($this->societe) { 
            $client = Client::create([
                'prenom' => $this->prenom,
                'nom' => $this->nom,
                'societe' => $this->societe,
                'adresse' => $this->adresse,
                'contact' => $this->contact,
            ]);
        } else {
            $client = Client::create([
                'prenom' => $this->prenom,
                'nom' => $this->nom,
                'adresse' => $this->adresse,
                'contact' => $this->contact,
            ]);
        }

        return $this->redirectRoute('client.apercu');
        
    }

    public function updateClient(Client $client){
        $this->id_client = $client->id;
        $this->prenom = $client->prenom ;
        $this->nom = $client->nom ;
        $this->societe = $client->societe ;
        $this->adresse = $client->adresse ;
        $this->contact = $client->contact ;
    }

    public function saveUpdateClient(){
        if ($this->societe) { 
            Client::where('id', $this->id_client)->update([
                'prenom' => $this->prenom,
                'nom' => $this->nom,
                'societe' => $this->societe,
                'adresse' => $this->adresse,
                'contact' => $this->contact,
            ]);
        } else {
            Client::where('id', $this->id_client)->update([
                'prenom' => $this->prenom,
                'nom' => $this->nom,
                'adresse' => $this->adresse,
                'contact' => $this->contact,
            ]);
        }
        return $this->redirectRoute('client.apercu');
    }

    public function closeModal(){
        $this->reset('id_client', 'prenom', 'nom', 'societe', 'adresse', 'contact');
    }
    public function render()
    {
        $clients = Client::orderByDesc('created_at');
        if ($this->query) {
            $clients->where(function($query){
                $query->where('prenom', 'like', "%{$this->query}%")
                ->orWhere('nom', 'like', "%{$this->query}%")
                ->orWhere('societe', 'like', "%{$this->query}%")
                ->orWhere('contact', 'like', "%{$this->query}%");
            });
        }

        $clients = $clients->paginate(25) ;
        return view('livewire.client.apercu-client', [
            'clients' => $clients,
        ]);
    }
}
