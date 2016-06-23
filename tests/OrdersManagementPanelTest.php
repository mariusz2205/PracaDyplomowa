<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class OrdersManagementPanelTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_ShowOrders()
    {
        $user = factory(App\User::class)->create();
        $this->session(['OrderNumber' => 2]);
        $this->actingAs($user)
            ->visit('/Orders')
            ->see('Numer zamówienia:</b> 2');
    }
}
