<?php

namespace Tests\Feature\Livewire\Caisse;

use App\Livewire\Caisse\Caisse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CaisseTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Caisse::class)
            ->assertStatus(200);
    }
}
