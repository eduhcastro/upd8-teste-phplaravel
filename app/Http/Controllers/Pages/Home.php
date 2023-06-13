<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;

class Home extends Controller
{

    public function homePage()
    {
        return view('pages.home');
    }

}
