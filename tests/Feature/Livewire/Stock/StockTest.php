<?php

namespace Tests\Feature\Livewire\Stock;

use App\Livewire\Stock\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class StockTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Stock::class)
            ->assertStatus(200);
    }
}
