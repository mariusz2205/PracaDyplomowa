<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class ShopingCardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(!Session::has('ShopingCard'))
        {

            return view('welcome');
        }
        elseif(Session::has('ShopingCard'))
        {
            $items = Session::get('ShopingCard');
            if(count($items) < 1)
            {
                return view('welcome');
            }
        }
    }
}
