<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('auth.register');
    }
    public function store(Request $request) #Si le pasamos el request obtenemos los datos que son eviados por el usuario
    {   
        #Estamos reescribiendo el request para que funcione la validacion que le asignamos en el validate 
        #Modificaremos el request para recibir los datos 
        $request->request->add(['username'=> Str::slug($request->username)]);

        #  dd($request);#Una vez que se manda llamar el dd se para ahi la ejecucion del codigo 
        // dd($request->get('username')); #Aqui estamos obteniendo tan solo un valor 
        #validacion 
        #'name'=>['required','min:3'] Tambien se pueden poner las validaciones en forma de arreglo 

        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20', #con el unique le indicamos que verifique en la tabla que ese dato sera unico 
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6', #el confirmed sirve para que la cdonfirmacion de la contraseña del usuario sea igual a la password que se introduce inicialmente       
        ]);
        #Por aqui le enviamos los datos al modelo por eso llamammos a create  que es un metodo estatico 
        User::create([
            'name' => $request->name, #Rescatomos los datos del name del formulario y los enviamos al modelo 
            'username' =>$request->username,
            'email' => $request->email,
            'password' => Hash::make( $request->password)

        ]);

        #Autentificar usuario 
        // auth()->attempt([#Por medio de estos parametro vamos autentificar al  usuario 
        //     'email'=>$request->email,
        //     'password'=>$request->password
        // ]);

        //OTra forma de autentificar al usuario es la siguiente 
        auth()->attempt($request->only('email','password'));

        #Redireccionaremos al usuario 
        return redirect()->route('posts.index');

    }
}
