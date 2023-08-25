<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    //
    public function store()
    {
        auth()->logout(); //Cerramos la sesion con auth y logout 
        return redirect()->route('login'); 
    }
}
