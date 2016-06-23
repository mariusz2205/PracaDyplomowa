<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use App\Order;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AssortmentController extends Controller
{
    public function DispleyAllBooks($page_num)
    {

        $currentPage = $page_num;
        $page_num--;
        $booksOnPage = 24;
        $productFiltersIds =  array();
        if(Session::has('productFilters'))
        {
            $productFilters = Session::get('productFilters');

            foreach($productFilters as $filter)
            {
                $role = Category::where('category',$filter)->select('id')->get();
                array_push($productFiltersIds,$role[0]->id);
            }
            $BooksIds = DB::table('book_category')->whereIn('category_id',$productFiltersIds)->select('book_id')->distinct()->get();
            $BooksIdsArray = array();

            foreach($BooksIds as $BookId)
            {
                array_push($BooksIdsArray,$BookId->book_id);
            }

            if(Session::has('search_product') && !empty( Session::get('search_product')))
            {

                $BooksIdsAfterSearchWord = DB::table('books')
                ->whereIn('id',$BooksIdsArray)
                ->where(function ($query) {
                        $query->where('title', 'like', '%'.Session::get('search_product').'%')
                              ->orWhere('series', 'like', '%'.Session::get('search_product').'%');
                        })
                ->select('id')
                ->get();

                $BooksIdsArray = array();
                foreach($BooksIdsAfterSearchWord as $BookId)
                {
                    array_push($BooksIdsArray,$BookId->id);
                }
            }
            $books = Book::with('authors','categories')
            ->where('available','=',1)
            ->whereIn('id',$BooksIdsArray)
            ->take($booksOnPage)
            ->skip($page_num*$booksOnPage)
            ->get();
            $totalNumOfBooks = count($BooksIdsArray);
        }
        else
        {
          $books = Book::with('authors','categories')->where('available','=',1)->take($booksOnPage)->skip($page_num*$booksOnPage)->get();
          $totalNumOfBooks = Book::query();
          $totalNumOfBooks = $totalNumOfBooks->count();
        }

        $totalNumOfPages = ceil($totalNumOfBooks/$booksOnPage);
        $categories= Category::distinct()->get(['category']);

        return view('assortment',['books'=>$books , 'totalNumOfPages' => $totalNumOfPages, 'currentPage'=>$currentPage, "product_filters" => $categories]);
    }

    public function DispleyBookDetails($book_id)
    {
        $book = Book::with('authors','categories')->find($book_id);
        $main_book = Book::with('authors','categories')->find($book_id);

        $categoriesIds = array();
        $authorsIds = array();
        $userbooksIds = array();

        if (Auth::check())
        {
          $userId = Auth::user()->id;
          $orders = Order::with('books.categories')
              ->where('user_id','=',$userId)
              ->get();

          foreach($orders as $order)
          {
              foreach($order->books as $book1)
              {
                  array_push($userbooksIds,$book1->id);
              }
          }
        }



        foreach($book->categories as $category)
        {
            if(!in_array($category->id, $categoriesIds, true)){
                array_push($categoriesIds,$category->id);
            }
        }

        foreach($book->authors as $author)
        {
            if(!in_array($author->id, $authorsIds, true)){
                array_push($authorsIds,$author->id);
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
            if(!in_array($BookId->book_id,$userbooksIds))
            {
                array_push($BooksIdsArray,$BookId->book_id);
            }
        }

        if(count($BooksIdsArray)<6)
        {
            $IdsNeeded = 6 - count($BooksIdsArray);
            $books = Book::with('authors')
                ->where('available','=',1)
                ->whereNotIn('id',$BooksIdsArray)
                ->take($IdsNeeded)
                ->get();
            foreach($books as $book)
            {
                array_push($BooksIdsArray,$book->id);
            }
        }

        $Recomendedbooks = Book::with('authors')
            ->where('available','=',1)
            ->whereIn('id',$BooksIdsArray)
            ->whereNotIn('id',array($book_id))
            ->take(6)
            ->get();

        return view('book-details',['book' => $main_book,'Recomendedbooks'=>$Recomendedbooks]);
    }

    public function setProductFiltersSessionVariable(Request $request)
    {
        $filtersArray = array();
        if(count($request->productFilters)>0)
        {
            if(Session::has('productFilters'))
            {
                Session::forget('productFilters');
            }

            foreach($request->productFilters as $category)
            {
                array_push($filtersArray,$category);
            }
            Session::put('productFilters',$filtersArray);
        }

        $searchWord = $request->search_product;
        Session::put('search_product',$searchWord);

        return redirect()->route('assortment',1);
    }


}
