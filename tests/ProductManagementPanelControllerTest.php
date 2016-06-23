<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductManagementPanelControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function test_ProductManagementPanel()
    {
        $response = $this->call('GET','AddNewProduct');
        $this->assertEquals(200,$response->status());

        $book_details = array('title' => "Krzyżacy",
            'description' => "Opis",
            'series' => "Klasyka",
            'pages' => "512",
            'price' => 54,
            'cover' => 1);

        $this->session(['bookDetails' => $book_details]);
        $response = $this->call('GET','/AddCategories');
        $this->assertEquals(200,$response->status());

        $response = $this->call('GET','/AddAuthors');
        $this->assertEquals(200,$response->status());

        $response = $this->call('GET','/AddImg');
        $this->assertEquals(200,$response->status());


    }
}
