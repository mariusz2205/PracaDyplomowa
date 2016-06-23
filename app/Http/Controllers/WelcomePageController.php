<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Http\Requests;

class WelcomePageController extends Controller
{
  public function index()
  {
    $books = Book::with('authors')->orderBy('id', 'desc')->where('available','=',1)->take(6)->get();

    return view('welcome',['books'=>$books]);
  }
}
