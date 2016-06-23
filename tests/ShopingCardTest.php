<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShopingCardTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_Shoping_Card_display_view()
    {
        $this->session(['ShopingCard' => [1,2,3,4]]);

        $response = $this->call('GET','/ShopingCard');
        $this->assertEquals(200,$response->status());

        $this->assertViewHas(['books','totalPrice']);

        $books = $response->original->getData()['books'];
        $totalPrice = $response->original->getData()['totalPrice'];

        $this->assertInternalType('array', $books);
        $this->assertInternalType("float", $totalPrice);
    }

    public function test_Shoping_Card_remove_item()
    {
        //Stan początkowy
        $this->session(['ShopingCard' => [1,2,3,4]]);

        //Akcja
        $response = $this->call('GET','/RemoveItemFromShopingCard/1');

        //oczekiwany stan
        $this->assertSessionHas('ShopingCard',[2,3,4]);
    }

    public function test_Shoping_Card_remove_one_item()
    {
        $this->session(['ShopingCard' => [1,1,1,2,3,4]]);
        $response = $this->call('GET','/RemoveOneItem/1');
        $this->assertSessionHas('ShopingCard',[1,1,2,3,4]);
    }

    public function test_Shoping_Card_add_one_item()
    {
        $this->session(['ShopingCard' => [1,2]]);
        $response = $this->call('GET','/AddOneItem/1');
        $this->assertSessionHas('ShopingCard',[1,2,1]);
    }
}
