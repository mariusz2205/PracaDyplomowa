<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersManagementPanelTest extends TestCase
{
    use WithoutMiddleware;

    public function test_UsersManagementPanel_URLs()
    {
        $response = $this->call('GET','/ShowUsers/1');
        $this->assertEquals(200,$response->status());

        $response = $this->call('GET','/AddNewProduct');
        $this->assertEquals(200,$response->status());

    }


}
