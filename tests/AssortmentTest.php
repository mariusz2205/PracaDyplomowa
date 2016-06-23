<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AssortmentTest extends TestCase
{



    public function test_Assortment_Page_view_variables()
    {
        $response = $this->call('GET','assortment/1');
        $this->assertEquals(200,$response->status());
        $this->assertViewHas(['books','totalNumOfPages','currentPage','product_filters']);

        $books = $response->original->getData()['books'];
        $totalNumOfPages = $response->original->getData()['totalNumOfPages'];
        $currentPage = $response->original->getData()['currentPage'];
        $product_filters = $response->original->getData()['product_filters'];



        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $books);
        $this->assertInternalType("float", $totalNumOfPages);
        $this->assertInternalType("string", $currentPage);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',$product_filters);

    }

    public function test_test_Assortment_Page_categories_filters()
    {
        $this->session(['productFilters' => ['Historyczna']]);
        $response = $this->call('GET','assortment/1');
        $this->assertEquals(200,$response->status());
        $response = $this->call('GET','assortment/1');
        $books = $response->original->getData()['books'];
        $category_is_ok = false;
        foreach($books as $book)
        {
           foreach($book->categories as $category)
           {
               if($category->category == "Historyczna")
               {
                   $category_is_ok = true;
               }
           }
            $this->assertEquals(true,$category_is_ok);
            $category_is_ok = false;
        }
    }


}
