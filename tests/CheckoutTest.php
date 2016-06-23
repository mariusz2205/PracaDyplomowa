<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CheckoutTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
     public function test_Checkout_adress_form()
     {
         $user = factory(App\User::class)->create();
         $this->session(['Books' => [['title' => 'Krzyżacy','price'=>50,'quantity'=>3,'id'=>2]]]);
         $this->session(['ShopingCard' => [88]]);
         $this->session(['totalPrice' => 32]);


        //  $this->actingAs($user)
        //      ->visit('/AddressDetails')
        //      ->type('ul Miła 55/14','address')
        //      ->type('38475935','phone_number')
        //      ->type('Warszawa','city')
        //      ->type('32-432','postal_code')
        //      ->check('terms')
        //      ->press('Dalej')
        //      ->seePageIs('/SaveOrder');

         $this->actingAs($user)
             ->visit('/AddressDetails')
             ->press('Dalej')
             ->seePageIs('/AddressDetails');

         $WrongContent ='BŁĘDNA WARTOŚ';
         $this->visit('/AddressDetails')
             ->type('ul Miła 55/14','address')
             ->type('38475935','phone_number')
             ->type('Warszawa','city')
             ->type($WrongContent,'postal_code')
             ->check('terms')
             ->press('Dalej')
             ->seePageIs('/AddressDetails');

         $this->visit('/AddressDetails')
             ->type('ul Miła 55/14','address')
             ->type($WrongContent,'phone_number')
             ->type('Warszawa','city')
             ->type('23-324','postal_code')
             ->check('terms')
             ->press('Dalej')
             ->seePageIs('/AddressDetails');
         $WrongContent = 12;
         $this->visit('/AddressDetails')
             ->type($WrongContent ,'address')
             ->type('38475935','phone_number')
             ->type('Warszawa','city')
             ->type('23-324','postal_code')
             ->press('Dalej')
             ->seePageIs('/AddressDetails');

         $this->visit('/AddressDetails')
             ->type('ul Miła 55/14','address')
             ->type('38475935','phone_number')
             ->type($WrongContent,'city')
             ->type('23-324','postal_code')
             ->check('terms')
             ->press('Dalej')
             ->seePageIs('/AddressDetails');

     }
}
