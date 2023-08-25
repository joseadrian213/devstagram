<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request,User $user,Post $post)#Aqui vamos a pasar user y post por que vamos utilizar post pero tenemos que  pasar user si no arrojara un error 
    {

       //validar 
        $this->validate($request,[
            'comentario'=>'required|max:255'
        ]); 

       //almacenar el resultado 
       Comentario::create([
        'user_id'=>auth()->user()->id,#Obtenemos los id para rellenar las tablas pivote con el usuario autenticado  y el post que estamos conectando 
        'post_id'=> $post->id,
        'comentario'=>$request->comentario
       ]);
       //imprimir un mensaje
            #Lo redirigimos a la misma pagina despues le  enviamos un aviso con mensaje y despues colocamos el mensaje que queremos que vea el usariuo 
       return back()->with('mensaje','Comentario realizado corectamente');
    }
}
