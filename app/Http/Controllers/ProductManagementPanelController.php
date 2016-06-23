<?php

namespace App\Http\Controllers;


use App\Book;
use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductManagementPanelController extends Controller
{
    public function AddNewProduct()
    {

        if(Session::has('bookDetails'))
        {
          $bookDetails = Session::get('bookDetails');
          return view('ProductManagementPanel.addNewProduct',['bookDetails'=>$bookDetails]);
        }
        return view('ProductManagementPanel.addNewProduct');
    }

    public function PostNewProduct(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|max:120',
            'description' => 'required',
            'series' => 'required|max:120',
            'pages' => 'required|max:120',
            'price' => 'required|max:120',
            'cover' => 'required|max:120',
        ]);

        $bookDetails = array('title' => $request->title,
                            'description' => $request->description,
                            'series' => $request->series,
                            'pages' => $request->pages,
                            'price' => $request->price,
                            'cover' => $request->cover);

        //$request->session()->flash('bookDetails',$bookDetails);
        Session::put('bookDetails',$bookDetails);
        return redirect()->route('AddCategories');

    }

    public function AddCategories()
    {
        if(Session::has('bookDetails'))
        {
            if(Session::has('categories'))
            {
              return view('ProductManagementPanel.AddCategories',['bookDetails' => Session::get('bookDetails'),'categories'=>Session::get('categories')]);
            }
            else
            {
              return view('ProductManagementPanel.AddCategories',['bookDetails' => Session::get('bookDetails')]);
            }
        }
        else
        {
          return redirect()->back();
        }
    }

    public function AddAuthors()
    {
        if(Session::has('bookDetails'))
        {
            if(!Session::has('categories'))
            {
                Session::put('categories',array());
            }
            if(!Session::has('authors'))
            {
                Session::put('authors',array());
            }
            return view('ProductManagementPanel.AddAuthors',['bookDetails' => Session::get('bookDetails'),'categories'=>Session::get('categories'),'authors' =>Session::get('authors')]);

        }
        else
        {
          return redirect()->back();
        }
    }

    public function AddImg()
    {
        if(Session::has('bookDetails'))
        {
            if(!Session::has('categories'))
            {
                Session::put('categories',array());
            }
            if(!Session::has('authors'))
            {
                Session::put('authors',array());
            }
            return view('ProductManagementPanel.AddImgAndConfirmProduct',['bookDetails' => Session::get('bookDetails'),'categories'=>Session::get('categories'),'authors' =>Session::get('authors')]);

        }
        else
        {
          return redirect()->back();
        }
    }



    public function PostNewCategorie(Request $request)
    {
        $this->validate($request,['categorie' => 'required|max:120']);
        if(Session::has('categories'))
        {
          $categories = Session::get('categories');

        }
        else
        {
          $categories = array();
        }

        array_push($categories,$request->categorie);

        Session::put('categories',array_unique($categories));

        return redirect()->route('AddCategories');
    }
    public function PostNewAuthor(Request $request)
    {

        $this->validate($request,['name' => 'required|max:120','surname' => 'required|max:120']);
        if(Session::has('authors'))
        {
          $authors = Session::get('authors');
        }
        else
        {
          $authors = array();
        }

        array_push($authors,['name'=>$request->name,'surname'=>$request->surname]);

        Session::put('authors',$authors);

        return redirect()->route('AddAuthors');
    }

    public function RemoveItemFromCategoriesSessionVariable($categorie, $categorie2)
    {

        if(Session::has('categories'))
        {
          $categories = Session::get('categories');
          $arrayKey = array_search($categorie,$categories);
          unset($categories[$arrayKey]);
          Session::put('categories',array_unique($categories));
          return redirect()->back();
        }
    }

    public function SimpleDisplay($x)
    {
      return $x;
    }


    public function RemoveItemFromAuthorsSessionVariable($name,$surname)
    {
        if(Session::has('authors'))
        {
          $authors = Session::get('authors');

          foreach ($authors as $key => $author) {
              if($author['name'] == $name && $author['surname'] == $surname)
              {
                unset($authors[$key]);
                break;
              }
          }
          Session::put('authors',$authors);
        }
        return redirect()->back();
    }






    public function AddImgAndConfirmProduct(Request $request)
    {

        if (!Session::has('bookDetails'))
        {
          return redirect()->back();
        }
        if (!Session::has('categories'))
        {
          $categories = array();
        }
        else
        {
          $categories = Session::get('categories');
        }
        if (!Session::has('authors'))
        {
          $authors = array();
        }
        else
        {
          $authors = Session::get('authors');
        }

        $bookDetails = Session::get('bookDetails');

        $book = new \App\Book;
        $book->title = $bookDetails['title'];
        $book->description = $bookDetails['description'];
        $book->series = $bookDetails['series'];
        $book->pages = $bookDetails['pages'];
        $book->price = $bookDetails['price'];
        $book->cover = $bookDetails['cover'];
        $book->available = 1;
        $book->save();
        $file = $request->file('image');
        $filename = $request['title'].'_'.$book->id.'.jpg';
        if($file)
        {
            Storage::disk('local')->put($filename,File::get($file));
        }
        else
        {
            $filename = 'http://placehold.it/450x350';
        }
        $book->img = $filename;
        $book->update();

        foreach ($categories as $key => $categorieName)
        {
          $query = DB::table('categories')->where('category','=',$categorieName)->first();
          if(!$query)
          {
            $category = new \App\Category;
            $category->category = $categorieName;
            $category->save();
          }
          else
          {
            $category = \App\Category::find($query->id);
          }
          $category->books()->save($book);
        }



        foreach ($authors as $key => $author)
        {
          $query = DB::table('authors')->where('name','=',$author['name'])->where('surname','=',$author['surname'])->first();
          if(!$query )
          {
            $NewAuthor = new \App\Author;
            $NewAuthor->name = $author['name'];
            $NewAuthor->surname=$author['surname'];
            $NewAuthor->save();

          }
          else
          {
            $NewAuthor = \App\Author::find($query->id);
          }
          $NewAuthor->books()->save($book);
        }

        Session::forget('bookDetails');
        if (Session::has('categories'))
        {
          Session::forget('categories');
        }
        if (!Session::has('authors'))
        {
          Session::forget('authors');
        }
        return redirect()->route('book-details',$book->id);
    }

    public function RemoveBook($bookId)
    {
        $book = \App\Book::find($bookId);
        $book->available = 0;
        $book->update();
        return redirect()->route('assortment',1);
    }

    public function EditBook($bookId)
    {

    }

    public function PostCategory(Request $request)
    {

    }

    public function getProductImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file,200);

    }

}
