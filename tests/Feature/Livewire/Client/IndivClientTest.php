<?php

namespace Tests\Feature\Livewire\Client;

use App\Livewire\Client\IndivClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class IndivClientTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(IndivClient::class)
            ->assertStatus(200);
    }
}
