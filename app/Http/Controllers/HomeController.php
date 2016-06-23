<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests;
use App\Order;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\Cast\Array_;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoriesIds = array();
        $authorsIds = array();
        $userbooksIds = array();
        $userId = Auth::user()->id;
        $orders = Order::with('books.categories')
            ->where('user_id','=',$userId)
            ->get();




        foreach($orders as $order)
        {
            foreach($order->books as $book)
            {
                foreach($book->categories as $category)
                {
                    if(!in_array($category->id, $categoriesIds, true)){
                        array_push($categoriesIds,$category->id);
                    }
                }
            }
        }

        $authors = Order::with('books.authors')
            ->where('user_id','=',$userId)
            ->get();
        foreach($orders as $order)
        {
            foreach($order->books as $book)
            {
                array_push($userbooksIds,$book->id);
                foreach($book->authors as $author)
                {
                    if(!in_array($author->id, $authorsIds, true)){
                        array_push($authorsIds,$author->id);
                    }

                }
            }
        }



        $BooksIdsArray = array();
        $BooksIdsArray2 = array();
        $BooksIds = DB::table('book_category')->whereIn('category_id',$categoriesIds)->select('book_id')->distinct()->get();
        foreach($BooksIds as $BookId)
        {
            array_push($BooksIdsArray,$BookId->book_id);
        }

        $BooksIds = DB::table('author_book')->whereIn('author_id',$authorsIds)->select('book_id')->distinct()->get();
        foreach($BooksIds as $BookId)
        {
            if(!in_array($BookId->book_id, $BooksIdsArray, true)){
                if(!in_array($BookId->book_id,$userbooksIds))
                {
                   array_push($BooksIdsArray,$BookId->book_id);
                }
            }
            else
            {
                if(!in_array($BookId->book_id,$userbooksIds))
                {
                    array_push($BooksIdsArray2,$BookId->book_id);
                }
            }
        }

        
          foreach ($BooksIdsArray as $key => $value) {
            if(!in_array($value,$BooksIdsArray2))
            {
              array_push($BooksIdsArray2,$value);
            }
          }




        $books = Book::with('authors','categories')
            ->where('available','=',1)
            ->whereIn('id',$BooksIdsArray2)
            ->whereNotIn('id',$userbooksIds)
            ->take(30)
            ->get();





        return view('assortment',['books'=>$books , 'totalNumOfPages' => 1, 'currentPage'=>1, "product_filters" => 'none']);

    }



}
