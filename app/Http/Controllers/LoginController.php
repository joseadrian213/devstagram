<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }
    public function store(Request $request)
    {
       
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($request->only('email', 'password'), $request->remember )) { #Aqui pasamos el request remember para poder mantener la sesion abierta 
            return back()->with('mensaje', 'Credenciales Incorrectas ');
            //El back sirve para redireccionar al usuario hacia la misma pagina en la que se encuentra pero en este caso con un mensaje por eso el whit 
        }
        return redirect()->route('posts.index',['user'=>auth()->user()->username]);#Una vbez le pasamos el parametro por la url del web tenemos que pasar el parametro tambien cuando lo redirigimos si no arrojara un error pidiendo el paramtro para que pueda funcionar 
    }
}
