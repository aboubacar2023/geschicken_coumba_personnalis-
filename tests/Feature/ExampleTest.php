<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Fournisseur;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */

    public function test_all_route(): void
    {
        $response = $this->get('/fournisseur/apercu');
        $response->assertOk();
        // $fournisseur = Fournisseur::find(1);
        // $view = $this->view('livewire.fournisseur.indiv-fournisseur', ['id_fournisseur' => $fournisseur->id]);
        // $view->assertSee($fournisseur->id);
    }
}
