<?php

namespace Tests\Feature\Livewire\Activite;

use App\Livewire\Activite\Journaliere;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class JournaliereTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Journaliere::class)
            ->assertStatus(200);
    }
}
