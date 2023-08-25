<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    #El usuario que le estamos pasando es el usuario al que estamos siguiendo      
    public function store(User $user)
    {
        #attach sirve para utilizarlo en relaciones entre la misma tabla o distintas tablas
        #Aqui el followers es el metodo que utilizamos para la relacion 
        $user->followers()->attach(auth()->user()->id);
        return back();  
    }
    public function destroy(User $user)
    {
        #attach sirve para utilizarlo en relaciones entre la misma tabla o distintas tablas
        #Aqui el followers es el metodo que utilizamos para la relacion 
        $user->followers()->detach(auth()->user()->id);
        return back();  
    }
}
