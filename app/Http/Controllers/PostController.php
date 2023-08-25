<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']); //Con esto evitamos que los usuarios entren sin que esten autentificados 
        #Con el except damos acceso a los usuarios no atenticados a los apartados que queremos 
    }
    #Aqui la funcion espera un User del modelo ya que se lko estamos pasando por la url entonces se lo debemos de pasar 
    public function index(User $user)
    {
        #Aqui estamos filtrando por usuario que es el que estamos pasando por la ruta  para mandar a traer los posts que le pertenecen a dicho usuario        
        //$posts=Post::where('user_id',$user->id)->get();#Primero hacemos la consulta despues con get traemos los resultados de esa consulta  
        $posts = Post::where('user_id', $user->id)->latest()->paginate(4); #Aqui estamos utilizando la paginacion que implementa laravel y tan solo le indicamos cuantos elementos son los que queremos mostrar en pantalla 


        return view(
            'dashboard', #Cuando mandamos llamar al dashboard tambien le vamos a pasar la informacion del usuario por un arreglo 
            [
                'user' => $user,
                'posts' => $posts #Aqui retornamos los valores hacia la vista 

            ]
        );
    }
    public function create()
    {
        return view('posts.create'); #retornamos al archivo de create.blade
    }
    public function store(Request $request)
    { #Validamos registro 
        $this->validate($request, [

            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);
        #Creamos el registro en la base de datos 
        // Post::create([
        //      'titulo'=>$request->titulo,
        //      'descripcion'=>$request->descripcion,
        //      'imagen'=>$request->imagen,
        //      'user_id'=>auth()->user()->id

        // ]);

        #Otra forma de crear registros 
        // $post=new Post; 
        // $post->titulo=$request->titulo; 
        // $post->descripcion=$request->descripcion; 
        // $post->imagen=$request->imagen; 
        // $post->user_id=auth()->user()->id; 
        // $post->save(); 

        # Tercera forma de crear registros una vez tenemos las relaciones hechas 
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);
        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post) #Le pasamos la  variable del post al show  y lo retornamos hacia la vista 
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }


    public function destroy(Post $post)
    {
        #Utilizaremos el policy que cremos 
        $this->authorize('delete', $post);
        #              aqui utilizamos el nombre del metodo que queremos usar del policy 
        #Con el delete solo eliminamos la informacion de la base de datos 
        $post->delete(); #eliminamos el post en caso de pasar esta autorizacion 
        #Elimiunando la imagen uyna vez eliminado el post de la base de datos 
        $imagen_path = public_path('uploads/' . $post->imagen); #Obtenemos la url de la imagen que queremos eliminar 
        if (File::exists($imagen_path)) {
            #Utilizaremos una duncion de php para poder eliminar una imagen 
            unlink($imagen_path); #Le pasamos la ruta de la imagen que vamos a eliminar 
        }

       

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
