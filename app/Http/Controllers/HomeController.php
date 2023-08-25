<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function __construct()
    {
    #declaramos el constructor para que se cargue primero y no permita cceder a los usuarios que no se encuentran autenticados
    $this->middleware('auth');    
    }
    
    public function __invoke()
    {
        #Esto es una consulta para extraer el id y los usuarios que se siguen 
        // traemos los datos del usuario autentiicado despues mandamos a llmar a followings obteniendo los  ids de los  usuarios a los que sigue  y con pluck buscamos por el id para despues convertirlo en array
        $ids=auth()->user()->followings->pluck('id')->toArray(); 
        $posts=Post::whereIn('user_id',$ids)->latest()->paginate(20);#Haremos el filtrado delm arreglo con la funcion whereIn pasando el elemento que va filtrar y despues el areglo que va filtrar y el paginate es para asbaer cuantos elemetnos va mostrar  
                                            #Con latest lo que realizamos es ordenar mayor a menor osea la ultima publicacion que se hizo o ultimo id registrado 
        return view('home',[#Le pasamos la variable del post para que la reconozca en la vista 
            'posts'=>$posts
        ]); 
    }
  
}
