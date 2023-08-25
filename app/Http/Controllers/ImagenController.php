<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    //
    public function store(Request $request)
    {
       # $input=$request->all();#Aqui capturamos todos los request para saber que tipo de archivo estamos obteniendo 
                                                                
       $imagen=$request->file('file'); 
       $nombreImagen=Str::uuid().".".$imagen->extension();#Esta linea de codigo va generar un id unico para cada imagen 
       #Aqui estamos utlizando ointervetion image que es lo que vamos utilizar para poder cortar las imagenes al tamaño que queremos  despues de la instalacion de intervention image 
       $imagenServidor=Image::make($imagen);
       $imagenServidor->fit(1000,1000); 
       
       $imagenPath=public_path('uploads').'/'.$nombreImagen;#Le pasamo la ruta al path para indicarlo en donde y como se va guarda la imagen 
       $imagenServidor->save($imagenPath);#Aqui le indicamos que se va guardar 
       return response()->json(['imagen'=> $nombreImagen]);  #Guardamos el arreglo de tipo request a json 
}
}
